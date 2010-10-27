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
		parent::__desctruct();
	}
	public function getLanguage() {
		return $this->getMeta('LANGUAGE') .
            $this->getValue('LANGUAGE', 0, 0);
	}
	public function getPhotoType(){
		return $this->getType('PHOTO');
	}
	public function getPhoto() {
		return parent::getPhoto();
	}
	protected function getType($comp,$iter = 0) {
		$type = $this->getParam($comp,$iter);

		return $type;
	}
	public function getAdrType($iter = 0) {
		return $this->getType('ADR',$iter);
	}
	public function getAdrValue($iter = 0) {
		return $this->getValue('ADR', $iter, FILE_IMC::VCARD_ADR_POB) . ';' .
            $this->getValue('ADR', $iter, FILE_IMC::VCARD_ADR_EXTEND) . ';' .
            $this->getValue('ADR', $iter, FILE_IMC::VCARD_ADR_STREET) . ';' .
            $this->getValue('ADR', $iter, FILE_IMC::VCARD_ADR_LOCALITY) . ';' .
            $this->getValue('ADR', $iter, FILE_IMC::VCARD_ADR_REGION) . ';' .
            $this->getValue('ADR', $iter, FILE_IMC::VCARD_ADR_POSTCODE) . ';' .
            $this->getValue('ADR', $iter, FILE_IMC::VCARD_ADR_COUNTRY);
	}
	public function getLabelType($iter = 0) {
		return $this->getType('LABEL',$iter);
	}
	public function getLabelValue($iter = 0) {
		return $this->getValue('LABEL', $iter, 0);
	}
	public function getCompCount($comp) {
		if (is_array($this->value[$comp]) or isset($this->value[$comp])) {
			return count($this->values[]);
		}elseif(isset($this->value[$comp])){
			return 1;
		}
		return 0;
	}
	public function getGroupComp($comp) {
		if (in_array($comp,array('LABEL','ADR','EMAIL','TEL'))) {
			$comp_count = $this->getCompCount($comp);
			$r_array = array();
			if($comp_count>0){
				for ($i = 0; $i < $comp_count; $i++) {
					array_push($r_array(),array(strtoupper($comp)=>$this->getValue($comp,$i,0),ucfirst(strtolower($comp)).'Type'=>$this->getType($comp,$i)));
				}
				return $r_array;
			}else{
				return 0;
			}
		}
		return 0;
	}
	public function getTz() {
		return $this->getValue('TZ', 0, 0);
	}
	public function getGeo() {
		return $this->getValue('GEO', 0, FILE_IMC_VCARD_GEO_LAT, 0) . ';' .
            $this->getValue('GEO', 0, FILE_IMC_VCARD_GEO_LON, 0);
	}
	public function getLogo() {
		return $this->getValue('LOGO', 0, 0);
	}
	public function getLogoType() {
		return $this->getMeta('LOGO');
	}
	public function getTitle() {
		return $this->getValue('TITLE', 0, 0);
	}
	public function getRole() {
		return $this->getValue('ROLE', 0, 0);
	}
	public function getAgent(){
		return $this->getValue('AGENT', 0, 0);
	}
}

?>