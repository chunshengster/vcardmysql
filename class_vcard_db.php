<?php

/**
 * @author chunsheng
 * use mysql for vCard backend
 * @date
 * @ver
 */

class class_vcard_db {
	private static $vcard_db_para_file = "./config/config.ini";
	public static $dbh = null;
	public static $db_host = null;
	public static $db_port = null;
	public static $db_user = null;
	public static $db_pass = null;
	public static $db_driver = null;
	public static $db_name = null;

	private static $vCard_Explanatory_Properties = 'vCard_Explanatory_Properties';
	private static $vCard_Identification_Properties = 'vCard_Identification_Properties';
	private static $vCard_Delivvery_Addressing_Properties_ADR = 'vCard_Delivery_Addressing_Properties_ADR';
	private static $vCard_Delivvery_Addressing_Properties_LABEL = 'vCard_Delivery_Addressing_Properties_LABEL';
	private static $vCard_Geographical_Properties = 'vCard_Geographical_Properties';
	private static $vCard_Organizational_Properties = 'vCard_Organizational_Properties';
	private static $vCard_Telecommunications_Addressing_Properties_Email = 'vCard_Telecommunications_Addressing_Properties_Email';
	private static $vCard_Telecommunications_Addressing_Properties_Tel = 'vCard_Telecommunications_Addressing_Properties_Tel';

	function __construct() {
		self::getMysqlPara ();
		self::$dbh = self::getInstance ();
	}

	function __destruct() {
		if(self::$dbh){
			unset ( self::$dbh );
		}
	}

