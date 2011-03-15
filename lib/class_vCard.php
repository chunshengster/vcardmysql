<?php

/**
 * @author chunshengster@gmail.com
 * @version $Id$
 */

require_once 'my_vcard_parse.php';
require_once 'my_vcard_build.php';
require_once 'class_vcard_storage.php';

if(!function_exists('debugLog')){
    require_once dirname(__FILE__).'/debug.php';
}

class class_vCard {

    /**
     * @var <storage object> 存储对象
     */
    private $obj_vcard_storage;
    private $_parser;
    private $_builder;
    private $vCard_Explanatory_Properties = array();
    private $vCard_Identification_Properties = array();
    private $vCard_Delivery_Addressing_Properties_ADR = array();
    private $vCard_Delivery_Addressing_Properties_LABEL = array();
    private $vCard_Geographical_Properties = array();
    private $vCard_Organizational_Properties = array();
    private $vCard_Telecommunications_Addressing_Properties_Email = array();
    private $vCard_Telecommunications_Addressing_Properties_Tel = array();

    function __construct() {

        /*
          $this->obj_vcard_storeage = new class_vcard_db ();
          if (! ($this->obj_vcard_storeage instanceof class_vcard_db)) {
          return 0;
          }
         */
    }

    function __destruct() {
        if ($this->obj_vcard_storage) {
            unset($this->obj_vcard_storage);
        }
        unset($this->_parser);
        unset($this->_builder);
//        $this = null;
    }

    private function _get_storage_resource() {
//        debugLog(__FILE__, __METHOD__, __LINE__);
        if (!($this->obj_vcard_storage instanceof class_vcard_storage) or !$this->obj_vcard_storage->is_alive()) {
            $this->obj_vcard_storage = new class_vcard_storage;
        }
    }

    private function _get_parser() {
        if (!($this->_parser instanceof my_vcard_parse)) {
            try {
                $this->_parser = new my_vcard_parse ();
            } catch (Exception $e) {
                debugLog(__FILE__, __METHOD__, __LINE__, $e->getMessage());
                return false;
            }
        }
    }

    private function _get_vcard_resource_id_from_storage() {
        if (!isset($this->vCard_Explanatory_Properties['RESOURCE_ID']) or (is_null($this->vCard_Explanatory_Properties['RESOURCE_ID']))) {
            $this->_get_storage_resource();

            $re = $this->obj_vcard_storage->get_vcard_id_by_uid($this->vCard_Explanatory_Properties['UID']);
            if ($re) {
                $this->vCard_Explanatory_Properties['RESOURCE_ID'] = $re;
            }
            return $this->vCard_Explanatory_Properties['RESOURCE_ID'];
        }
    }

    /**
     * @param $key = array('UID') || $key = array('idvCard_Explanatory_Properties')
     * @return the $vCard_Explanatory_Properties
     */
    public function get_vCard_Explanatory_Properties($from_storage=false) {
        //		$this->vCard_Explanatory_Properties = self::$obj_vcard_storeage->get_vCard_Explanatory_Properties($key);
        if ($from_storage == false) {
            return $this->vCard_Explanatory_Properties;
        } else {
            $key = array();
            debugLog(__FILE__, __METHOD__, __LINE__, var_export($this->vCard_Explanatory_Properties, true));
            if ($this->vCard_Explanatory_Properties['UID'] !== '') {
                $key = array(
                    'UID' => $this->vCard_Explanatory_Properties['UID'],
                );
            } elseif ($this->vCard_Explanatory_Properties['RESOURCE_ID'] !== '' && isset($this->vCard_Explanatory_Properties['RESOURCE_ID'])) {
                $key = array(
                    'idvCard_Explanatory_Properties' => $this->vCard_Explanatory_Properties['RESOURCE_ID']
                );
            } else {
                return false;
            }
            $this->_get_storage_resource();
            $re_array = $this->obj_vcard_storage->get_vCard_Explanatory_Properties($key);
            debugLog(__FILE__, __METHOD__, __LINE__, var_export($re_array, true));
            $vCard_Explanatory_Properties = $re_array;
            $this->set_vCard_Explanatory_Properties($vCard_Explanatory_Properties);
            debugLog(__FILE__, __METHOD__, __LINE__, var_export($this->vCard_Explanatory_Properties, true));
            return $this->vCard_Explanatory_Properties;
        }
        return false;
    }

    /**
     * @param array $vCard_Explanatory_Properties
     * @param field_type $vCard_Explanatory_Properties
     */
    public function set_vCard_Explanatory_Properties($vCard_Explanatory_Properties) {
        $this->vCard_Explanatory_Properties = $vCard_Explanatory_Properties;
    }

    /**
     * ========@param array('vCard_Explanatory_Properties_idvCard_Explanatory_Properties')
     * ========     or array('idvCard_Identification_Properties')
     * @return the $vCard_Identification_Properties
     */
    public function get_vCard_Identification_Properties($from_storage=false) {
        //		$this->vCard_Identification_Properties = self::$obj_vcard_storeage->get_vCard_Identification_Properties($key);
        if ($from_storage == false) {
            return $this->vCard_Identification_Properties;
        } else {
            $key = array();
            debugLog(__FILE__, __METHOD__, __LINE__, var_export($this->vCard_Explanatory_Properties, true));
            debugLog(__FILE__, __METHOD__, __LINE__, var_export($this->vCard_Identification_Properties, true));
            if ($this->vCard_Explanatory_Properties['RESOURCE_ID'] !== '') {
                $key = array(
                    'vCard_Explanatory_Properties_idvCard_Explanatory_Properties' => $this->vCard_Explanatory_Properties['RESOURCE_ID'],
                );
            } elseif ($this->vCard_Identification_Properties['RESOURCE_ID'] !== '' && isset($this->vCard_Identification_Properties['RESOURCE_ID'])) {
                $key = array(
                    'idvCard_Identification_Properties' => $this->vCard_Identification_Properties['RESOURCE_ID'],
                );
            } else {
                return false;
            }
            $this->_get_storage_resource();
            $re_array = $this->obj_vcard_storage->get_vCard_Identification_Properties($key);
            debugLog(__FILE__, __METHOD__, __LINE__, var_export($re_array, true));
            $vCard_Identification_Properties = $re_array;
            $this->set_vCard_Identification_Properties($vCard_Identification_Properties);
            return $this->vCard_Identification_Properties;
        }
        return false;
    }

    /**
     * @param field_type $vCard_Identification_Properties
     */
    public function set_vCard_Identification_Properties($vCard_Identification_Properties) {
        $this->vCard_Identification_Properties = $vCard_Identification_Properties;
    }

