<?php
//require_once 'File/IMC.php';
require_once 'my_vcard_parse.php';
require_once 'my_vcard_build.php';
require_once 'class_vcard_db.php';

//define ( 'ERR_NO_SUCH_VCARD', - 11 );

/**
 *
 * @author chunsheng
 */
class class_vCard {
	//private static $db_config;
	private $obj_vcard_source;
	private $_parser;
	private $_builder;
	private $vCard_Explanatory_Properties;
	private $vCard_Identification_Properties;
	private $vCard_Delivery_Addressing_Properties_ADR;
	private $vCard_Delivery_Addressing_Properties_LABEL;
	private $vCard_Geographical_Properties;
	private $vCard_Organizational_Properties;
	private $vCard_Telecommunications_Addressing_Properties_Email;
	private $vCard_Telecommunications_Addressing_Properties_Tel;

	function __construct() {

//		$this->_parse =  new my_vcard_parse;
//		$this->_builder  = new my_vcard_build;

		$this->obj_vcard_source = new class_vcard_db ( );
		if (! ($this->obj_vcard_source instanceof PDO)) {
			return 0;
		}
	}

	function __destruct() {
		if ($this->obj_vcard_source) {
			unset ( $this->obj_vcard_source );
		}
	}

	/**
	 * =======//@param $key = array('UID') || $key = array('idvCard_Explanatory_Properties')
	 * @return the $vCard_Explanatory_Properties
	 */
	public function get_VCard_Explanatory_Properties() {
		//		$this->vCard_Explanatory_Properties = self::$obj_vcard_source->get_vCard_Explanatory_Properties($key);
		return $this->vCard_Explanatory_Properties;
	}

	/**
	 * @param array $vCard_Explanatory_Properties
	 * @param field_type $vCard_Explanatory_Properties
	 */
	public function set_VCard_Explanatory_Properties($vCard_Explanatory_Properties) {
		$this->vCard_Explanatory_Properties = $vCard_Explanatory_Properties;
	}

	/**
	 * ========@param array('vCard_Explanatory_Properties_idvCard_Explanatory_Properties')
	 * ========     or array('idvCard_Identification_Properties')
	 * @return the $vCard_Identification_Properties
	 */
	public function get_VCard_Identification_Properties($key) {
		//		$this->vCard_Identification_Properties = self::$obj_vcard_source->get_vCard_Identification_Properties($key);
		return $this->vCard_Identification_Properties;
	}

	/**
	 * @param field_type $vCard_Identification_Properties
	 */
	public function set_VCard_Identification_Properties($vCard_Identification_Properties) {
		$this->vCard_Identification_Properties = $vCard_Identification_Properties;
	}

	/**
	 * @return the $vCard_Delivery_Addressing_Properties_ADR
	 */
	public function get_VCard_Delivery_Addressing_Properties_ADR() {
		return $this->vCard_Delivery_Addressing_Properties_ADR;
	}

	/**
	 * @param field_type $vCard_Delivery_Addressing_Properties_ADR
	 */
	public function set_VCard_Delivery_Addressing_Properties_ADR($vCard_Delivery_Addressing_Properties_ADR) {
		$this->vCard_Delivery_Addressing_Properties_ADR = $vCard_Delivery_Addressing_Properties_ADR;
	}

	/**
	 * @return the $vCard_Delivery_Addressing_Properties_LABEL
	 */
	public function get_VCard_Delivery_Addressing_Properties_LABEL() {
		return $this->vCard_Delivery_Addressing_Properties_LABEL;
	}

	/**
	 * @param field_type $vCard_Delivery_Addressing_Properties_LABEL
	 */
	public function set_VCard_Delivery_Addressing_Properties_LABEL($vCard_Delivery_Addressing_Properties_LABEL) {
		$this->vCard_Delivery_Addressing_Properties_LABEL = $vCard_Delivery_Addressing_Properties_LABEL;
	}

	/**
	 * @return the $vCard_Geographical_Properties
	 */
	public function get_VCard_Geographical_Properties() {
		return $this->vCard_Geographical_Properties;
	}

	/**
	 * @param field_type $vCard_Geographical_Properties
	 */
	public function set_VCard_Geographical_Properties($vCard_Geographical_Properties) {
		$this->vCard_Geographical_Properties = $vCard_Geographical_Properties;
	}

	/**
	 * @return the $vCard_Organizational_Properties
	 */
	public function get_VCard_Organizational_Properties() {
		return $this->vCard_Organizational_Properties;
	}

	/**
	 * @param field_type $vCard_Organizational_Properties
	 */
	public function set_VCard_Organizational_Properties($vCard_Organizational_Properties) {
		$this->vCard_Organizational_Properties = $vCard_Organizational_Properties;
	}

