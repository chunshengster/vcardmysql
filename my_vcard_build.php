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
        return $type[1];
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

    public function  getValue($comp, $iter = 0, $part = 0, $rept = null) {
        if($comp === 'ADR'){return $this->getAdrValue($iter);}
        return parent::getValue($comp, $iter, $part, $rept);
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
            /**
              echo "this->value:>>>>>>>\n";
              print_r($this->value[$comp]);
              echo "\n";
             *
             */
            return count($this->value[$comp]);
        } elseif (isset($this->value[$comp])) {
            return 1;
        }
        return 0;
    }

    public function getGroupComp($comp) {
        if (in_array($comp, array('LABEL', 'ADR', 'EMAIL', 'TEL'))) {
            $comp_count = $this->getCompCount($comp);
            $r_array = array();
            if ($comp_count > 0) {
                switch ($comp) {
                    case 'LABEL':
                        /**
                         * @todo there may be some thing wrong in this case;
                         */
                        for ($i = 0; $i < $comp_count; $i++) {
                            array_push($r_array, array(strtoupper($comp) => $this->getValue($comp, $i, 0), ucfirst(strtolower($comp)) . 'Type' => $this->getType($comp, $i)));
                        }
                        return $r_array;
                        break;
                    case 'ADR':
                        for ($i = 0; $i < $comp_count; $i++) {
                            array_push($r_array, array(strtoupper($comp) => $this->getValue($comp, $i, 0), ucfirst(strtolower($comp)) . 'Type' => $this->getType($comp, $i)));
                        }
                        return $r_array;
                        break;
                    case 'EMAIL':
                        for ($i = 0; $i < $comp_count; $i++) {
                            array_push($r_array, array(strtoupper($comp) => $this->getValue($comp, $i, 0), ucfirst(strtolower($comp)) . 'Type' => $this->getType($comp, $i)));
                        }
                        return $r_array;
                        break;
                    default:
                        break;
                }
            } else {
                return false;
            }
        }
        return false;
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

    /*
    public function getPhotoType() {
        return $this->getType('PHOTO');
    }
     * 
     */

    public function getURL() {
        return $this->getValue('URL', 0, 0);
    }

    public function getSound() {
        return $this->getValue('SOUND', 0, 0);
    }

    public function getNote() {
        return $this->getValue('NOTE', 0, 0);
    }

    public function getCategories(){
        return $this->getValue('CATEGORIES', 0, 0);
    }

    public function getUniqueID() {
        return  $this->getValue('UID', 0, 0);
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

}

?>