    /**
     * @return the $vCard_Delivery_Addressing_Properties_ADR
     * 如果 $from_storage = ture，则选择从数据库中取出数据
     * 如果$resource_id 为''，则从数据库中取出该 vcard 的全部 adr 信息
     * 如果$resource_id不为空，且为大整数，则从数据库中取出idvCard_Delivery_Addressing_Properties_ADR为$resource_id 的对应条目
     */
    public function get_vCard_Delivery_Addressing_Properties_ADR($from_storage=false, $resource_id = '') {
        if ($from_storage == false) {
            return $this->vCard_Delivery_Addressing_Properties_ADR;
        } else {
            $key = array();
            $re_array = array();
            debugLog(__FILE__, __METHOD__, __LINE__, var_export($this->vCard_Explanatory_Properties, true));
            debugLog(__FILE__, __METHOD__, __LINE__, var_export($this->vCard_Delivery_Addressing_Properties_ADR, true));

            $this->_get_storage_resource();
            if ($resource_id !== '') {
                $key = array(
                    'idvCard_Delivery_Addressing_Properties_ADR' => $resource_id,
                );
                $re_array = $this->obj_vcard_storage->get_vCard_Delivery_Addressing_Properties_ADR($key);
                debugLog(__FILE__, __METHOD__, __LINE__, var_export($key, true));
                debugLog(__FILE__, __METHOD__, __LINE__, var_export($re_array, true));
                foreach ($this->vCard_Delivery_Addressing_Properties_ADR as $k => $v) {
                    if ($this->vCard_Delivery_Addressing_Properties_ADR[$k]['RESOURCE_ID'] == $resource_id) {
                        $this->vCard_Delivery_Addressing_Properties_ADR[$k] = $re_array[0];
                        debugLog(__FILE__, __METHOD__, __LINE__, var_export($this->vCard_Delivery_Addressing_Properties_ADR[$k], true));
                        return $this->vCard_Delivery_Addressing_Properties_ADR[$k];
//                        break;
                    }
                }
            } elseif ($this->vCard_Explanatory_Properties['RESOURCE_ID'] !== '') {
                $key = array(
                    'vCard_Explanatory_Properties_idvCard_Explanatory_Properties' => $this->vCard_Explanatory_Properties['RESOURCE_ID'],
                );
                debugLog(__FILE__, __METHOD__, __LINE__, var_export($key, true));
                $re_array = $this->obj_vcard_storage->get_vCard_Delivery_Addressing_Properties_ADR($key);
                debugLog(__FILE__, __METHOD__, __LINE__, var_export($re_array, true));
                $this->set_vCard_Delivery_Addressing_Properties_ADR($re_array);
                return $this->vCard_Delivery_Addressing_Properties_ADR;
            }
        }
        return false;
    }

    /**
     * @param field_type $vCard_Delivery_Addressing_Properties_ADR
     */
    public function set_vCard_Delivery_Addressing_Properties_ADR($vCard_Delivery_Addressing_Properties_ADR) {
        /**
          echo "Test ::::::: \n";
          print_r($vCard_Delivery_Addressing_Properties_ADR);
         *
         */
        $this->vCard_Delivery_Addressing_Properties_ADR = $vCard_Delivery_Addressing_Properties_ADR;
    }

    /**
     * @return the $vCard_Delivery_Addressing_Properties_LABEL
     * @param <bool> $from_storage
     * @param <bigint> $resource_id
     */
    public function get_vCard_Delivery_Addressing_Properties_LABEL($from_storage=false, $resource_id = '') {
        if ($from_storage == false) {
            return $this->vCard_Delivery_Addressing_Properties_LABEL;
        } else {
            $key = array();
            $re_array = array();
            debugLog(__FILE__, __METHOD__, __LINE__, var_export($this->vCard_Explanatory_Properties, true));
            debugLog(__FILE__, __METHOD__, __LINE__, var_export($this->vCard_Delivery_Addressing_Properties_LABEL, true));

            $this->_get_storage_resource();
            if ($resource_id !== '') {
                $key = array(
                    'idvCard_Delivery_Addressing_Properties_LABEL' => $resource_id,
                );
                $re_array = $this->obj_vcard_storage->get_vCard_Delivery_Addressing_Properties_LABEL($key);
                debugLog(__FILE__, __METHOD__, __LINE__, var_export($key, true));
                debugLog(__FILE__, __METHOD__, __LINE__, var_export($re_array, true));
                foreach ($this->vCard_Delivery_Addressing_Properties_LABEL as $k => $v) {
                    if ($this->vCard_Delivery_Addressing_Properties_LABEL[$k]['RESOURCE_ID'] == $resource_id) {
                        $this->vCard_Delivery_Addressing_Properties_LABEL[$k] = $re_array[0];
                        debugLog(__FILE__, __METHOD__, __LINE__, var_export($this->vCard_Delivery_Addressing_Properties_LABEL[$k], true));
                        return $this->vCard_Delivery_Addressing_Properties_LABEL[$k];
                    }
                }
            } elseif ($this->vCard_Explanatory_Properties['RESOURCE_ID'] !== '') {
                $key = array(
                    'vCard_Explanatory_Properties_idvCard_Explanatory_Properties' => $this->vCard_Explanatory_Properties['RESOURCE_ID'],
                );
                debugLog(__FILE__, __METHOD__, __LINE__, var_export($key, true));
                $re_array = $this->obj_vcard_storage->get_vCard_Delivery_Addressing_Properties_LABEL($key);
                debugLog(__FILE__, __METHOD__, __LINE__, var_export($re_array, true));
                $this->set_vCard_Delivery_Addressing_Properties_LABEL($re_array);
                return $this->vCard_Delivery_Addressing_Properties_LABEL;
            }
        }
        return false;
    }

    /**
     * @param field_type $vCard_Delivery_Addressing_Properties_LABEL
     * @todo Label may have some format problem .
     */
    public function set_vCard_Delivery_Addressing_Properties_LABEL($vCard_Delivery_Addressing_Properties_LABEL) {
        $this->vCard_Delivery_Addressing_Properties_LABEL = $vCard_Delivery_Addressing_Properties_LABEL;
    }

    /**
     * @return the $vCard_Geographical_Properties
     */
    public function get_vCard_Geographical_Properties($from_storage = false) {
        if ($from_storage == false) {
            return $this->vCard_Geographical_Properties;
        } else {
            $key = array();
            debugLog(__FILE__, __METHOD__, __LINE__, var_export($this->vCard_Explanatory_Properties, true));
            debugLog(__FILE__, __METHOD__, __LINE__, var_export($this->vCard_Geographical_Properties, true));
            if ($this->vCard_Explanatory_Properties['RESOURCE_ID'] !== '') {
                $key = array(
                    'vCard_Explanatory_Properties_idvCard_Explanatory_Properties' => $this->vCard_Explanatory_Properties['RESOURCE_ID'],
                );
            } elseif ($this->vCard_Geographical_Properties['RESOURCE_ID'] !== '' && isset($this->vCard_Geographical_Properties['RESOURCE_ID'])) {
                $key = array(
                    'idvCard_Geographical_Properties' => $this->vCard_Geographical_Properties['RESOURCE_ID'],
                );
            } else {
                return false;
            }
            $this->_get_storage_resource();
            $re_array = $this->obj_vcard_storage->get_vCard_Geographical_Properties($key);
            debugLog(__FILE__, __METHOD__, __LINE__, var_export($re_array, true));
            $vCard_Geographical_Properties = $re_array;
            $this->set_vCard_Geographical_Properties($vCard_Geographical_Properties);
            return $this->vCard_Geographical_Properties;
        }
        return false;
    }

    /**
     * @param field_type $vCard_Geographical_Properties
     */
    public function set_vCard_Geographical_Properties($vCard_Geographical_Properties) {
//        print_r($vCard_Geographical_Properties);
        $this->vCard_Geographical_Properties = $vCard_Geographical_Properties;
    }

