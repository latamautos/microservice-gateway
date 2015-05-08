<?php
/**
 * Created by PhpStorm.
 * User: xavier
 * Date: 5/6/15
 * Time: 5:14 PM
 */

namespace core;
use JMS\Serializer\Annotation\Type;

class ObjectDTO {
	/**
	 * @Type("string")
	 */
	private $arg1;
	/**
	 * @Type("string")
	 */
	private $arg2;
	/**
	 * @Type("string")
	 */
	private $arg3;

	/**
	 * @param mixed $arg1
	 */
	public function setArg1($arg1) {
		$this->arg1 = $arg1;
	}

	/**
	 * @return mixed
	 */
	public function getArg1() {
		return $this->arg1;
	}

	/**
	 * @param mixed $arg2
	 */
	public function setArg2($arg2) {
		$this->arg2 = $arg2;
	}

	/**
	 * @return mixed
	 */
	public function getArg2() {
		return $this->arg2;
	}

	/**
	 * @param mixed $arg3
	 */
	public function setArg3($arg3) {
		$this->arg3 = $arg3;
	}

	/**
	 * @return mixed
	 */
	public function getArg3() {
		return $this->arg3;
	}




}