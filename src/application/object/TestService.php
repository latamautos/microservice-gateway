<?php
/**
 * Created by PhpStorm.
 * User: xavier
 * Date: 4/29/15
 * Time: 3:22 PM
 */

namespace application\object;


use application\contract\ITestService;

class TestService implements ITestService {

	function test() {
		return "todo bien";
	}
}