    /**
     * @return the $vCard_Organizational_Properties
     */
    public function get_vCard_Organizational_Properties($from_storage=false) {
        if ($from_storage == false) {
            return $this->vCard_Organizational_Properties;
        } else {
            $key = array();
            debugLog(__FILE__, __METHOD__, __LINE__, var_export($this->vCard_Explanatory_Properties, true));
            debugLog(__FILE__, __METHOD__, __LINE__, var_export($this->vCard_Organizational_Properties, true));
            if ($this->vCard_Explanatory_Properties['RESOURCE_ID'] !== '') {
                $key = array(
                    'vCard_Explanatory_Properties_idvCard_Explanatory_Properties' => $this->vCard_Explanatory_Properties['RESOURCE_ID'],
                );
            } elseif ($this->vCard_Organizational_Properties['RESOURCE_ID'] !== '' && isset($this->vCard_Organizational_Properties['RESOURCE_ID'])) {
                $key = array(
                    'idvCard_Organizational_Properties' => $this->vCard_Organizational_Properties['RESOURCE_ID'],
                );
            } else {
                return false;
            }
            $this->_get_storage_resource();
            $re_array = $this->obj_vcard_storage->get_vCard_Organizational_Properties($key);
            debugLog(__FILE__, __METHOD__, __LINE__, var_export($re_array, true));
            $vCard_Organizational_Properties = $re_array;
            $this->set_vCard_Organizational_Properties($vCard_Organizational_Properties);
            return $this->vCard_Organizational_Properties;
        }
        return false;
    }

    /**
     * @param field_type $vCard_Organizational_Properties
     */
    public function set_vCard_Organizational_Properties($vCard_Organizational_Properties) {
        $this->vCard_Organizational_Properties = $vCard_Organizational_Properties;
    }

    /**
     * @return the $vCard_Telecommunications_Addressing_Properties_Email
     */
    public function get_vCard_Telecommunications_Addressing_Properties_Email($from_storage=false, $resource_id='') {
        if ($from_storage == false) {
            return $this->vCard_Telecommunications_Addressing_Properties_Email;
        } else {
            $key = array();
            $re_array = array();
            debugLog(__FILE__, __METHOD__, __LINE__, var_export($this->vCard_Explanatory_Properties, true));
            debugLog(__FILE__, __METHOD__, __LINE__, var_export($this->vCard_Telecommunications_Addressing_Properties_Email, true));

            $this->_get_storage_resource();
            if ($resource_id !== '') {
                $key = array(
                    'idvCard_Telecommunications_Addressing_Properties_Email' => $resource_id,
                );
                $re_array = $this->obj_vcard_storage->get_vCard_Telecommunications_Addressing_Properties_Email($key);
                debugLog(__FILE__, __METHOD__, __LINE__, var_export($key, true));
                debugLog(__FILE__, __METHOD__, __LINE__, var_export($re_array, true));
                foreach ($this->vCard_Telecommunications_Addressing_Properties_Email as $k => $v) {
                    if ($this->vCard_Telecommunications_Addressing_Properties_Email[$k]['RESOURCE_ID'] == $resource_id) {
                        $this->vCard_Telecommunications_Addressing_Properties_Email[$k] = $re_array[0];
                        debugLog(__FILE__, __METHOD__, __LINE__, var_export($this->vCard_Telecommunications_Addressing_Properties_Email[$k], true));
                        return $this->vCard_Telecommunications_Addressing_Properties_Email[$k];
                    }
                }
            } elseif ($this->vCard_Explanatory_Properties['RESOURCE_ID'] !== '') {
                $key = array(
                    'vCard_Explanatory_Properties_idvCard_Explanatory_Properties' => $this->vCard_Explanatory_Properties['RESOURCE_ID'],
                );
                debugLog(__FILE__, __METHOD__, __LINE__, var_export($key, true));
                $re_array = $this->obj_vcard_storage->get_vCard_Telecommunications_Addressing_Properties_Email($key);
                debugLog(__FILE__, __METHOD__, __LINE__, var_export($re_array, true));
                $this->set_vCard_Telecommunications_Addressing_Properties_Email($re_array);
                return $this->vCard_Telecommunications_Addressing_Properties_Email;
            }
        }
        return false;
    }

    /**
     * @param field_type $vCard_Telecommunications_Addressing_Properties_Email
     */
    public function set_vCard_Telecommunications_Addressing_Properties_Email($vCard_Telecommunications_Addressing_Properties_Email) {
        $this->vCard_Telecommunications_Addressing_Properties_Email = $vCard_Telecommunications_Addressing_Properties_Email;
    }

    /**
     * @return the $vCard_Telecommunications_Addressing_Properties_Tel
     */
    public function get_vCard_Telecommunications_Addressing_Properties_Tel($from_storage = false, $resource_id = '') {
        if ($from_storage == false) {
            return $this->vCard_Telecommunications_Addressing_Properties_Tel;
        } else {
            $key = array();
            $re_array = array();
            debugLog(__FILE__, __METHOD__, __LINE__, var_export($this->vCard_Explanatory_Properties, true));
            debugLog(__FILE__, __METHOD__, __LINE__, var_export($this->vCard_Telecommunications_Addressing_Properties_Tel, true));

            $this->_get_storage_resource();
            if ($resource_id !== '') {
                $key = array(
                    'idvCard_Telecommunications_Addressing_Properties_Email' => $resource_id,
                );
                $re_array = $this->obj_vcard_storage->get_vCard_Telecommunications_Addressing_Properties_Tel($key);
                debugLog(__FILE__, __METHOD__, __LINE__, var_export($key, true));
                debugLog(__FILE__, __METHOD__, __LINE__, var_export($re_array, true));
                foreach ($this->vCard_Telecommunications_Addressing_Properties_Tel as $k => $v) {
                    if ($this->vCard_Telecommunications_Addressing_Properties_Tel[$k]['RESOURCE_ID'] == $resource_id) {
                        $this->vCard_Telecommunications_Addressing_Properties_Tel[$k] = $re_array[0];
                        debugLog(__FILE__, __METHOD__, __LINE__, var_export($this->vCard_Telecommunications_Addressing_Properties_Tel[$k], true));
                        return $this->vCard_Telecommunications_Addressing_Properties_Tel[$k];
                    }
                }
            } elseif ($this->vCard_Explanatory_Properties['RESOURCE_ID'] !== '') {
                $key = array(
                    'vCard_Explanatory_Properties_idvCard_Explanatory_Properties' => $this->vCard_Explanatory_Properties['RESOURCE_ID'],
                );
                debugLog(__FILE__, __METHOD__, __LINE__, var_export($key, true));
                $re_array = $this->obj_vcard_storage->get_vCard_Telecommunications_Addressing_Properties_Tel($key);
                debugLog(__FILE__, __METHOD__, __LINE__, var_export($re_array, true));
                $this->set_vCard_Telecommunications_Addressing_Properties_Tel($re_array);
                return $this->vCard_Telecommunications_Addressing_Properties_Tel;
            }
        }
        return false;
    }

    /**
     * @param field_type $vCard_Telecommunications_Addressing_Properties_Tel
     */
    public function set_vCard_Telecommunications_Addressing_Properties_Tel($vCard_Telecommunications_Addressing_Properties_Tel) {
        $this->vCard_Telecommunications_Addressing_Properties_Tel = $vCard_Telecommunications_Addressing_Properties_Tel;
    }

