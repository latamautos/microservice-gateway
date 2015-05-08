<?php
/**
 * Created by PhpStorm.
 * User: xavier
 * Date: 5/6/15
 * Time: 5:26 PM
 */

namespace core;


class DeserializedArrayResponseMother {

	function getDeserializedArrayResponseMother() {
		return [
			"pagination" => [
				"size" => 20,
				"page" => 1,
				"total_items" => 40,
				"total_pages" => 2,
				"order_by" => null,
				"desc" => false
			],
			"messages" => [
				"error_messages" => [
					"Error Message"
				],
				"warning_messages" => [
					"Warning Message"
				],
				"success_messages" => [
					"Success Message"
				],
				"linked_messages" => [
					"id" => [
						"error_messages" => [
							"Error Message"
						],
						"warning_messages" => [
							"Warning Message"
						],
						"success_messages" => [
							"Success Message"
						]
					]
				]


			],
			"data"=>[
				[
					"arg1"=>1,
					"arg2"=>2,
					"arg3"=>3,
				],
				[
					"arg1"=>1,
					"arg2"=>2,
					"arg3"=>3,
				]
			]
		];
	}
}