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
        return false;
    }

    public function getLanguage() {
        return $this->getValue('LANGUAGE', 0, 0);
    }

    public function getType($comp, $iter = 0) {
        $type = $this->getParam($comp, $iter);
        $type = explode('=', $type, 2);
        if($comp == 'TEL'){
            $this->parseTelType($type);
        }
        if($comp == 'PHOTO'){
            $this->parsePhotoType($type);
        }
        return $type[1];
    }
    
    public function parseTelType($type) {
//        $type = $this->getType($comp);
        $pattern = '/(PREF|WORK|HOME|VOICE|FAX|MSG|CELL|PAGER|BBS|CAR|VIDEO)/i';
        if(preg_match_all($pattern, $type, $matchesarray)){
            $type = strtoupper( implode(',', $matchesarray[0]));
            return $type;
        }
        return 'OTHER';
    }

    public function getBirthday() {
        return $this->getValue('BDAY', 0, 0);
    }

    /*
      public function getAdrType($iter = 0) {
      return $this->getType('ADR', $iter);
      }
     *
     */

    public function getAdrValue($iter = 0) {
        return parent::getValue('ADR', $iter, FILE_IMC::VCARD_ADR_POB) . ';' .
        parent::getValue('ADR', $iter, FILE_IMC::VCARD_ADR_EXTEND) . ';' .
        parent::getValue('ADR', $iter, FILE_IMC::VCARD_ADR_STREET) . ';' .
        parent::getValue('ADR', $iter, FILE_IMC::VCARD_ADR_LOCALITY) . ';' .
        parent::getValue('ADR', $iter, FILE_IMC::VCARD_ADR_REGION) . ';' .
        parent::getValue('ADR', $iter, FILE_IMC::VCARD_ADR_POSTCODE) . ';' .
        parent::getValue('ADR', $iter, FILE_IMC::VCARD_ADR_COUNTRY);
    }

    public function getValue($comp, $iter = 0, $part = 0, $rept = null) {
        if ($comp === 'ADR') {
            return $this->getAdrValue($iter);
        }elseif($comp === 'TEL'){
            $telValue = parent::getValue($comp, $iter, $part, $rept);
            debugLog(__FILE__,__CLASS__,__METHOD__,__LINE__,  var_export($telValue,true));
//            $telValue = $this->parseTelValue($telValue);
            return $telValue;
        }
        return parent::getValue($comp, $iter, $part, $rept);
    }
    
    public function parseTelValue($telValue) {
        $telValue = preg_replace('/\+|\s+|\-|\(|\)/', '', $telValue);
        debugLog(__FILE__,__CLASS__,__METHOD__,__LINE__,  var_export($telValue,true));
        return $telValue;
    }

    /**
      public function getLabelType($iter = 0) {
      return $this->getType('LABEL', $iter);
      }

      public function getLabelValue($iter = 0) {
      return $this->getValue('LABEL', $iter, 0);
      }
     *
     */
    public function getCompCount($comp) {
        if (is_array($this->value[$comp]) or isset($this->value[$comp])) {
            return count($this->value[$comp]);
        } elseif (isset($this->value[$comp])) {
            return 1;
        }
        return 0;
    }

    public function getGroupComp($comp) {
        if (in_array(strtoupper($comp), array('LABEL', 'ADR', 'EMAIL', 'TEL'))) {
            $comp_count = $this->getCompCount($comp);
            $r_array = array();
            if ($comp_count > 0) {
                for ($i = 0; $i < $comp_count; $i++) {
                    $comp_value = $this->getValue($comp, $i, 0);
                    debugLog(__FILE__, __METHOD__, __LINE__, var_export($comp_value, true));
                    if ($comp_value != '' and (!preg_match("/^(;)+$/", $comp_value))) {
                        array_push($r_array, array(strtoupper($comp) => $this->getValue($comp, $i, 0), ucfirst(strtolower($comp)) . 'Type' => $this->getType($comp, $i)));
                    }
                }
                return $r_array;
                
            } else {
                return array();
            }
        }
        return array();
    }

    public function getTz() {
        return $this->getValue('TZ', 0, 0);
    }

    /**
     * there is a bug in FILE_IMC_BUILD_VCARD , in function getGeo();
     */
    public function getGeo() {

        return $this->getValue('GEO', 0, FILE_IMC::VCARD_GEO_LAT, 0) . ';' .
        $this->getValue('GEO', 0, FILE_IMC::VCARD_GEO_LON, 0);
    }

    public function getLogo() {
        return $this->getValue('LOGO', 0, 0);
    }

    public function getOrg() {
        return $this->getValue('ORG', 0, 0);
    }

    /**
      public function getLogoType() {
      return $this->getType('LOGO');
      }
     *
     */
    public function getTitle() {
        return $this->getValue('TITLE', 0, 0);
    }

    public function getRole() {
        return $this->getValue('ROLE', 0, 0);
    }

    public function getAgent() {
        return $this->getValue('AGENT', 0, 0);
    }

    public function getFormattedName() {
        return $this->getValue('FN', 0, 0);
    }

    public function getName() {
        return $this->getValue('N', 0, FILE_IMC::VCARD_N_FAMILY) . ';' .
        $this->getValue('N', 0, FILE_IMC::VCARD_N_GIVEN) . ';' .
        $this->getValue('N', 0, FILE_IMC::VCARD_N_ADDL) . ';' .
        $this->getValue('N', 0, FILE_IMC::VCARD_N_PREFIX) . ';' .
        $this->getValue('N', 0, FILE_IMC::VCARD_N_SUFFIX);
    }

    public function getNickname() {
        return $this->getValue('NICKNAME', 0, 0);
    }

    public function getPhoto() {
        return $this->getValue('PHOTO', 0, 0);
    }

      public function parsePhotoType($pt) {
//        $pt = $this->getType('PHOTO');
        if(preg_match("/base64/i", $pt)){
            if(preg_match("/jpg|jpeg/i", $pt)){
                return 'JPEG';
            }  elseif (preg_match('/bmp/i', $pt)) {
                return 'BMP';
            } elseif (preg_match('/gif/i', $pt)) {
                return 'GIF';
            }else{
                return 'UNKNOWN';
            }
        }  elseif (preg_match('/url|uri/i', $pt)) {
            return 'URL';
        }
      }

    public function getURL() {
        return $this->getValue('URL', 0, 0);
    }

    public function getSound() {
        return $this->getValue('SOUND', 0, 0);
    }

    public function getNote() {
        return $this->getValue('NOTE', 0, 0);
    }

    public function getCategories() {
        return $this->getValue('CATEGORIES', 0, 0);
    }

    public function getUniqueID() {
        return $this->getValue('UID', 0, 0);
    }

    public function getRevision() {
        return $this->getValue('REV', 0, 0);
    }

    public function getVersion() {
        return $this->getValue('VERSION', 0);
    }

    public function getProductID() {
        return $this->getValue('PRODID', 0, 0);
    }

    public function getSortString() {
        return $this->getValue('SORT-STRING', 0, 0);
    }

    public function setLanguage($lang) {
        return $this->addValue('LANGUAGE', 0, 0, $lang);
    }

    public function setPhoto($text) {
        
    }

    public function get_x_microblog() {
        if(($microblog = $this->getValue('X-MICROBLOG',0,0))!= NULL){
            return explode('@', $microblog);
        }
        return NULL;
    }

    public function get_x_aim() {
        return null;
    }

}

?>