<?php
/**
 * Created by PhpStorm.
 * User: xavier
 * Date: 5/20/15
 * Time: 2:12 PM
 */

namespace Latamautos\MicroserviceGateway\core;


class ArrayCollection extends \Doctrine\Common\Collections\ArrayCollection {


	function __construct() {
		parent::__construct();
	}

	public function findById($id) {
		$resultArray = $this->filter(function ($entry) use ($id) {
			return is_object($entry) && method_exists($entry, "getId") && $entry->getId() == $id;
		});
		if (!empty($resultArray) && is_array($resultArray)) {
			return $resultArray[0];
		}
		return null;
	}
}