<?php
/**
 * Created by PhpStorm.
 * User: xavier
 * Date: 5/6/15
 * Time: 5:28 PM
 */

namespace core;


use JMS\Serializer\Annotation\Type;
use Latamautos\MicroserviceGateway\core\BaseResponse;
use Latamautos\MicroserviceGateway\core\NotificationParser;
use PHPUnit_Framework_TestCase;

class NotificationParserTest extends PHPUnit_Framework_TestCase {

	private $deserializedArrayResponseMother ;
	private $deserializedArray;
	private $notificationParser;
	private $baseResponse;

	function __construct() {
		$this->deserializedArrayResponseMother = new DeserializedArrayResponseMother();
		$this->deserializedArray = $this->deserializedArrayResponseMother->getDeserializedArrayResponseMother();
		$this->notificationParser = new NotificationParser();
		$this->baseResponse = new BaseResponse();

	}


	public function test_GenerateFromDeserializedArray_WhenValidArguments_ShouldReturnResponseWithNotifications(){
		$type = new Type();

		$baseResponse=$this->notificationParser->generateFromDeserializedArray($this->deserializedArray, $this->baseResponse);

		$this->assertTrue($baseResponse->getMessages()!=null);
	}



} 