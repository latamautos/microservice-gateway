<?php
/**
 * Created by PhpStorm.
 * User: xavier
 * Date: 5/6/15
 * Time: 3:30 PM
 */

namespace Latamautos\MicroserviceGateway\core;


class PaginationParser {

	const PAGINATION = "pagination";
	const  PAGE = "page";
	const SIZE = "size";
	const TOTAL_ITEMS = "totalItems";
	const TOTAL_PAGES = "totalPages";
	const ORDER_BY = "orderBy";
	const DESC = "desc";

	protected $page;
	protected $size;
	protected $totalItems;
	protected $totalPages;
	protected $orderBy;
	protected $desc;
	protected $responseArray;
	protected $baseResponse;

	public function generateFromDeserializedArray($deserializedArray, BaseResponse $baseResponse = null) {
		if ($baseResponse == null) {
			throw new \Exception("Base response cannot be null");
		}
		$this->responseArray = $deserializedArray;

		$this->setPage();
		$this->setSize();
		$this->setTotalPages();
		$this->setTotalItems();
		$this->setOrderBy();
		$this->setDesc();

		$baseResponse->setPagination($this->page, $this->size, $this->totalItems, $this->totalPages, $this->orderBy, $this->desc);


		return $baseResponse;
	}

	private function setPage() {
		if (isset($this->responseArray[self::PAGE])) {

			$this->page = $this->responseArray[self::PAGE];
		}
	}

	private function setSize() {
		if (isset($this->responseArray[self::SIZE])) {
			$this->size = $this->responseArray[self::SIZE];
		}
	}

	private function setTotalItems() {
		if (isset($this->responseArray[self::TOTAL_ITEMS])) {
			$this->totalItems = $this->responseArray[self::TOTAL_ITEMS];
		}
	}

	private function setTotalPages() {
		if (isset($this->responseArray[self::TOTAL_PAGES])) {
			$this->totalPages = $this->responseArray[self::TOTAL_PAGES];
		}
	}

	private function setOrderBy() {
		if (isset($this->responseArray[self::ORDER_BY])) {
			$this->orderBy = $this->responseArray[self::ORDER_BY];
		}
	}

	private function setDesc() {
		if (isset($this->responseArray[self::DESC])) {
			$this->desc = $this->responseArray[self::DESC];
		}
	}
}