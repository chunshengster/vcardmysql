<?php

/**
 * @author chunsheng
 *
 *
 */
require_once 'File/IMC.php';
final class my_vcard_parse extends File_IMC_Parse_Vcard{

	function __construct() {
		return  File_IMC::parse('vCard');

	}

	/**
	 *
	 */

	function __destruct() {

	}
	public function get_parse_data() {
//		print_r($this->data);
		return $this->data['VCARD'];
	}
}

?>