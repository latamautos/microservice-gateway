<?php
/**
 * Created by PhpStorm.
 * User: xavier
 * Date: 5/6/15
 * Time: 2:46 PM
 */

namespace Latamautos\MicroserviceGateway\core;
use JMS\Serializer\Annotation\Type;


class NotificationDTO {

	/**
	 * @Type("ArrayCollection<string>")
	 */
	protected $errorMessages;
	/**
	 * @Type("ArrayCollection<string>")
	 */
	protected $warningMessages;
	/**
	 * @Type("ArrayCollection<string>")
	 */
	protected $successMessages;
	/**
	 * @Type("ArrayCollection<string,Latamautos\MicroserviceGateway\core\NotificationDTO >")
	 */
	protected $linkedMessages;

	/**
	 * @return mixed
	 */
	public function getErrorMessages() {
		return $this->errorMessages;
	}

	/**
	 * @return mixed
	 */
	public function getLinkedMessages() {
		return $this->linkedMessages;
	}

	/**
	 * @return mixed
	 */
	public function getSuccessMessages() {
		return $this->successMessages;
	}

	/**
	 * @return mixed
	 */
	public function getWarningMessages() {
		return $this->warningMessages;
	}

	/**
	 * @param mixed $errorMessages
	 */
	public function setErrorMessages($errorMessages) {
		$this->errorMessages = $errorMessages;
	}

	/**
	 * @param mixed $linkedMessages
	 */
	public function setLinkedMessages($linkedMessages) {
		$this->linkedMessages = $linkedMessages;
	}

	/**
	 * @param mixed $successMessages
	 */
	public function setSuccessMessages($successMessages) {
		$this->successMessages = $successMessages;
	}

	/**
	 * @param mixed $warningMessages
	 */
	public function setWarningMessages($warningMessages) {
		$this->warningMessages = $warningMessages;
	}






} 