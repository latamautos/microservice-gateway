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
use Latamautos\MicroserviceGateway\core\PaginationParser;
use PHPUnit_Framework_TestCase;

class PaginationParserTest extends PHPUnit_Framework_TestCase {

	private $deserializedArrayResponseMother ;
	private $deserializedArray;
	private $paginationParser;
	private $baseResponse;

	function __construct() {
		$type = new Type();
		$this->deserializedArrayResponseMother = new DeserializedArrayResponseMother();
		$this->deserializedArray = $this->deserializedArrayResponseMother->getDeserializedArrayResponseMother();
		$this->paginationParser = new PaginationParser();
		$this->baseResponse = new BaseResponse();

	}


	public function test_GenerateFromDeserializedArray_WhenValidArguments_ShouldReturnResponseWithNotifications(){


		$baseResponse=$this->paginationParser->generateFromDeserializedArray($this->deserializedArray, $this->baseResponse);
		$this->assertTrue($baseResponse->getPage()!=null);
		$this->assertTrue($baseResponse->getSize()!=null);
		$this->assertTrue($baseResponse->getTotalItems()!=null);
		$this->assertTrue($baseResponse->getTotalPages()!=null);
	}



} 