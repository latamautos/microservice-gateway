<?php
/**
 * Created by PhpStorm.
 * User: xavier
 * Date: 5/6/15
 * Time: 3:30 PM
 */

namespace Latamautos\MicroserviceGateway\core;


use JMS\Serializer\Naming\IdenticalPropertyNamingStrategy;
use JMS\Serializer\SerializerBuilder;

class NotificationParser {

	const NOTIFICATION = "messages";
	const RESPONSE_FORMAT = "json";

	protected $responseArray;

	private $serializer;

	function __construct() {
		$this->serializer = SerializerBuilder::create()->setPropertyNamingStrategy(new IdenticalPropertyNamingStrategy())->build();
	}


	public function generateFromDeserializedArray($deserializedArray, BaseResponse $baseResponse ) {
		if ($baseResponse == null) {
			throw new \Exception("Base response cannot be null");
		}
		$this->responseArray = $deserializedArray;
		if (!isset($this->responseArray[self::NOTIFICATION])) return $baseResponse;
		$notificationArray = $this->responseArray[self::NOTIFICATION];


		$baseResponse->setMessages($this->serializer->deserialize(json_encode($notificationArray), get_class(new NotificationDTO()),self::RESPONSE_FORMAT));

		return $baseResponse;
	}


}