	/**
	 * @return the $vCard_Telecommunications_Addressing_Properties_Email
	 */
	public function get_VCard_Telecommunications_Addressing_Properties_Email() {
		return $this->vCard_Telecommunications_Addressing_Properties_Email;
	}

	/**
	 * @param field_type $vCard_Telecommunications_Addressing_Properties_Email
	 */
	public function set_VCard_Telecommunications_Addressing_Properties_Email($vCard_Telecommunications_Addressing_Properties_Email) {
		$this->vCard_Telecommunications_Addressing_Properties_Email = $vCard_Telecommunications_Addressing_Properties_Email;
	}

	/**
	 * @return the $vCard_Telecommunications_Addressing_Properties_Tel
	 */
	public function get_VCard_Telecommunications_Addressing_Properties_Tel() {
		return $this->vCard_Telecommunications_Addressing_Properties_Tel;
	}

	/**
	 * @param field_type $vCard_Telecommunications_Addressing_Properties_Tel
	 */
	public function set_VCard_Telecommunications_Addressing_Properties_Tel($vCard_Telecommunications_Addressing_Properties_Tel) {
		$this->vCard_Telecommunications_Addressing_Properties_Tel = $vCard_Telecommunications_Addressing_Properties_Tel;
	}

	/**
	 * @prarm text $vcard_text
	 */
	public function parse_vcard($vcard_text) {
		if (! ($this->_parser instanceof my_vcard_parse)) {
			try {
				$this->_parser = new my_vcard_parse;
			} catch (Exception $e) {
				return NULL;
			}
		}

		if (!($this->_builder instanceof my_vcard_build)) {
			try {
				$this->_builder = new my_vcard_build;
			} catch (Exception $e) {
				return NULL;
			}
		}

		$data = $this->_parser->fromText ( $vcard_text );
		$this->_builder->setFromArray($this->_parse->get_parse_data());

		$this->set_VCard_Explanatory_Properties ( array(
											'UID' => $this->_builder->getUniqueID(),
											'REV' => $this->_builder->getRevision(),
											'VERSION' => $this->_parser->getVersion(),
											'LANGAGE' => $this->_builder->getLanguage(),
											'CATEGORIES' => $this->_builder->getCategories(),
											'PRODID' => $this->_builder->getProductID(),
											'SORT-STRING' => $this->_builder->getSortString()
											)

											/*array (
												'UID' => $data ['VCARD'] [0] ['UID'] [0] ['value'] [0] [0],
												'VERSION' => $data ['VCARD'] [0] ['VERSION'] [0] ['value'] [0] [0],
												'REV' => $data ['VCARD'] [0] ['REV'] [0] ['value'] [0] [0],
												'LANG' => $data ['VCARD'] [0] ['LANG'] [0] ['value'] [0] [0]
												)*/
												 );
		$this->set_VCard_Identification_Properties ( array (
												'FN' => $this->_builder->getFormattedName(),
												'N' => $this->_builder->getName(),
												'NICKNAME' => $this->_builder->getNickname(),
												'PHOTO' => $this->_builder->getPhoto(),
												'PhotoType' => $this->_builder->getPhotoType(),
												'BDAY' => $this->_builder->getBirthday(),
												'URL' => $this->_builder->getURL(),
												'SOUND'=> $this->_builder->getSound(),
												'NOTE'=> $this->_builder->getNote()
												) );
		/*
		 * there are more than one 'ADR' comp
		*/
		$this->set_VCard_Delivery_Addressing_Properties_ADR(
												$this->_builder->getGroupComp('ADR')
												);
		/*
		 * there are more than on 'LABLE' comp
		 */
		$this->set_VCard_Delivery_Addressing_Properties_LABEL(
												$this->_builder->getGroupComp('LABEL')
												);

		$this->set_VCard_Telecommunications_Addressing_Properties_Tel(
												$this->_builder->getGroupComp('Tel')
												);
		$this->set_VCard_Telecommunications_Addressing_Properties_Email(
												$this->_builder->getGroupComp('Email')
												);
		$this->set_VCard_Organizational_Properties(array(

												));
		$this->set_VCard_Geographical_Properties(array(
												'TZ' => $this->_builder->getTz(),
												'GEO' => $this->_builder->getGeo()
												));




	}

	/**
	 *
	 * @param $key = array('UID' => $UID) or array('idvCard_Explanatory_Properties' =>$idvCard_Explanatory_Properties)
	 */
	public function get_vcard_from_storage($key) {

	}

	public function print_parse_data() {
		print_r( $this->_parse->get_parse_data());
	}

	/**
	 *
	 * @param array('UID' => $UID,'idvCard_Explanatory_Properties' =>$idvCard_Explanatory_Properties,'property'='' )
	 * @return array
	 */

