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
use GuzzleHttp\Exception\ServerException;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Naming\IdenticalPropertyNamingStrategy;
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
	private $processedURI;

	const QUERY = "query";

	function __construct() {
		$this->serializer = SerializerBuilder::create()->setPropertyNamingStrategy(new IdenticalPropertyNamingStrategy())->build();
		$this->paginationParser = new PaginationParser();
		$this->notificationParser = new NotificationParser();
		$this->restClient = new Client();
		$type = new Type();
	}

	public function setPathParams($pathParamsArray = array ()) {
		$this->processedURI = $this->replaceUriParams($pathParamsArray);
	}


	public function deserializeResponse($deserializedArray) {
		$baseResponse = new BaseResponse();

		$this->paginationParser->generateFromDeserializedArray($deserializedArray, $baseResponse);
		$this->notificationParser->generateFromDeserializedArray($deserializedArray, $baseResponse);

		if (!isset($deserializedArray[self::DATA])) return $baseResponse;

		if (is_scalar($deserializedArray[self::DATA])) {
			$baseResponse->setData($deserializedArray[self::DATA]);
		} else

			if (array_values($deserializedArray[self::DATA]) === $deserializedArray[self::DATA]) {
				$objectList = new ArrayCollection();

				foreach ($deserializedArray[self::DATA] as $objectAsArray) {
					$objectList->add($this->serializer->deserialize(json_encode($objectAsArray), get_class($this->dto), self::RESPONSE_FORMAT));
				}
				$baseResponse->setData($objectList);
			} else {
				$baseResponse->setData($this->serializer->deserialize(json_encode($deserializedArray[self::DATA]), get_class($this->dto), self::RESPONSE_FORMAT));
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
		$this->setPathParams();
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

	public function get(array $queryString = array ()) {
		if ($queryString == null) $queryString = array ();
		try {
			$response = $this->restClient->get($this->domain . $this->processedURI, [self::QUERY => $queryString]);
		} catch (ServerException $e) {
			$response = $e->getResponse();
		}

		return $this->createResponse($response);
	}

	public function post($body = null, array $queryString = array ()) {
		if ($queryString == null) $queryString = array ();
		$queryString = array (self::QUERY => $queryString);
		$queryString["json"] = !is_array($body) ? json_decode($this->serializer->serialize($body, "json"), true) : $body;


		try {
			$response = $this->restClient->post($this->domain . $this->processedURI, $queryString);
		} catch (ServerException $e) {
			$response = $e->getResponse();
		}

		return $this->createResponse($response);
	}

	public function put($body = null, array $queryString = array ()) {
		if ($queryString == null) $queryString = array ();
		$queryString = array (self::QUERY => $queryString);
		$queryString["json"] = !is_array($body) ? json_decode($this->serializer->serialize($body, "json"), true) : $body;
		try {
			$response = $this->restClient->put($this->domain . $this->processedURI, $queryString);
		} catch (ServerException $e) {
			$response = $e->getResponse();
		}

		return $this->createResponse($response);
	}

	public function del(array $queryString = array ()) {
		if ($queryString == null) $queryString = array ();
		try {
			$response = $this->restClient->delete($this->domain . $this->processedURI, [self::QUERY => $queryString]);
		} catch (ServerException $e) {
			$response = $e->getResponse();
		}

		return $this->createResponse($response);
	}

	public function store($body, array $queryString = array ()) {
		return $this->post($body, $queryString);
	}

	public function index(array $queryString = array ()) {
		return $this->get($queryString);
	}

	public function update($id, $body, array $queryString = array ()) {
		$args = $this->checkValidId($id);
		if ($queryString == null) $queryString = array ();
		$queryString = array (self::QUERY => $queryString);
		$queryString["json"] = !is_array($body) ? json_decode($this->serializer->serialize($body, "json"), true) : $body;
		try {
			$response = $this->restClient->put($this->domain . $this->processedURI . "/" . $id, $queryString);
		} catch (ServerException $e) {
			$response = $e->getResponse();
		}

		return $this->createResponse($response);
	}

	public function delete($id, array $queryString = array ()) {
		if ($queryString == null) $queryString = array ();
		$args = $this->checkValidId($id);

		try {
			$response = $this->restClient->delete($this->domain . $this->processedURI . "/" . $id, [self::QUERY => $queryString]);
		} catch (ServerException $e) {
			$response = $e->getResponse();
		}

		return $this->createResponse($response);
	}

	public function show($id, array $queryString = array ()) {
		if ($queryString == null) $queryString = array ();
		$args = $this->checkValidId($id);
		try {
			$response = $this->restClient->get($this->domain . $this->processedURI . "/" . $id, [self::QUERY => $queryString]);
		} catch (ServerException $e) {
			$response = $e->getResponse();
		}

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
	private function checkValidId($id) {
		if (empty($id)) {
			throw new \Exception("Invalid id for resource");
		}
		return $id;
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