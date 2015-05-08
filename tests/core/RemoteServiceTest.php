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
use PHPUnit_Framework_TestCase;

class RemoteServiceTest extends PHPUnit_Framework_TestCase {

	private $deserializedArrayResponseMother;
	private $deserializedArray;
	private $remoteSerice;
	private $baseResponse;

	function __construct() {
		$type = new Type();
		$this->deserializedArrayResponseMother = new DeserializedArrayResponseMother();
		$this->deserializedArray = $this->deserializedArrayResponseMother->getDeserializedArrayResponseMother();
		$this->remoteSerice = new TestRemoteService();
		$this->baseResponse = new BaseResponse();
	}

	public function test_PopulateNotification_WhenValidArguments_ShouldReturnResponseWithNotifications() {

		$baseResponse = $this->remoteSerice->deserializeResponse($this->deserializedArray, true);

		$this->assertTrue($baseResponse->getData()->count() > 1);
	}

	public function test_get_WhenWhatever_ShouldReturnIsADTO() {

//		$baseResponse = $this->remoteSerice->get(["v1"=>"pepito"]);
		$this->remoteSerice->update(["v1"=>"pepito", "id"=>12], "a");

//		$this->assertTrue($baseResponse->getData()->count() > 1);
	}


}