	public function get_vcard_property_from_storage($key) {
		$tmp_array = array ();
		if (array_key_exists ( 'UID', $key )) {
			$tmp_array = array ('UID' => $key ['UID'] );
		} elseif (array_key_exists ( 'idvCard_Explanatory_Properties', $key )) {
			$tmp_array = array ('idvCard_Explanatory_Properties' => $key ['idvCard_Explanatory_Properties'] );
		}

		if (! in_array ( $key ['property'], array ('vCard_Explanatory_Properties', 'vCard_Identification_Properties', 'vCard_Delivery_Addressing_Properties_ADR', 'vCard_Delivery_Addressing_Properties_LABEL', 'vCard_Geographical_Properties', 'vCard_Organizational_Properties', 'vCard_Telecommunications_Addressing_Properties_Email', 'vCard_Telecommunications_Addressing_Properties_Tel' ), true )) {
			return NULL;
		}
		try {
			$this->set_VCard_Explanatory_Properties ( self::$obj_vcard_source->get_vCard_Explanatory_Properties ( $tmp_array ) );
		} catch ( Exception $e ) {
			print_r ( $e );
		}
		switch ($key ['property']) {
			case 'vCard_Explanatory_Properties' :
				return $this->vCard_Explanatory_Properties;
				break;
			case 'vCard_Identification_Properties' :
				$this->vCard_Identification_Properties = self::$obj_vcard_source->get_vCard_Identification_Properties ( array ('idvCard_Explanatory_Properties' => $this->vCard_Explanatory_Properties ['idvCard_Explanatory_Properties'] ) );
				return $this->vCard_Identification_Properties;
				break;
			case 'vCard_Delivery_Addressing_Properties_ADR' :
				$this->vCard_Delivery_Addressing_Properties_ADR = self::$obj_vcard_source->get_vCard_Delivery_Addressing_Properties_ADR ( array ('idvCard_Explanatory_Properties' => $this->vCard_Explanatory_Properties ['idvCard_Explanatory_Properties'] ) );
				return $this->vCard_Delivery_Addressing_Properties_ADR;
				break;
			case 'vCard_Delivery_Addressing_Properties_LABEL' :
				$this->vCard_Delivery_Addressing_Properties_LABEL = self::$obj_vcard_source->get_vCard_Delivery_Addressing_Properties_LABEL ( array ('idvCard_Explanatory_Properties' => $this->vCard_Explanatory_Properties ['idvCard_Explanatory_Properties'] ) );
				return $this->vCard_Delivery_Addressing_Properties_LABEL;
				break;
			case 'vCard_Geographical_Properties' :
				$this->vCard_Geographical_Properties = self::$obj_vcard_source->get_vCard_Geographical_Properties ( array ('idvCard_Explanatory_Properties' => $this->vCard_Explanatory_Properties ['idvCard_Explanatory_Properties'] ) );
				return $this->vCard_Geographical_Properties;
				break;
			case 'vCard_Organizational_Properties' :
				$this->vCard_Organizational_Properties = self::$obj_vcard_source->get_vCard_Organizational_Properties ( array ('idvCard_Explanatory_Properties' => $this->vCard_Explanatory_Properties ['idvCard_Explanatory_Properties'] ) );
				return $this->vCard_Organizational_Properties;
				break;
			case 'vCard_Telecommunications_Addressing_Properties_Email' :
				$this->vCard_Telecommunications_Addressing_Properties_Email = self::$obj_vcard_source->get_vCard_Telecommunications_Addressing_Properties_Email ( array ('idvCard_Explanatory_Properties' => $this->vCard_Explanatory_Properties ['idvCard_Explanatory_Properties'] ) );
				return $this->vCard_Telecommunications_Addressing_Properties_Email;
				break;
			case 'vCard_Telecommunications_Addressing_Properties_Tel' :
				$this->vCard_Telecommunications_Addressing_Properties_Tel = self::$obj_vcard_source->get_vCard_Telecommunications_Addressing_Properties_Tel ( array ('idvCard_Explanatory_Properties' => $this->vCard_Explanatory_Properties ['idvCard_Explanatory_Properties'] ) );
			default :
				return $this;
				break;
		}
	}

	/**
	 *
	 * @param unknown_type $vcard
	 */
	public function insert_vcard_property_into_storage($vcard) {
		;
	}

	private static function checkExistVcardByUid($uid) {
		if (0 != $count = self::$obj_vcard_source->checkExistVcardRecordByUid ( $uid )) {
			return $count;
		} else {
			return 0;
		}
	}

//	public static function getVcardByIdentifiedUid($uid) {
//		if (! checkExistVcardByUid ( $uid )) {
//			return ERR_NO_SUCH_VCARD;
//		} else {
//			//return buildVcardByUid($uid);
//		}
//	}
}

?>