    /**
     * @prarm text $vcard_text
     */
    public function parse_vCard($vcard_text) {
        if (!($this->_parser instanceof my_vcard_parse)) {
            try {
                $this->_parser = new my_vcard_parse ();
            } catch (Exception $e) {
                debugLog(__FILE__, __METHOD__, __LINE__, $e->getMessage());
                return false;
            }
        }

        if (!($this->_builder instanceof my_vcard_build)) {
            try {
                $this->_builder = new my_vcard_build ();
            } catch (Exception $e) {
                debugLog(__FILE__, __METHOD__, __LINE__, $e->getMessage());
                return false;
            }
        }

        $data = $this->_parser->fromText($vcard_text);
//        print_r($this->_parser->get_parse_data());
//        debugLog(__FILE__, __METHOD__, __LINE__, "\n", var_export($this->_parser->get_parse_data(),true), "\n");

        @$this->_builder->setFromArray($this->_parser->get_parse_data());
//        echo var_export($this->_parser->get_parse_data(), true);
//        echo var_export($this->_builder, true);

        $this->set_vCard_Explanatory_Properties(array(
            'UID' => $this->_builder->getUniqueID(),
            'REV' => (strlen($this->_builder->getRevision()) <= 1) ? date("c") : $this->_builder->getRevision(),
            'VERSION' => $this->_parser->getVersion(),
            'LANG' => $this->_builder->getLanguage(),
            'CATEGORIES' => $this->_builder->getCategories(),
            'PRODID' => $this->_builder->getProductID(),
            'SORT-STRING' => $this->_builder->getSortString()
                )

        /* array (
          'UID' => $data ['VCARD'] [0] ['UID'] [0] ['value'] [0] [0],
          'VERSION' => $data ['VCARD'] [0] ['VERSION'] [0] ['value'] [0] [0],
          'REV' => $data ['VCARD'] [0] ['REV'] [0] ['value'] [0] [0],
          'LANG' => $data ['VCARD'] [0] ['LANG'] [0] ['value'] [0] [0]
          ) */
        );
        $this->set_vCard_Identification_Properties(array(
            'FN' => $this->_builder->getFormattedName(),
            'N' => $this->_builder->getName(),
            'NICKNAME' => $this->_builder->getNickname(),
            'PHOTO' => $this->_builder->getPhoto(),
            'PhotoType' => $this->_builder->getType('PHOTO'),
            'BDAY' => $this->_builder->getBirthday(),
            'URL' => $this->_builder->getURL(),
            'SOUND' => $this->_builder->getSound(),
            'NOTE' => $this->_builder->getNote()
        ));
        /*
         * there are more than one 'ADR' comp
         */
        $this->set_vCard_Delivery_Addressing_Properties_ADR($this->_builder->getGroupComp('ADR'));
        /*
         * there are more than one 'LABLE' comp
         */
        $this->set_vCard_Delivery_Addressing_Properties_LABEL($this->_builder->getGroupComp('LABEL'));

        $this->set_vCard_Telecommunications_Addressing_Properties_Tel($this->_builder->getGroupComp('TEL'));
        $this->set_vCard_Telecommunications_Addressing_Properties_Email($this->_builder->getGroupComp('EMAIL'));
        $this->set_vCard_Organizational_Properties(array(
            'TITLE' => $this->_builder->getTitle(),
            'ROLE' => $this->_builder->getRole(),
            'LOGO' => $this->_builder->getLogo(),
            'LogoType' => $this->_builder->getType('LOGO'),
            'AGENT' => $this->_builder->getAgent(),
            'ORG' => $this->_builder->getOrg()
        ));
        $this->set_vCard_Geographical_Properties(array(
            'TZ' => $this->_builder->getTz(),
            'GEO' => $this->_builder->getGeo()
        ));
//        print_r($this->_builder->getGeo());
        $this->_parser = NULL;
        $this->_builder = NULL;
        return $this;
    }

    /**
     * @todo
     * @param $key = array('UID' => $UID) or array('idvCard_Explanatory_Properties' =>$idvCard_Explanatory_Properties)
     */

