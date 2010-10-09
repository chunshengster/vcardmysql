<?php
require_once 'File/IMC.php';
require_once 'class_vcard_db.php';

define ( ERR_NO_SUCH_VCARD, - 11 );

class class_vCard {
	//private static $db_config;
	private static $obj_vcard_source;
	
	private $vCard_Explanatory_Properties;
	private $vCard_Identification_Properties;
	private $vCard_Delivery_Addressing_Properties_ADR;
	private $vCard_Delivery_Addressing_Properties_LABEL;
	private $vCard_Geographical_Properties;
	private $vCard_Organizational_Properties;
	private $vCard_Telecommunications_Addressing_Properties_Email;
	private $vCard_Telecommunications_Addressing_Properties_Tel;
	
	function __construct() {
		$obj_vcard_source = new class_vcard_db();
		if (! $obj_vcard_source) {
			return 0;
		}
	}
	
	function __destruct() {
		if (self::$obj_vcard_source) {
			unset ( self::$obj_vcard_source );
		}
	}
	
	
	/**
	 * @param $key = array('UID') || $key = array('idvCard_Explanatory_Properties')
	 * @return the $vCard_Explanatory_Properties
	 */
	public function get_VCard_Explanatory_Properties() {
		$this->vCard_Explanatory_Properties = self::$obj_vcard_source->get_vCard_Explanatory_Properties($key);
		return $this->vCard_Explanatory_Properties;
	}

	/**
	 * @param field_type $vCard_Explanatory_Properties
	 */
	public function setVCard_Explanatory_Properties($vCard_Explanatory_Properties) {
		$this->vCard_Explanatory_Properties = $vCard_Explanatory_Properties;
	}

	/**
	 * @return the $vCard_Identification_Properties
	 */
	public function getVCard_Identification_Properties() {
		return $this->vCard_Identification_Properties;
	}

	/**
	 * @param field_type $vCard_Identification_Properties
	 */
	public function setVCard_Identification_Properties($vCard_Identification_Properties) {
		$this->vCard_Identification_Properties = $vCard_Identification_Properties;
	}

	/**
	 * @return the $vCard_Delivery_Addressing_Properties_ADR
	 */
	public function getVCard_Delivery_Addressing_Properties_ADR() {
		return $this->vCard_Delivery_Addressing_Properties_ADR;
	}

	/**
	 * @param field_type $vCard_Delivery_Addressing_Properties_ADR
	 */
	public function setVCard_Delivery_Addressing_Properties_ADR($vCard_Delivery_Addressing_Properties_ADR) {
		$this->vCard_Delivery_Addressing_Properties_ADR = $vCard_Delivery_Addressing_Properties_ADR;
	}

	/**
	 * @return the $vCard_Delivery_Addressing_Properties_LABEL
	 */
	public function getVCard_Delivery_Addressing_Properties_LABEL() {
		return $this->vCard_Delivery_Addressing_Properties_LABEL;
	}

	/**
	 * @param field_type $vCard_Delivery_Addressing_Properties_LABEL
	 */
	public function setVCard_Delivery_Addressing_Properties_LABEL($vCard_Delivery_Addressing_Properties_LABEL) {
		$this->vCard_Delivery_Addressing_Properties_LABEL = $vCard_Delivery_Addressing_Properties_LABEL;
	}

	/**
	 * @return the $vCard_Geographical_Properties
	 */
	public function getVCard_Geographical_Properties() {
		return $this->vCard_Geographical_Properties;
	}

	/**
	 * @param field_type $vCard_Geographical_Properties
	 */
	public function setVCard_Geographical_Properties($vCard_Geographical_Properties) {
		$this->vCard_Geographical_Properties = $vCard_Geographical_Properties;
	}

	/**
	 * @return the $vCard_Organizational_Properties
	 */
	public function getVCard_Organizational_Properties() {
		return $this->vCard_Organizational_Properties;
	}

	/**
	 * @param field_type $vCard_Organizational_Properties
	 */
	public function setVCard_Organizational_Properties($vCard_Organizational_Properties) {
		$this->vCard_Organizational_Properties = $vCard_Organizational_Properties;
	}

	/**
	 * @return the $vCard_Telecommunications_Addressing_Properties_Email
	 */
	public function getVCard_Telecommunications_Addressing_Properties_Email() {
		return $this->vCard_Telecommunications_Addressing_Properties_Email;
	}

	/**
	 * @param field_type $vCard_Telecommunications_Addressing_Properties_Email
	 */
	public function setVCard_Telecommunications_Addressing_Properties_Email($vCard_Telecommunications_Addressing_Properties_Email) {
		$this->vCard_Telecommunications_Addressing_Properties_Email = $vCard_Telecommunications_Addressing_Properties_Email;
	}

	/**
	 * @return the $vCard_Telecommunications_Addressing_Properties_Tel
	 */
	public function getVCard_Telecommunications_Addressing_Properties_Tel() {
		return $this->vCard_Telecommunications_Addressing_Properties_Tel;
	}

	/**
	 * @param field_type $vCard_Telecommunications_Addressing_Properties_Tel
	 */
	public function setVCard_Telecommunications_Addressing_Properties_Tel($vCard_Telecommunications_Addressing_Properties_Tel) {
		$this->vCard_Telecommunications_Addressing_Properties_Tel = $vCard_Telecommunications_Addressing_Properties_Tel;
	}

	
	private static function checkExistVcardByUid($uid) {
		if (0 != $count = self::$obj_vcard_source->checkExistVcardRecordByUid ( $uid )) {
			return $count;
		} else {
			return 0;
		}
	}
	
	public static function getVcardByIdentifiedUid($uid) {
		if (! checkExistVcardByUid ( $uid )) {
			return ERR_NO_SUCH_VCARD;
		} else {
			//return buildVcardByUid($uid);
		}
	}
}

?>