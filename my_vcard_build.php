<?php

/**
 * @author chunsheng
 *
 *
 */
require_once 'FILe/IMC.php';
final class my_vcard_build extends File_IMC_Build_Vcard {

	function __construct() {
		return parent::builder('vCard');

	}

	/**
	 *
	 */
	function __destruct() {

	}
	public function setFromArray($source ) {
		return parent::_setFromArray($source);
	}
}

?>