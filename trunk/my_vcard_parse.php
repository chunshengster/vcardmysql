<?php

/**
 * @author chunsheng
 *
 *
 */
require_once 'File/IMC.php';
final class my_vcard_parse extends File_IMC_Parse_Vcard{

	function __construct() {
		return parent::parse('vCard');

	}

	/**
	 *
	 */

	function __destruct() {

	}
	public function get_vcard_data() {
		return $this->data;
	}
}

?>