	private static function getInstance() {
		$dsn = self::$db_driver . ":host=" . self::$db_host . ":" . self::$db_port . ";dbname=" . self::$db_name;
		print $dsn;
		print "<br>\n";
		try {
			$dbh = new PDO ( $dsn, self::$db_user, self::$db_pass, array (PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8" ) );
			return $dbh;
		} catch ( PDOException $err ) {
			print_r ( $err );
		}
	}

	private static function getMysqlPara() {
		$config_data = parse_ini_file ( self::$vcard_db_para_file, 'vcard_db' );

		self::$db_driver = $config_data ['vcard_db'] ['driver'];
		self::$db_host = $config_data ['vcard_db'] ['mysql_host'];
		self::$db_port = $config_data ['vcard_db'] ['mysql_port'];
		self::$db_name = $config_data ['vcard_db'] ['db_name'];
		self::$db_user = $config_data ['vcard_db'] ['db_user'];
		self::$db_pass = $config_data ['vcard_db'] ['db_pass'];
	}

	/*	public function get_vCard_Attr($attr_name, $key) {
		if (! isset ( self::$attr_name )) {
			print "Error ,tb_" . $attr_name . "\n<br>";
			return NULL;
		}
		switch ($attr_name) {
			case self::$vCard_Explanatory_Properties :
				$sql = '';
				break;
			case self::$vCard_Identification_Properties :
				$sql = '';
				break;
			case self::$vCard_Telecommunications_Addressing_Properties_Tel :
				$sql = '';
				break;
			case self::$vCard_Telecommunications_Addressing_Properties_Email :
				$sql = '';
				break;
			case self::$vCard_Delivvery_Addressing_Properties_LABEL :
				$sql = '';
				break;
			case self::$vCard_Delivvery_Addressing_Properties_ADR :
				$sql = '';
				break;
			case self::$vCard_Organizational_Properties :
				$sql = '';
				break;
			case self::$vCard_Geographical_Properties :
				$sql = '';
				break;
			default :
				return NULL;
		}
		return 1;
	}
*/
	/*
  	* @param: array('idvCard_Explanatory_Properties') or array('UID')
  	*
  	*/
	public function get_vCard_Explanatory_Properties($key) {
		//        $sql = '';
		if (key ( $key ) !== 'idvCard_Explanatory_Properties' or key ( $key ) !== 'UID') {
			return NULL;
		}
		return self::_get_vcard_data_from_db ( 'vCard_Explanatory_Properties', $key );
		/*
		$sql = "Select * From " . self::$vCard_Explanatory_Properties . " Where " . key ( $key ) . " = :KEY";
		$sth = self::$dbh->prepare ( $sql );
		$sth->bindParam ( ':KEY', $key [key ( $key )] );
		$sth->execute ();
		return $sth->fetchAll ();
    */
	}

	/*
     * @param array('vCard_Explanatory_Properties_idvCard_Explanatory_Properties')
     *      or array('idvCard_Identification_Properties')
     */
	public function get_vCard_Identification_Properties($key) {
		if (key ( $key ) !== 'vCard_Explanatory_Properties_idvCard_Explanatory_Properties' or $key ( $key ) !== 'idvCard_Identification_Properties') {
			return NULL;
		}
		return self::_get_vcard_data_from_db ( 'vCard_Identification_Properties', $key );
	}

	public function get_vCard_Telecommunications_Addressing_Properties_Tel($key) {
		if (key ( $key ) !== 'vCard_Explanatory_Properties_idvCard_Explanatory_Properties' or key ( $key ) !== 'idvCard_Telecommunications_Addressing_Properties_Tel') {
			return NULL;
		}
		return self::_get_vcard_data_from_db ( 'vCard_Telecommunications_Addressing_Properties_Tel', $key );
	}

	public function get_vCard_Telecommunications_Addressing_Properties_Email($key) {
		if (key ( $key ) !== 'vCard_Explanatory_Properties_idvCard_Explanatory_Properties' or key ( $key ) !== 'idvCard_Telecommunications_Addressing_Properties_Email') {
			return NULL;
		}
		return self::_get_vcard_data_from_db ( 'vCard_Telecommunications_Addressing_Properties_Email', $key );
	}

	public function get_vCard_Delivvery_Addressing_Properties_LABEL($key) {
		if (key ( $key ) !== 'vCard_Explanatory_Properties_idvCard_Explanatory_Properties' or key ( $key ) !== 'idvCard_Delivery_Addressing_Properties_LABEL') {
			return NULL;
		}
		return self::_get_vcard_data_from_db ( 'vCard_Delivery_Addressing_Properties_LABEL', $key );
	}

	public function get_vCard_Delivvery_Addressing_Properties_ADR($key) {
		if (key ( $key ) !== 'vCard_Explanatory_Properties_idvCard_Explanatory_Properties' or key ( $key ) !== 'idvCard_Delivery_Addressing_Properties_ADR') {
			return NULL;
		}
		return self::_get_vcard_data_from_db ( 'vCard_Delivery_Addressing_Properties_ADR', $key );
	}

	public function get_vCard_Organizational_Properties($key) {
		if (key ( $key ) !== 'vCard_Explanatory_Properties_idvCard_Explanatory_Properties' or key ( $key ) !== 'idvCard_Organizational_Properties') {
			return NULL;
		}
		return self::_get_vcard_data_from_db ( 'vCard_Organizational_Properties', $key );
	}

	public function get_vCard_Geographical_Properties($key) {
		if (key ( $key ) !== 'vCard_Explanatory_Properties_idvCard_Explanatory_Properties' or key ( $key ) !== 'idvCard_Geographical_Properties') {
			return NULL;
		}
		return self::_get_vcard_data_from_db ( 'vCard_Geographical_Properties', $key );
	}

	private static function _get_vcard_data_from_db($table, $key) {
		$sql = "Select * From " . $table . " Where " . key ( $key ) . " = :KEY";
		$sth = self::$dbh->prepare ( $sql );
		$sth->bindParam ( ':KEY', $key [key ( $key )] );
		$sth->execute ();
		return $sth->fetchAll ();
	}

	public static function checkExistVcardRecordByUid($uid) {
		$FindUidSql = "SELECT count(UID) FROM " . self::$vCard_Explanatory_Properties . " WHERE UID = :UID";
		$sth = self::$dbh->prepare ( $FindUidSql );
		$sth->bindParam ( ':UID', $uid );
		$sth->execute ();
		return $sth->rowCount ();
	}
}

?>