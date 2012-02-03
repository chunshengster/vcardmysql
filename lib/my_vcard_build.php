<?php

/**
 * @author chunsheng
 *
 *
 */
require_once 'File/IMC.php';
require_once dirname(__FILE__) . '/pinyin_lib.php';

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

    /**
     * 替换换行符:  Nokia 手机在同步时使用 QP 编码,同时会在增加换行
     * @param string $input
     * @return string $input 
     */
    private function _removeNewline($input) {
        $order = array("\r\n", "\n", "\r");
        return str_replace($order, '', $input);
    }

    public function getLanguage() {
        return $this->getValue('LANGUAGE', 0, 0);
    }

    public function getType($comp, $iter = 0) {
        $type = $this->getParam($comp, $iter);

        if ($comp == 'TEL') {
            return $this->parseTelType($type);
        }
        if ($comp == 'PHOTO') {
            return $this->parsePhotoType($type);
        }
        if ($comp == 'ADR') {

            return $this->parseAdrType($type);
        }
        $type = explode('=', $type, 2);
        return $type[1];
    }

    public function parseAdrType($type) {
        $pattern = '/(DOM|INTL|POSTAL|PARCEL|HOME|WORK)/i';
        if (preg_match_all($pattern, $type, $matchesarray)) {
            $type = strtoupper(implode(',', $matchesarray[0]));
            return $type;
        }
        return 'POSTAL';
    }

    public function parseTelType($type) {
//        $type = $this->getType($comp);
        $pattern = '/(PREF|WORK|HOME|VOICE|FAX|MSG|CELL|PAGER|BBS|CAR|VIDEO)/i';
        if (preg_match_all($pattern, $type, $matchesarray)) {
            $type = strtoupper(implode(',', $matchesarray[0]));
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
            return $this->_removeNewline($this->getAdrValue($iter));
        } elseif ($comp === 'TEL') {
            $telValue = parent::getValue($comp, $iter, $part, $rept);
            debugLog(__FILE__, __CLASS__, __METHOD__, __LINE__, var_export($telValue, true));
            $telValue = $this->parseTelValue($telValue);
            return $telValue;
        } elseif ($comp === 'EMAIL') {
            return $this->parseEmailValue(parent::getValue($comp, $iter, $part, $rept));
        }
        return parent::getValue($comp, $iter, $part, $rept);
    }

    public function parseTelValue($telValue) {
        if (substr_count($telValue, '-') === 2) {
            $telValue = preg_replace('/\+|\s+|\-|\(|\)|\'|\\/', '', $telValue);
        }else{
            $telValue = preg_replace('/\s+/', '', $telValue);
        }
        debugLog(__FILE__, __CLASS__, __METHOD__, __LINE__, var_export($telValue, true));
        return $telValue;
    }

    public function parseEmailValue($emailValue) {
        if (preg_match('/<?(([.0-9a-z_-]+)@(([.0-9a-z_-]+\.)+[0-9a-z]{2,}))>?/i', $emailValue, $matches)) {
            return $matches[1];
        } else {
            return $emailValue;
        }
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
        return $this->_removeNewline($this->getValue('ORG', 0, 0));
    }

    /**
      public function getLogoType() {
      return $this->getType('LOGO');
      }
     *
     */
    public function getTitle() {
        return $this->_removeNewline(mb_strlen($this->getValue('TITLE', 0, 0), 'utf-8') > 0) ? $this->getValue('TITLE', 0, 0) : $this->getValue('ROLE', 0, 0);
    }

    public function getRole() {
        return $this->_removeNewline(mb_strlen($this->getValue('ROLE', 0, 0), 'utf-8') > 0) ? $this->getValue('ROLE', 0, 0) : $this->getValue('TITLE', 0, 0);
    }

    public function getAgent() {
        return $this->getValue('AGENT', 0, 0);
    }

    public function getFormattedName() {
        return str_replace(',', ' ', $this->getValue('FN', 0, 0));
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
        if (preg_match("/base64/i", $pt)) {
            if (preg_match("/jpg|jpeg/i", $pt)) {
                return 'JPEG';
            } elseif (preg_match('/bmp/i', $pt)) {
                return 'BMP';
            } elseif (preg_match('/gif/i', $pt)) {
                return 'GIF';
            } else {
                return 'UNKNOWN';
            }
        } elseif (preg_match('/url|uri/i', $pt)) {
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
        return $this->_removeNewline($this->getValue('NOTE', 0, 0));
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
        /**
         * 取消此处对Sort-String 内容的填充，统一在 class_vCard 的 set_vCard_Identification_Properties 方法中进行处理
         */
//        if(strlen($this->getValue('SORT-STRING', 0, 0))<=0){
//            $name = strlen($this->getFormattedName()) > 1 ? $this->getFormattedName(): $this->getName();
//            $sortstring = Pinyin($name, 'utf-8');
//            $this->setSortString($sortstring);
//        }
        return $this->getValue('SORT-STRING', 0, 0);
    }

    public function setLanguage($lang) {
        return $this->addValue('LANGUAGE', 0, 0, $lang);
    }

    public function setPhoto($text) {
        
    }

    public function get_x_microblog() {
        if (($microblog = $this->getValue('X-MICROBLOG', 0, 0)) != NULL) {
            return explode('@', $microblog);
        }
        return NULL;
    }

    public function get_x_aim() {
        return null;
    }

}

?>