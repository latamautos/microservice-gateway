<?php
/**
 * Created by PhpStorm.
 * User: xavier
 * Date: 5/6/15
 * Time: 11:18 AM
 */

namespace Latamautos\MicroserviceGateway\core;


use Doctrine\Common\Collections\ArrayCollection;
use GuzzleHttp\Client;
use JMS\Serializer\SerializerBuilder;

abstract class RemoteService {

	const START_TAG_INTERPOLATION = "{";
	const END_TAG_INTERPOLATION = "}";
	const DATA = "data";
	const RESPONSE_FORMAT = "json";


	private $domain;
	private $uri;
	private $dto;
	private $serializer;
	private $paginationParser;
	private $notificationParser;
	private $restClient;

	function __construct() {
		$this->serializer = SerializerBuilder::create()->build();
		$this->paginationParser = new PaginationParser();
		$this->notificationParser = new NotificationParser();
		$this->restClient = new Client();
	}


	public function deserializeResponse($deserializedArray) {
		$baseResponse = new BaseResponse();

		$this->paginationParser->generateFromDeserializedArray($deserializedArray, $baseResponse);
		$this->notificationParser->generateFromDeserializedArray($deserializedArray, $baseResponse);

		if (!isset($deserializedArray[self::DATA])) return $baseResponse;

		if (array_values($deserializedArray) !== $deserializedArray) {
			$objectList = new ArrayCollection();

			foreach ($deserializedArray[self::DATA] as $objectAsArray) {
				$objectList->add($this->serializer->deserialize(json_encode($objectAsArray), get_class($this->dto), self::RESPONSE_FORMAT));
			}
			$baseResponse->setData($objectList);
		} else {
			$baseResponse->setData($this->serializer->deserialize($deserializedArray[self::DATA], get_class($this->dto), self::RESPONSE_FORMAT));
		}


		return $baseResponse;
	}


	public function getDomain() {
		return $this->domain;
	}

	public function getUri() {
		return $this->uri;
	}

	/**
	 * @param mixed $domain
	 */
	protected function setDomain($domain) {
		$this->domain = $domain;
	}

	/**
	 * @param mixed $uri
	 */
	protected function setUri($uri) {
		$this->uri = $uri;
	}


	public function replaceUriParams($args) {
		$tempUri = $this->uri;
		if (empty($args)) return $tempUri;
		foreach ($args as $key => $value) {

			$tempUri = str_replace($this->getComposedUriParamName($key), $value, $tempUri);
		}
		return $tempUri;
	}

	protected function getComposedUriParamName($key) {
		return self::START_TAG_INTERPOLATION . $key . self::END_TAG_INTERPOLATION;
	}

	public function get(array $args = array (), array $queryString = array (), RestPagination $restPagination = null) {
		if ($queryString == null) $queryString = array ();
		$uri = $this->replaceUriParams($args);
		$response = $this->restClient->get($this->domain . $uri, $queryString);
		return $this->createResponse($response);
	}

	public function post(array $args = array (), $body = null, array $queryString = array ()) {
		if ($queryString == null) $queryString = array ();
		$queryString["json"] = !is_array($body)?json_encode($body):$body;
		$uri = $this->replaceUriParams($args);
		$response = $this->restClient->post($this->domain . $uri, $queryString);
		return $this->createResponse($response);
	}

	public function put(array $args= array (), $body=null, array $queryString= array ()) {
		if ($queryString == null) $queryString = array ();
		$queryString["json"] = !is_array($body)?json_encode($body):$body;
		$uri = $this->replaceUriParams($args);
		$response = $this->restClient->put($this->domain . $uri, $queryString);
		return $this->createResponse($response);
	}

	public function del(array $args= array (), array $queryString= array ()) {
		if ($queryString == null) $queryString = array ();
		$uri = $this->replaceUriParams($args);
		$response = $this->restClient->put($this->domain . $uri, $queryString);
		return $this->createResponse($response);
	}

	public function store(array $args= array (), $body, array $queryString = array ()) {
		return $this->post($args, $body, $queryString);
	}

	public function index(array $args = array (), array $queryString = array (), RestPagination $restPagination = null) {
		return $this->get($args, $queryString, $restPagination);
	}

	public function update(array $args, $body, array $queryString = array ()) {
		if ($queryString == null) $queryString = array ();
		$queryString["json"] = !is_array($body)?json_encode($body):$body;
		$uri = $this->replaceUriParams($args);
		$args = $this->checkValidId($args);
		$response = $this->restClient->put($this->domain . $uri . "/" . $args["id"], $queryString);
		return $this->createResponse($response);
	}

	public function delete(array $args, array $queryString = array ()) {
		if ($queryString == null) $queryString = array ();
		$uri = $this->replaceUriParams($args);
		$args = $this->checkValidId($args);
		$response = $this->restClient->delete($this->domain . $uri . "/" . $args["id"], $queryString);
		return $this->createResponse($response);
	}

	/**
	 * @param mixed $dto
	 */
	public function setDto($dto) {
		$this->dto = $dto;
	}

	/**
	 * @param array $args
	 * @return array
	 * @throws \Exception
	 */
	private function checkValidId(array $args) {
		if (!isset($args["id"])) {
			throw new \Exception("Invalid id for resource");
		}
		return $args;
	}

	/**
	 * @param $response
	 * @return BaseResponse
	 */
	private function createResponse($response) {
		$baseResponse = $this->deserializeResponse($response->json());
		$baseResponse->setStatus($response->getStatusCode());
		return $baseResponse;
	}
}