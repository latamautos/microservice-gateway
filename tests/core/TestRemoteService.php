<?php
/**
 * Created by PhpStorm.
 * User: xavier
 * Date: 5/6/15
 * Time: 7:09 PM
 */

namespace core;


use Latamautos\MicroserviceGateway\core\BaseResponse;
use Latamautos\MicroserviceGateway\core\RemoteService;

class TestRemoteService extends RemoteService {


	function __construct() {
		parent::__construct();
		$this->setDto(new ObjectDTO());
		$this->setDomain("http://ptdev.com/");
		$this->setUri("ptx/{v1}/test-microservice-gateway");
	}



}