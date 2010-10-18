<?php

/**
 * @author chunsheng
 *
 *
 */
require_once 'File/IMC.php';
final class my_vcard_build extends File_IMC_Build_Vcard {

	function __construct() {
		return File_IMC::build('vCard');

	}

	/**
	 *
	 */
	function __destruct() {

	}
}

?>