    /**
      public function get_vCard_From_Storage($key) {


      }
     */
    public function print_parse_data() {
        try {
            print_r($this->_parser->get_parse_data());
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
    }

    /**
     * @todo 此函数将被废掉
     * @todo 从 vcard_storage 中取出对应的vcard 数据,此函数需要大规模改写，与 get_xxxxx_property($from_storage=true)进行配合
     * @param array('UID' => $UID,'idvCard_Explanatory_Properties' =>$idvCard_Explanatory_Properties || 'RESOURCE_ID' = $this->vCard_??????(各个分类)_Properties['RESOURCE_ID'],'property'='' )
     * @return array
     */
    public function get_vCard_property_from_storage($key) {
        $tmp_array = array();

        debugLog(__FILE__, __METHOD__, __LINE__, var_export($key, true));
        $this->_get_storage_resource();
        if (!in_array($key ['property'], array(
                    'vCard_Explanatory_Properties', 'vCard_Identification_Properties', 'vCard_Delivery_Addressing_Properties_ADR', 'vCard_Delivery_Addressing_Properties_LABEL', 'vCard_Geographical_Properties', 'vCard_Organizational_Properties', 'vCard_Telecommunications_Addressing_Properties_Email', 'vCard_Telecommunications_Addressing_Properties_Tel'
                        ), true)) {
            return NULL;
        }
//        debugLog(__FILE__, __METHOD__, __LINE__, var_export($tmp_array, true));
//
        switch ($key ['property']) {
            case 'vCard_Explanatory_Properties' :
                if (array_key_exists('UID', $key)) {
                    $tmp_array = array(
                        'UID' => $key ['UID']
                    );
                } elseif (array_key_exists('idvCard_Explanatory_Properties', $key)) {
                    $tmp_array = array(
                        'idvCard_Explanatory_Properties' => $key ['idvCard_Explanatory_Properties']
                    );
                }
                try {
                    $this->set_vCard_Explanatory_Properties($this->obj_vcard_storage->get_vCard_Explanatory_Properties($tmp_array));
                } catch (Exception $e) {
                    print_r($e->getMessenge());
                    debugLog(__FILE__, __METHOD__, __LINE__, $e->getMessage());
                }
                debugLog(__FILE__, __METHOD__, __LINE__, var_export($this->get_vCard_Explanatory_Properties(), true));
                return $this->vCard_Explanatory_Properties;
                break;

            case 'vCard_Identification_Properties' :
                if (array_key_exists('idvCard_Explanatory_Properties', $key)) {
                    $tmp_array = array(
                        'vCard_Explanatory_Properties_idvCard_Explanatory_Properties' => $key['idvCard_Explanatory_Properties'],
                    );
                } elseif (array_key_exists('RESOURCE_ID', $key)) {
                    /**
                     *  RESOURCE_ID 为 vCard_Identification_Properties 的 RESOURCE_ID
                     */
                    $tmp_array = array(
                        'idvCard_Identification_Properties' => $key['RESOURCE_ID']
                    );
                } elseif (isset($key['vCard_Explanatory_Properties_idvCard_Explanatory_Properties'])) {
                    $tmp_array = $key;
                } else {
                    return null;
                }
                $this->set_vCard_Identification_Properties($this->obj_vcard_storage->get_vCard_Identification_Properties($tmp_array));
                debugLog(__FILE__, __METHOD__, __LINE__, var_export($this->get_vCard_Identification_Properties(), true));
                return $this->vCard_Identification_Properties;
                break;

            case 'vCard_Geographical_Properties' :
                if (array_key_exists('idvCard_Explanatory_Properties', $key)) {
                    $tmp_array = array(
                        'vCard_Explanatory_Properties_idvCard_Explanatory_Properties' => $key['idvCard_Explanatory_Properties'],
                    );
                } elseif (array_key_exists('RESOURCE_ID', $key)) {
                    $tmp_array = array(
                        'idvCard_Geographical_Properties' => $key['RESOURCE_ID']
                    );
                } elseif (isset($key['vCard_Explanatory_Properties_idvCard_Explanatory_Properties'])) {
                    $tmp_array = $key;
                } else {
                    return null;
                }
                $this->set_vCard_Geographical_Properties($this->obj_vcard_storage->get_vCard_Geographical_Properties($tmp_array));
                debugLog(__FILE__, __METHOD__, __LINE__, var_export($this->get_vCard_Geographical_Properties(), true));
                return $this->vCard_Geographical_Properties;
                break;

            case 'vCard_Organizational_Properties' :
                if (array_key_exists('idvCard_Explanatory_Properties', $key)) {
                    $tmp_array = array(
                        'vCard_Explanatory_Properties_idvCard_Explanatory_Properties' => $key['idvCard_Explanatory_Properties'],
                    );
                } elseif (array_key_exists('RESOURCE_ID', $key)) {
                    $tmp_array = array(
                        'idvCard_Organizational_Properties' => $key['RESOURCE_ID']
                    );
                } elseif (isset($key['vCard_Explanatory_Properties_idvCard_Explanatory_Properties'])) {
                    $tmp_array = $key;
                } else {
                    return null;
                }
                $this->set_vCard_Organizational_Properties($this->obj_vcard_storage->get_vCard_Organizational_Properties($tmp_array));
                return $this->vCard_Organizational_Properties;
                break;

            case 'vCard_Delivery_Addressing_Properties_ADR' :
                if (array_key_exists('idvCard_Explanatory_Properties', $key)) {
                    $tmp_array = array(
                        'vCard_Explanatory_Properties_idvCard_Explanatory_Properties' => $key['idvCard_Explanatory_Properties'],
                    );
                } elseif (array_key_exists('RESOURCE_ID', $key)) {
                    $tmp_array = array(
                        'idvCard_Delivery_Addressing_Properties_ADR' => $key['RESOURCE_ID']
                    );
                } elseif (isset($key['vCard_Explanatory_Properties_idvCard_Explanatory_Properties'])) {
                    $tmp_array = $key;
                } else {
                    return null;
                }

                $this->set_vCard_Delivery_Addressing_Properties_ADR($this->obj_vcard_storage->get_vCard_Delivery_Addressing_Properties_ADR($tmp_array));
                return $this->vCard_Delivery_Addressing_Properties_ADR;
                break;

            case 'vCard_Delivery_Addressing_Properties_LABEL' :
                if (array_key_exists('idvCard_Explanatory_Properties', $key)) {
                    $tmp_array = array(
                        'vCard_Explanatory_Properties_idvCard_Explanatory_Properties' => $key['idvCard_Explanatory_Properties'],
                    );
                } elseif (array_key_exists('RESOURCE_ID', $key)) {
                    $tmp_array = array(
                        'idvCard_Delivery_Addressing_Properties_LABEL' => $key['RESOURCE_ID']
                    );
                } elseif (isset($key['vCard_Explanatory_Properties_idvCard_Explanatory_Properties'])) {
                    $tmp_array = $key;
                } else {
                    return null;
                }

                $this->set_vCard_Delivery_Addressing_Properties_LABEL($this->obj_vcard_storage->get_vCard_Delivery_Addressing_Properties_LABEL($tmp_array));
                return $this->vCard_Delivery_Addressing_Properties_LABEL;
                break;


            case 'vCard_Telecommunications_Addressing_Properties_Tel' :
                if (array_key_exists('idvCard_Explanatory_Properties', $key)) {
                    $tmp_array = array(
                        'vCard_Explanatory_Properties_idvCard_Explanatory_Properties' => $key['idvCard_Explanatory_Properties'],
                    );
                } elseif (array_key_exists('RESOURCE_ID', $key)) {
                    $tmp_array = array(
                        'idvCard_Telecommunications_Addressing_Properties_Tel' => $key['RESOURCE_ID']
                    );
                } elseif (isset($key['vCard_Explanatory_Properties_idvCard_Explanatory_Properties'])) {
                    $tmp_array = $key;
                } else {
                    return null;
                }
                $this->set_vCard_Telecommunications_Addressing_Properties_Tel($this->obj_vcard_storage->get_vCard_Telecommunications_Addressing_Properties_Tel($tmp_array));
                return $this->vCard_Telecommunications_Addressing_Properties_Tel;
                break;

            case 'vCard_Telecommunications_Addressing_Properties_Email' :
                if (array_key_exists('idvCard_Explanatory_Properties', $key)) {
                    $tmp_array = array(
                        'vCard_Explanatory_Properties_idvCard_Explanatory_Properties' => $key['idvCard_Explanatory_Properties'],
                    );
                } elseif (array_key_exists('RESOURCE_ID', $key)) {
                    $tmp_array = array(
                        'idvCard_Telecommunications_Addressing_Properties_Email' => $key['RESOURCE_ID']
                    );
                } elseif (isset($key['vCard_Explanatory_Properties_idvCard_Explanatory_Properties'])) {
                    $tmp_array = $key;
                } else {
                    return null;
                }
                $this->set_vCard_Telecommunications_Addressing_Properties_Email($this->obj_vcard_storage->get_vCard_Telecommunications_Addressing_Properties_Email($tmp_array));
                return $this->vCard_Telecommunications_Addressing_Properties_Email;
                break;

            default :
                return $this;
                break;
        }
    }

    /**
     *
     * @param $vcard
     */
    /**
      public function store_vCard_Property_Into_Storage($vcard_text = '') {
      if ($vcard_text !== '') {
      $this->parse_vcard($vcard_text);
      }
     *
     */
    /*
      if (! ($this->obj_vcard_storage instanceof PDO)) {
      $this->obj_vcard_storage = new class_vcard_db ( );
      }
     */
    /*
      private $vCard_Explanatory_Properties;
      private $vCard_Identification_Properties;
      private $vCard_Delivery_Addressing_Properties_ADR;
      private $vCard_Delivery_Addressing_Properties_LABEL;
      private $vCard_Geographical_Properties;
      private $vCard_Organizational_Properties;
      private $vCard_Telecommunications_Addressing_Properties_Email;
      private $vCard_Telecommunications_Addressing_Properties_Tel;
     */

    /**
      $this->store_vCard_Explanatory_Properties();
      $this->store_vCard_Identification_Properties();
      $this->store_vCard_Delivery_Addressing_Properties_ADR();
      $this->store_vCard_Delivery_Addressing_Properties_LABEL();
      $this->store_vCard_Geographical_Properties();
      $this->store_vCard_Organizational_Properties();
      $this->store_vCard_Telecommunications_Addressing_Properties_Email();
      $this->store_vCard_Telecommunications_Addressing_Properties_Tel();
      }
     */
    public function store_vCard_Explanatory_Properties($gen_uid = false) {

        debugLog(__FILE__, __METHOD__, __LINE__, var_export($this->vCard_Explanatory_Properties, true));
        $this->_get_storage_resource();
        if (!isset($this->vCard_Explanatory_Properties['UID']) || $this->vCard_Explanatory_Properties['UID'] == '') {
            $gen_uid = true;
        }
        $re_array = $this->obj_vcard_storage->store_data('vCard_Explanatory_Properties', $this->vCard_Explanatory_Properties, $gen_uid);
        debugLog(__FILE__, __METHOD__, __LINE__, var_export($re_array, true));
        if ($re_array !== false) {
            if ($re_array['UID'] !== '' and ($this->vCard_Explanatory_Properties['UID'] == '' or (isset($this->vCard_Explanatory_Properties['UID'])))) {
                $this->vCard_Explanatory_Properties['UID'] = $re_array['UID'];
            }

            /**
             * @todo 修正数据结构，每个结构分块都返回并记录该条在数据库中的id ,已完成
             */
            $this->vCard_Explanatory_Properties['RESOURCE_ID'] = $re_array['RESOURCE_ID'];
            return $this->vCard_Explanatory_Properties['RESOURCE_ID'];
        }
        return $re_array;
    }

    public function store_vCard_Identification_Properties() {
        $this->_get_storage_resource();
        if (!isset($this->vCard_Explanatory_Properties['RESOURCE_ID']) and !isset($this->vCard_Explanatory_Properties['UID'])) {
            return false;
        } elseif (isset($this->vCard_Explanatory_Properties['UID'])) {
            $this->_get_vcard_resource_id_from_storage();
        }
        $re_array = $this->obj_vcard_storage->store_data('vCard_Identification_Properties', array_merge($this->vCard_Identification_Properties, array('V_ID' => $this->vCard_Explanatory_Properties['RESOURCE_ID'])));
        debugLog(__FILE__, __METHOD__, __LINE__, var_export($re_array, true));
        if ($re_array !== false) {
            $this->vCard_Identification_Properties['RESOURCE_ID'] = $re_array['RESOURCE_ID'];
            return $this->vCard_Identification_Properties['RESOURCE_ID'];
        }
        return $re_array;
    }

    public function store_vCard_Delivery_Addressing_Properties_ADR() {
        $this->_get_storage_resource();
        /**
         * $this->vCard_Delivery_Addressing_Properties_ADR = array(
         *              array(…………)
         *              array(…………)
         *              array(…………)
         *       )
         */
        if (!isset($this->vCard_Explanatory_Properties['RESOURCE_ID']) and !isset($this->vCard_Explanatory_Properties['UID'])) {
            return false;
        } elseif (isset($this->vCard_Explanatory_Properties['UID'])) {
            $this->_get_vcard_resource_id_from_storage();
        }

        $re_array = $this->obj_vcard_storage->store_data('vCard_Delivery_Addressing_Properties_ADR', array_merge($this->vCard_Delivery_Addressing_Properties_ADR, array('V_ID' => $this->vCard_Explanatory_Properties['RESOURCE_ID'])));
        debugLog(__FILE__, __METHOD__, __LINE__, var_export($re_array, true));
        if ($re_array !== false) {
            foreach ($this->vCard_Delivery_Addressing_Properties_ADR as $key => $value) {
                if ($re_array[$key]) {
                    $this->vCard_Delivery_Addressing_Properties_ADR[$key]['RESOURCE_ID'] = $re_array[$key]['RESOURCE_ID'];
                }
            }
        }
        return $re_array;
    }

    public function store_vCard_Delivery_Addressing_Properties_LABEL() {
        $this->_get_storage_resource();
        if (!isset($this->vCard_Explanatory_Properties['RESOURCE_ID']) and !isset($this->vCard_Explanatory_Properties['UID'])) {
            return false;
        } elseif (isset($this->vCard_Explanatory_Properties['UID'])) {
            $this->_get_vcard_resource_id_from_storage();
        }

        $re_array = $this->obj_vcard_storage->store_data('vCard_Delivery_Addressing_Properties_LABEL', array_merge($this->vCard_Delivery_Addressing_Properties_LABEL, array('V_ID' => $this->vCard_Explanatory_Properties['RESOURCE_ID'])));
        debugLog(__FILE__, __METHOD__, __LINE__, var_export($re_array, true));
        if ($re_array !== false) {
            foreach ($this->vCard_Delivery_Addressing_Properties_LABEL as $key => $value) {
                if ($re_array[$key]) {
                    $this->vCard_Delivery_Addressing_Properties_LABEL[$key]['RESOURCE_ID'] = $re_array[$key]['RESOURCE_ID'];
                }
            }
        }
        return $re_array;
    }

    public function store_vCard_Geographical_Properties() {
        $this->_get_storage_resource();
        if (!isset($this->vCard_Explanatory_Properties['RESOURCE_ID']) and !isset($this->vCard_Explanatory_Properties['UID'])) {
            return false;
        } elseif (isset($this->vCard_Explanatory_Properties['UID'])) {
            $this->_get_vcard_resource_id_from_storage();
        }

        $re_array = $this->obj_vcard_storage->store_data('vCard_Geographical_Properties', array_merge($this->vCard_Geographical_Properties, array('V_ID' => $this->vCard_Explanatory_Properties['RESOURCE_ID'])));
        debugLog(__FILE__, __METHOD__, __LINE__, var_export($re_array, true));
        if ($re_array !== false) {

            $this->vCard_Geographical_Properties['RESOURCE_ID'] = $re_array['RESOURCE_ID'];
        }
        return $re_array;
    }

    public function store_vCard_Organizational_Properties() {
        $this->_get_storage_resource();
        if (!isset($this->vCard_Explanatory_Properties['RESOURCE_ID']) and !isset($this->vCard_Explanatory_Properties['UID'])) {
            return false;
        } elseif (isset($this->vCard_Explanatory_Properties['UID'])) {
            $this->_get_vcard_resource_id_from_storage();
        }
        $re_array = $this->obj_vcard_storage->store_data('vCard_Organizational_Properties', array_merge($this->vCard_Organizational_Properties, array('V_ID' => $this->vCard_Explanatory_Properties['RESOURCE_ID'])));
        debugLog(__FILE__, __METHOD__, __LINE__, var_export($re_array, true));
        if ($re_array !== false) {
            $this->vCard_Organizational_Properties['RESOURCE_ID'] = $re_array['RESOURCE_ID'];
        }
        return $re_array;
    }

    public function store_vCard_Telecommunications_Addressing_Properties_Email() {
        $this->_get_storage_resource();
        if (!isset($this->vCard_Explanatory_Properties['RESOURCE_ID']) and !isset($this->vCard_Explanatory_Properties['UID'])) {
            return false;
        } elseif (isset($this->vCard_Explanatory_Properties['UID'])) {
            $this->_get_vcard_resource_id_from_storage();
        }

        $re_array = $this->obj_vcard_storage->store_data('vCard_Telecommunications_Addressing_Properties_Email', array_merge($this->vCard_Telecommunications_Addressing_Properties_Email, array('V_ID' => $this->vCard_Explanatory_Properties['RESOURCE_ID'])));
        debugLog(__FILE__, __METHOD__, __LINE__, var_export($re_array, true));
        if ($re_array !== false) {
            foreach ($this->vCard_Telecommunications_Addressing_Properties_Email as $key => $value) {
                if ($re_array[$key]) {
                    $this->vCard_Telecommunications_Addressing_Properties_Email[$key]['RESOURCE_ID'] = $re_array[$key]['RESOURCE_ID'];
                }
            }
        }
        return $re_array;
    }

    public function store_vCard_Telecommunications_Addressing_Properties_Tel() {
        $this->_get_storage_resource();
        if (!isset($this->vCard_Explanatory_Properties['RESOURCE_ID']) and !isset($this->vCard_Explanatory_Properties['UID'])) {
            return false;
        } elseif (isset($this->vCard_Explanatory_Properties['UID'])) {
            $this->_get_vcard_resource_id_from_storage();
        }

        $re_array = $this->obj_vcard_storage->store_data('vCard_Telecommunications_Addressing_Properties_Tel', array_merge($this->vCard_Telecommunications_Addressing_Properties_Tel, array('V_ID' => $this->vCard_Explanatory_Properties['RESOURCE_ID'])));
        debugLog(__FILE__, __METHOD__, __LINE__, var_export($re_array, true));
        if ($re_array !== false) {
            foreach ($this->vCard_Telecommunications_Addressing_Properties_Tel as $key => $value) {
                if ($re_array[$key]) {
                    $this->vCard_Telecommunications_Addressing_Properties_Tel[$key]['RESOURCE_ID'] = $re_array[$key]['RESOURCE_ID'];
                }
            }
        }
        return $re_array;
    }

//    private static function checkExistVcardByUid($uid) {
//        if (0 != $count = $this->obj_vcard_storage->($uid)) {
//            return $count;
//        } else {
//            return 0;
//        }
//    }

    /**
     *  通过 UID () 取得某个vcard的摘要信息
     * @param <UID> $uid
     * @return <array> $vacar_summary{ 'Rev'=>,……}
     */
    public function get_vCard_Summary($uid) {
        $this->_get_storage_resource();
        $key = array('UID' => $uid, 'property' => 'vCard_Explanatory_Properties');

        $re_array = $this->get_vCard_property_from_storage($key);

        /**
         * @todo 将此处的debuglog打印出来
         */
        debugLog(__FILE__, __METHOD__, __LINE__, var_export($re_array, true));
        if ($re_array != '') {
            return array('id' => $uid, 'mod' => $re_array['REV'], 'flags' => 1);
        }
        return false;
    }

    /**
     *
     * @param <uuid> $uid (uuid)
     */
    public function get_Full_vCard_From_Storage($uid='') {
        if (isset($uid) && $uid !== '') {
            /**
             * 此处需要增加对 $uid 的检查
             */
            $this->vCard_Explanatory_Properties['UID'] = $uid;
        }
        if ($this->vCard_Explanatory_Properties['UID'] == '') {
            return false;
        }
        $re = $this->get_vCard_Explanatory_Properties(true);
//        debugLog(__FILE__,__METHOD__,__LINE__,var_export($re,true));
        $re = $this->get_vCard_Identification_Properties(true);
//        debugLog(__FILE__,__METHOD__,__LINE__,var_export($re,true));
        $re = $this->get_vCard_Delivery_Addressing_Properties_ADR(true);
//        debugLog(__FILE__,__METHOD__,__LINE__,var_export($re,true));
        $this->get_vCard_Delivery_Addressing_Properties_LABEL(true);
//        debugLog(__FILE__,__METHOD__,__LINE__,var_export($re,true));
        $re = $this->get_vCard_Geographical_Properties(true);
//        debugLog(__FILE__,__METHOD__,__LINE__,var_export($re,true));
        $re = $this->get_vCard_Organizational_Properties(true);
//        debugLog(__FILE__,__METHOD__,__LINE__,var_export($re,true));
        $re = $this->get_vCard_Telecommunications_Addressing_Properties_Email(true);
//        debugLog(__FILE__,__METHOD__,__LINE__,var_export($re,true));
        $re = $this->get_vCard_Telecommunications_Addressing_Properties_Tel(true);
//        debugLog(__FILE__,__METHOD__,__LINE__,var_export($re,true));
        debugLog(__FILE__, __METHOD__, __LINE__, var_export($this, true));
        return $this;
    }

    /**
     * 取得一个完整的vcard text
     * @param <UUID> $uid
     * $uid 在设计中，$uid为保存在 USER 表中的 user_vcard 的 vcard_name 字段，该字段被设计为vcard标准中的UID
     */
    public function get_vCard_Text($from_storage=false, $uid='') {

        if ($from_storage == true) {
            $this->get_Full_vCard_From_Storage($uid);
        }
        debugLog(__FILE__, __METHOD__, __LINE__, var_export($this, true));
        $re_lines = array();
        $re_lines[] = "BEGIN:VCARD";

//        if (!($this->_builder instanceof my_vcard_build)) {
//            try {
//                $this->_builder = new my_vcard_build ();
//            } catch (Exception $e) {
//                debugLog(__FILE__, __METHOD__, __LINE__, $e->getMessage());
//                return false;
//            }
//        }
//        debugLog(__FILE__, __METHOD__, __LINE__, var_export($this->_builder,true));
        /**
         * 将 $this->vCard_Explanatory_Properties 的属性添加到 _builder 中去
         *  $this->set_vCard_Explanatory_Properties(array(
         *  'UID' => $this->_builder->getUniqueID(),
         *  'REV' => (strlen($this->_builder->getRevision()) <= 1) ? date("c") : $this->_builder->getRevision(),
         *  'VERSION' => $this->_parser->getVersion(),
         *  'LANG' => $this->_builder->getLanguage(),
         *  'CATEGORIES' => $this->_builder->getCategories(),
         *  'PRODID' => $this->_builder->getProductID(),
         *  'SORT-STRING' => $this->_builder->getSortString()
         *   )
         */
//        $this->_builder->setUniqueID($this->vCard_Explanatory_Properties['UID']);
//        $this->_builder->setVersion($this->vCard_Explanatory_Properties['VERSION']);
//        $this->_builder->setRevision($this->vCard_Explanatory_Properties['REV']);
//        $this->_builder->setLanguage($this->vCard_Explanatory_Properties['LANG']);
//        $this->_builder->addCategories($this->vCard_Explanatory_Properties['CATEGORIES']);
//        $this->_builder->setProductID($this->vCard_Explanatory_Properties['PRODID']);
//        $this->_builder->setSortString($this->vCard_Explanatory_Properties['SORT-STRING']);

        $re_lines[] = 'UID:' . $this->vCard_Explanatory_Properties['UID'];
        $re_lines[] = 'VERSION:' . $this->vCard_Explanatory_Properties['VERSION'];
        if ($this->vCard_Explanatory_Properties['VERSION'] == '3.0') {
            $re_lines[] = "PROFILE:VCARD";
        }
        if ($this->vCard_Explanatory_Properties['REV'] != '')
            $re_lines[] = 'REV:' . $this->vCard_Explanatory_Properties['REV'];
        if ($this->vCard_Explanatory_Properties['LANG'] != '')
            $re_lines[] = 'LANG:' . $this->vCard_Explanatory_Properties['LANG'];

        if ($this->vCard_Explanatory_Properties['VERSION'] == '3.0') {
            if ($this->vCard_Explanatory_Properties['CATEGORIES'] != '')
                $re_lines[] = 'CATEGORIES:' . $this->vCard_Explanatory_Properties['CATEGORIES'];
            if ($this->vCard_Explanatory_Properties['PRODID'] != '')
                $re_lines[] = 'PRODID:' . $this->vCard_Explanatory_Properties['PRODID'];
            if ($this->vCard_Explanatory_Properties['SORT-STRING'] != '')
                $re_lines[] = 'SORT-STRING:' . $this->vCard_Explanatory_Properties['SORT-STRING'];
        }
//        $re_lines[] = ."\n";

        /**
         *   'FN' => $this->_builder->getFormattedName(),
         *   'N' => $this->_builder->getName(),
         *   'NICKNAME' => $this->_builder->getNickname(),
         *   'PHOTO' => $this->_builder->getPhoto(),
         *   'PhotoType' => $this->_builder->getType('PHOTO'),
         *   'BDAY' => $this->_builder->getBirthday(),
         *   'URL' => $this->_builder->getURL(),
         *   'SOUND' => $this->_builder->getSound(),
         *   'NOTE' => $this->_builder->getNote()
         *  @todo ‘PhotoType’需要加入到属性中
         */
//        $this->_builder->setFormattedName($this->vCard_Identification_Properties['FN']);
//        $N = explode(';', $this->vCard_Identification_Properties['N']);
//        $this->_builder->setName($N[FILE_IMC::VCARD_N_FAMILY], $N[FILE_IMC::VCARD_N_GIVEN], $N[FILE_IMC::VCARD_N_ADDL], $N[FILE_IMC::VCARD_N_PREFIX], $N[FILE_IMC::VCARD_N_SUFFIX]);
//        $N = NULL;
//        $this->_builder->addNickname($this->vCard_Identification_Properties['NICKNAME']);
//        $this->_builder->setPhoto($this->vCard_Identification_Properties['PHOTO']);
//        $this->_builder->setBirthday($this->vCard_Identification_Properties['BDAY']);
//        $this->_builder->setURL($this->vCard_Identification_Properties['URL']);
//        $this->_builder->setSound($this->vCard_Identification_Properties['SOUND']);
//        $this->_builder->setNote($this->vCard_Identification_Properties['NOTE']);

        $re_lines[] = 'FN:' . $this->vCard_Identification_Properties['FN'];
        $re_lines[] = 'N:' . $this->vCard_Identification_Properties['N'];
        if ($this->vCard_Explanatory_Properties['VERSION'] == '3.0') {
            if ($this->vCard_Identification_Properties['NICKNAME'] != '')
                $re_lines[] = 'NICKNAME:' . $this->vCard_Identification_Properties['NICKNAME'];
        }
        if ($this->vCard_Identification_Properties['PHOTO'] != '')
            $re_lines[] = 'PHOTO;' . 'TYPE=' . $this->vCard_Identification_Properties['PhotoType'] . ':' . $this->vCard_Identification_Properties['PHOTO'];
        if ($this->vCard_Identification_Properties['BDAY'] != '')
            $re_lines[] = 'BDAY:' . $this->vCard_Identification_Properties['BDAY'];
        if ($this->vCard_Identification_Properties['URL'] != '')
            $re_lines[] = 'URL:' . $this->vCard_Identification_Properties['URL'];
        if ($this->vCard_Identification_Properties['SOUND'] != '')
            $re_lines[] = 'SOUND:' . $this->vCard_Identification_Properties['SOUND'];
        if ($this->vCard_Identification_Properties['NOTE'] != '')
            $re_lines[] = 'NOTE:' . $this->vCard_Identification_Properties['NOTE'];
//        $re_lines[] = ."\n";



        /**
         * 'TITLE' => $this->_builder->getTitle(),
         * 'ROLE' => $this->_builder->getRole(),
         * 'LOGO' => $this->_builder->getLogo(),
         * 'LogoType' => $this->_builder->getType('LOGO'),
         * 'AGENT' => $this->_builder->getAgent(),
         * 'ORG' => $this->_builder->getOrg()
         */
//        $this->_builder->setTitle($this->vCard_Organizational_Properties['TITLE']);
//        $this->_builder->setRole($this->vCard_Organizational_Properties['ROLE']);
//        $this->_builder->setLogo($this->vCard_Organizational_Properties['LOGO']);
//        $this->_builder->setAgent($this->vCard_Organizational_Properties['AGENT']);
//        $this->_builder->addOrganization($this->vCard_Organizational_Properties['ORG']);

        if ($this->vCard_Organizational_Properties['TITLE'] != '')
            $re_lines[] = 'TITLE:' . $this->vCard_Organizational_Properties['TITLE'];
        if ($this->vCard_Organizational_Properties['ROLE'] != '')
            $re_lines[] = 'ROLE:' . $this->vCard_Organizational_Properties['ROLE'];
        if ($this->vCard_Organizational_Properties['LOGO'] != '')
            $re_lines[] = 'LOGO;' . 'TYPE=' . $this->vCard_Organizational_Properties['LogoType'] . ':' . $this->vCard_Organizational_Properties['LOGO'];
        if ($this->vCard_Organizational_Properties['AGENT'] != '')
            $re_lines[] = 'AGENT:' . $this->vCard_Organizational_Properties['AGENT'];
        if ($this->vCard_Organizational_Properties['ORG'] != '')
            $re_lines[] = 'ORG:' . $this->vCard_Organizational_Properties['ORG'];
//        $re_lines[] = ."\n";
        if ($this->vCard_Geographical_Properties['TZ'] != '')
            $re_lines[] = 'TZ:' . $this->vCard_Geographical_Properties['TZ'];
        if ($this->vCard_Geographical_Properties['GEO'] != '')
            $re_lines[] = 'GEO:' . $this->vCard_Geographical_Properties['GEO'];


        if (count($this->vCard_Delivery_Addressing_Properties_ADR) > 0) {
            foreach ($this->vCard_Delivery_Addressing_Properties_ADR as $v) {
                debugLog(__FILE__, __METHOD__, __LINE__, var_export($v, true));
                $re_lines[] = 'ADR;TYPE=' . $v['AdrType'] . ':' . $v['ADR'];
            }
        }

        if (count($this->vCard_Delivery_Addressing_Properties_LABEL) > 0) {
            foreach ($this->vCard_Delivery_Addressing_Properties_LABEL as $v) {
                debugLog(__FILE__, __METHOD__, __LINE__, var_export($v, true));
                $re_lines[] = 'LABEL;TYPE=' . $v['LabelType'] . ':' . $v['LABEL'];
            }
        }

        if (count($this->vCard_Telecommunications_Addressing_Properties_Tel) > 0) {
            foreach ($this->vCard_Telecommunications_Addressing_Properties_Tel as $v) {
                debugLog(__FILE__, __METHOD__, __LINE__, var_export($v, true));
                $re_lines[] = 'TEL;TYPE=' . $v['TelType'] . ':' . $v['TEL'];
            }
        }

        if (count($this->vCard_Telecommunications_Addressing_Properties_Email) > 0) {
            foreach ($this->vCard_Telecommunications_Addressing_Properties_Email as $v) {
                debugLog(__FILE__, __METHOD__, __LINE__, var_export($v, true));
                $re_lines[] = 'EMAIL;TYPE=' . $v['EmailType'] . ':' . $v['EMAIL'];
            }
        }

        debugLog(__FILE__, __METHOD__, __LINE__, var_export($re_lines, true));

        $re_lines[] = "END:VCARD";

        // version 3.0 uses \n for new lines,
        // version 2.1 uses \r\n
        $newline = "\n";
        if ($this->vCard_Explanatory_Properties['VERSION'] == '3.0') {
            $newline = "\r\n";
        }

        // fold lines at 75 characters
        $regex = "(.{1,75})";
        foreach ($re_lines as $key => $val) {
            $re_lines[$key] = stripslashes($val);
            if (strlen($val) > 75) {
                // we trim to drop the last newline, which will be added
                // again by the implode function at the end of fetch()
                $re_lines[$key] = trim(preg_replace("/$regex/i", "\\1$newline ", $val));
            }
        }

//        $this->_unescape($re_lines);
        return implode($newline, $re_lines);
    }

    /**
     * 返回vcard数据为一个 array
     * @param <bool> $from_storage
     * @param <uuid> $uuid
     */
    public function get_vCard_Data($from_storage,$uuid){
        if(isset ($from_storage) && $from_storage ){
            if(!isset ($uuid) or strlen($uuid) < 36){
                return FALSE;
            }
            $this->get_Full_vCard_From_Storage($uuid);
        }
        return array(
            'vCard_Explanatory_Properties'=>$this->get_vCard_Explanatory_Properties(),
            'vCard_Identification_Properties'=>$this->get_vCard_Identification_Properties(),
            'vCard_Delivery_Addressing_Properties_ADR'=>$this->get_vCard_Delivery_Addressing_Properties_ADR(),
            'vCard_Delivery_Addressing_Properties_LABEL'=>$this->get_vCard_Delivery_Addressing_Properties_LABEL(),
            'vCard_Geographical_Properties'=>$this->get_vCard_Geographical_Properties(),
            'vCard_Organizational_Properties' => $this->get_vCard_Organizational_Properties(),
            'vCard_Telecommunications_Addressing_Properties_Email'=>$this->get_vCard_Telecommunications_Addressing_Properties_Email(),
            'vCard_Telecommunications_Addressing_Properties_Tel'=>$this->get_vCard_Telecommunications_Addressing_Properties_Tel(),
        );
    }
}

?>