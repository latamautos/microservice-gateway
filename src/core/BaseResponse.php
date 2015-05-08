<?php
/**
 * Created by PhpStorm.
 * User: xavier
 * Date: 5/6/15
 * Time: 2:34 PM
 */

namespace Latamautos\MicroserviceGateway\core;


class BaseResponse {

	protected $messages;
	protected $page;
	protected $size;
	protected $totalItems;
	protected $totalPages;
	protected $orderBy;
	protected $desc;
	protected $status;
	protected $data;

	public function setPagination($page, $size, $totalItems, $totalPages, $orderBy, $desc) {

		$this->page = $page;
		$this->size = $size;
		$this->totalItems = $totalItems;
		$this->totalPages = $totalPages;
		$this->orderBy = $orderBy;
		$this->desc = $desc;
	}

	/**
	 * @param mixed $messages
	 */
	public function setMessages(NotificationDTO $messages) {
		$this->messages = $messages;
	}

	/**
	 * @param mixed $data
	 */
	public function setData($data) {
		$this->data = $data;
	}

	/**
	 * @return mixed
	 */
	public function getMessages() {
		return $this->messages;
	}

	/**
	 * @return mixed
	 */
	public function getDesc() {
		return $this->desc;
	}

	/**
	 * @return mixed
	 */
	public function getOrderBy() {
		return $this->orderBy;
	}

	/**
	 * @return mixed
	 */
	public function getPage() {
		return $this->page;
	}

	/**
	 * @return mixed
	 */
	public function getSize() {
		return $this->size;
	}

	/**
	 * @return mixed
	 */
	public function getTotalItems() {
		return $this->totalItems;
	}

	/**
	 * @return mixed
	 */
	public function getTotalPages() {
		return $this->totalPages;
	}

	/**
	 * @return mixed
	 */
	public function getData() {
		return $this->data;
	}

	/**
	 * @param mixed $status
	 */
	public function setStatus($status) {
		$this->status = $status;
	}





}