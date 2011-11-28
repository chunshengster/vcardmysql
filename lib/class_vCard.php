<?php

/**
 * @author chunshengster@gmail.com
 * @version $Id$
 */
require_once 'my_vcard_parse.php';
require_once 'my_vcard_build.php';
require_once 'class_get_img.php';
require_once 'class_vcard_storage.php';

if (!function_exists('debugLog')) {
    require_once dirname(__FILE__) . '/debug.php';
}

class class_vCard {

    /**
     * @var <storage object> 存储对象
     */
    private $obj_vcard_storage;
    private $_parser;

    /**
     *
     * @var my_vcard_build
     */
    private $_builder;
    private $vCard_Explanatory_Properties = array();
    private $vCard_Identification_Properties = array();
    private $vCard_Delivery_Addressing_Properties_ADR = array();
    private $vCard_Delivery_Addressing_Properties_LABEL = array();
    private $vCard_Geographical_Properties = array();
    private $vCard_Organizational_Properties = array();
    private $vCard_Telecommunications_Addressing_Properties_Email = array();
    private $vCard_Telecommunications_Addressing_Properties_Tel = array();
    private $vCard_Extension_Properties = array();

    function __construct($v = null) {
        if (isset($v) and self::varify_vCard_data($v) and is_array($v)) {
//            if (isset($v['vCard_Explanatory_Properties'])) {
            //var_export($v);

            $this->set_vCard_Explanatory_Properties($v['vCard_Explanatory_Properties']);
//            }
            if (isset($v['vCard_Identification_Properties'])) {
                $this->set_vCard_Identification_Properties($v['vCard_Identification_Properties']);
            }

            if (isset($v['vCard_Organizational_Properties'])) {
                $this->set_vCard_Organizational_Properties($v['vCard_Organizational_Properties']);
            }

            if (isset($v['vCard_Geographical_Properties'])) {
                $this->set_vCard_Geographical_Properties($v['vCard_Geographical_Properties']);
            }

            if (isset($v['vCard_Delivery_Addressing_Properties_ADR'])) {
                $this->set_vCard_Delivery_Addressing_Properties_ADR($v['vCard_Delivery_Addressing_Properties_ADR']);
            }

            if (isset($v['vCard_Delivery_Addressing_Properties_LABEL'])) {
                $this->set_vCard_Delivery_Addressing_Properties_LABEL($v['vCard_Delivery_Addressing_Properties_LABEL']);
            }

            if (isset($v['vCard_Telecommunications_Addressing_Properties_Email'])) {
                $this->set_vCard_Telecommunications_Addressing_Properties_Email($v['vCard_Telecommunications_Addressing_Properties_Email']);
            }

            if (isset($v['vCard_Telecommunications_Addressing_Properties_Tel'])) {
                $this->set_vCard_Telecommunications_Addressing_Properties_Tel($v['vCard_Telecommunications_Addressing_Properties_Tel']);
            }

            if (isset($v['vCard_Extension_Properties'])) {
                $this->set_vCard_Extension_Properties($v['vCard_Extension_Properties']);
            }


            return $this;
        } elseif (isset($v) and self::varify_vCard_data($v) and ($v instanceof class_vCard)) {
            $this->set_vCard_Explanatory_Properties($v->vCard_Explanatory_Properties);
            $this->set_vCard_Identification_Properties($v->vCard_Identification_Properties);
            $this->set_vCard_Organizational_Properties($v->vCard_Organizational_Properties);
            $this->set_vCard_Delivery_Addressing_Properties_ADR($v->vCard_Delivery_Addressing_Properties_ADR);
            $this->set_vCard_Delivery_Addressing_Properties_LABEL($v->vCard_Delivery_Addressing_Properties_LABEL);
            $this->set_vCard_Geographical_Properties($v->vCard_Geographical_Properties);
            $this->set_vCard_Telecommunications_Addressing_Properties_Email($v->vCard_Telecommunications_Addressing_Properties_Email);
            $this->set_vCard_Telecommunications_Addressing_Properties_Tel($v->vCard_Telecommunications_Addressing_Properties_Tel);
            $this->set_vCard_Extension_Properties($v->vCard_Extension_Properties);
        }
    }

//    function  __clone() {
//    }

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
            if (isset($this->vCard_Explanatory_Properties['UID']) and ($this->vCard_Explanatory_Properties['UID'] != '')) {
                $key = array(
                    'UID' => $this->vCard_Explanatory_Properties['UID'],
                );
            } elseif ($this->vCard_Explanatory_Properties['RESOURCE_ID'] != '' and isset($this->vCard_Explanatory_Properties['RESOURCE_ID'])) {
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
            if (isset($this->vCard_Explanatory_Properties['RESOURCE_ID']) and ($this->vCard_Explanatory_Properties['RESOURCE_ID'] !== '')) {
                $key = array(
                    'vCard_Explanatory_Properties_idvCard_Explanatory_Properties' => $this->vCard_Explanatory_Properties['RESOURCE_ID'],
                );
            } elseif ((isset($this->vCard_Identification_Properties['RESOURCE_ID'])) and ($this->vCard_Identification_Properties['RESOURCE_ID'] !== '')) {
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
        /**
         * 增加对 vCard_Explanatory_Properties['SORT-STRING']内容的填充
         */
        try {
            require_once dirname(__FILE__) . '/pinyin_lib.php';
            $name = strlen($vCard_Identification_Properties['FN']) > 1 ? $vCard_Identification_Properties['FN'] : $vCard_Identification_Properties['N'];
            $pinyin = Pinyin($name, 'utf-8');
            $this->vCard_Explanatory_Properties['SORT-STRING'] = $pinyin;
        } catch (Exception $e) {
            debugLog(__FILE__, __METHOD__, __LINE__, var_export($e->getTraceAsString(), true));
        }
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
            } elseif ((isset($this->vCard_Explanatory_Properties['RESOURCE_ID'])) and ($this->vCard_Explanatory_Properties['RESOURCE_ID'] !== '')) {
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
            } elseif ((isset($this->vCard_Explanatory_Properties['RESOURCE_ID'])) and ($this->vCard_Explanatory_Properties['RESOURCE_ID'] !== '')) {
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
            if ((isset($this->vCard_Explanatory_Properties['RESOURCE_ID'])) and ($this->vCard_Explanatory_Properties['RESOURCE_ID'] !== '')) {
                $key = array(
                    'vCard_Explanatory_Properties_idvCard_Explanatory_Properties' => $this->vCard_Explanatory_Properties['RESOURCE_ID'],
                );
            } elseif ((isset($this->vCard_Geographical_Properties['RESOURCE_ID'])) and ($this->vCard_Geographical_Properties['RESOURCE_ID'] !== '')) {
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
            if ((isset($this->vCard_Explanatory_Properties['RESOURCE_ID'])) and ($this->vCard_Explanatory_Properties['RESOURCE_ID'] !== '')) {
                $key = array(
                    'vCard_Explanatory_Properties_idvCard_Explanatory_Properties' => $this->vCard_Explanatory_Properties['RESOURCE_ID'],
                );
            } elseif (isset($this->vCard_Organizational_Properties['RESOURCE_ID']) && $this->vCard_Organizational_Properties['RESOURCE_ID'] !== '') {
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
            } elseif ((isset($this->vCard_Explanatory_Properties['RESOURCE_ID'])) and ($this->vCard_Explanatory_Properties['RESOURCE_ID'] !== '')) {
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
            } elseif ((isset($this->vCard_Explanatory_Properties['RESOURCE_ID'])) and ($this->vCard_Explanatory_Properties['RESOURCE_ID'] !== '')) {
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

    public function get_vCard_Extension_Properties($from_storage = false, $resource_id = '') {
        if ($from_storage == FALSE) {
            return $this->vCard_Extension_Properties;
        } else {
            $key = array();
            $re_array = array();
            debugLog(__FILE__, __METHOD__, __LINE__, var_export($this->vCard_Explanatory_Properties, true));
            debugLog(__FILE__, __METHOD__, __LINE__, var_export($this->vCard_Extension_Properties, true));

            $this->_get_storage_resource();
            if ($resource_id !== '') {
                $key = array(
                    'idvCard_Extension_Properties' => $resource_id,
                );
                $re_array = $this->obj_vcard_storage->get_vCard_Extension_Properties($key);
                debugLog(__FILE__, __METHOD__, __LINE__, var_export($key, true));
                debugLog(__FILE__, __METHOD__, __LINE__, var_export($re_array, true));
                foreach ($this->vCard_Extension_Properties as $k => $v) {
                    if ($this->vCard_Extension_Properties[$k]['RESOURCE_ID'] == $resource_id) {
                        $this->vCard_Extension_Properties[$k] = $re_array[0];
                        debugLog(__FILE__, __METHOD__, __LINE__, var_export($this->vCard_Extension_Properties[$k], true));
                        return $this->vCard_Extension_Properties[$k];
                    }
                }
            } elseif ((isset($this->vCard_Explanatory_Properties['RESOURCE_ID'])) and ($this->vCard_Explanatory_Properties['RESOURCE_ID'] !== '')) {
                $key = array(
                    'vCard_Explanatory_Properties_idvCard_Explanatory_Properties' => $this->vCard_Explanatory_Properties['RESOURCE_ID'],
//                    'vCard_Explanatory_Properties_idvCard_Explanatory_Properties' => 190,
                );
                debugLog(__FILE__, __METHOD__, __LINE__, var_export($key, true));
                $re_array = $this->obj_vcard_storage->get_vCard_Extension_Properties($key);
                debugLog(__FILE__, __METHOD__, __LINE__, var_export($re_array, true));
                $this->set_vCard_Extension_Properties($re_array);
                return $this->vCard_Extension_Properties;
            }
        }
        return false;
    }

    public function set_vCard_Extension_Properties($vCard_Extension_Properties) {
        $this->vCard_Extension_Properties = $vCard_Extension_Properties;
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

        $data = $this->_parser->fromText($vcard_text, true);
//        print_r($this->_parser->get_parse_data());
//        debugLog(__FILE__, __METHOD__, __LINE__, "\n", var_export($this->_parser->get_parse_data(),true), "\n");

        @$this->_builder->setFromArray($this->_parser->get_parse_data());
//        echo var_export($this->_parser->get_parse_data(), true);
        debugLog(__FILE__, __CLASS__, __METHOD__, __LINE__, var_export($this->_builder, true));

        $this->set_vCard_Explanatory_Properties(array(
            'UID' => $this->_builder->getUniqueID(),
            'REV' => (strlen($this->_builder->getRevision()) <= 1) ? date('Y-m-d H:i:s') : $this->_builder->getRevision(),
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
            'FN' => (mb_strlen($this->_builder->getFormattedName(), 'utf-8') > 0) ? $this->_builder->getFormattedName() : implode('', explode(';', $this->_builder->getName())),
            'N' => $this->_builder->getName(),
            'NICKNAME' => $this->_builder->getNickname(),
            'PHOTO' => $this->_builder->getPhoto(),
            'PhotoType' => $this->_builder->getType('PHOTO'),
            'BDAY' => ($this->_builder->getBirthday() == '') ? '1970-01-01' : $this->_builder->getBirthday(),
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

        if (($x_microblog = $this->_builder->get_x_microblog()) != '') {
            $this->set_vCard_Extension_Properties(array_merge($this->vCard_Extension_Properties, array(
                        'X-MICROBLOG' => $this->_builder->get_x_microblog(),
                            )
                    )
            );
        }

        $this->_parser = NULL;
        $this->_builder = NULL;
        return $this;
    }

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

    public function store_vCard_Explanatory_Properties($gen_uid = false) {

        debugLog(__FILE__, __METHOD__, __LINE__, var_export($this->vCard_Explanatory_Properties, true));
        $this->_get_storage_resource();
        if (!isset($this->vCard_Explanatory_Properties['UID']) || $this->vCard_Explanatory_Properties['UID'] == '') {
            $gen_uid = true;
        }
        if (count($this->vCard_Explanatory_Properties) <= 0) {
            $gen_uid = true;
        }
        $re_array = $this->obj_vcard_storage->store_data('vCard_Explanatory_Properties', $this->vCard_Explanatory_Properties, $gen_uid);
        debugLog(__FILE__, __METHOD__, __LINE__, var_export($re_array, true));
        if ($re_array !== false) {
            if ($re_array['UID'] !== ''
                    and (!isset($this->vCard_Explanatory_Properties['UID'])
                    or ((isset($this->vCard_Explanatory_Properties['UID'])
                    and ($this->vCard_Explanatory_Properties['UID'] == ''))))) {
                $this->vCard_Explanatory_Properties['UID'] = $re_array['UID'];
            }

            /**
             * @todo 修正数据结构，每个结构分块都返回并记录该条在数据库中的id ,已完成
             */
            $this->vCard_Explanatory_Properties['RESOURCE_ID'] = $re_array['RESOURCE_ID'];
//            return $this->vCard_Explanatory_Properties['RESOURCE_ID'];
        }
        return $re_array;
    }

    public function store_vCard_Identification_Properties() {
        if (count($this->vCard_Identification_Properties) <= 1) {
            return true;
        }
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
//            return $this->vCard_Identification_Properties['RESOURCE_ID'];
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
        if (count($this->vCard_Delivery_Addressing_Properties_ADR) <= 0) {
            return true;
        }
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
        if (count($this->vCard_Delivery_Addressing_Properties_LABEL) <= 0) {
            return true;
        }
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
        if (count($this->vCard_Geographical_Properties) <= 1) {
            return true;
        }
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
        if (count($this->vCard_Organizational_Properties) <= 0) {
            return true;
        }
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
        if (count($this->vCard_Telecommunications_Addressing_Properties_Email) <= 0) {
            return true;
        }
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
        if (count($this->vCard_Telecommunications_Addressing_Properties_Tel) <= 0) {
            return true;
        }
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

    /**
     * @tutorial 该属性的 store 操作前，建议先使用 get* 方法，取出，并做 array_merge()操作，避免同名扩展成为新增条目，并且在再次从存储中取出时发生覆盖的现象
     * @todo 该方法需要对存储前是否存在同名扩展项进行检测，合并，对应扩展项 增加 FLAG=>“CHANGE” 标志
     * @return <type>
     */
    public function store_vCard_Extension_Properties() {
        if (count($this->vCard_Extension_Properties) <= 0) {
            return true;
        }
        $this->_get_storage_resource();
        if (!isset($this->vCard_Explanatory_Properties['RESOURCE_ID']) and !isset($this->vCard_Explanatory_Properties['UID'])) {
            return false;
        } elseif (isset($this->vCard_Explanatory_Properties['UID'])) {
            $this->_get_vcard_resource_id_from_storage();
        }

        $re_array = $this->obj_vcard_storage->store_data('vCard_Extension_Properties', array_merge($this->vCard_Extension_Properties, array('V_ID' => $this->vCard_Explanatory_Properties['RESOURCE_ID'])));
        debugLog(__FILE__, __METHOD__, __LINE__, var_export($re_array, true));
        /**
         * @todo vCard_Extension_Properties 的存储方法未完成
         *
         */
        if ($re_array !== false) {
            foreach ($this->vCard_Extension_Properties as $key => $value) {
                if ($re_array[$key]) {
                    $this->vCard_Extension_Properties[$key]['RESOURCE_ID'] = $re_array[$key]['RESOURCE_ID'];
                }
            }
        }
        return $re_array;
    }

    /**
     *  通过 UID () 取得某个vcard的摘要信息
     * @param UID $uid UUID
     * @return array $vacar_summary  { 'Rev'=>,……}
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
     * @param <string> $uid
     * @param <int> $vcard_id
     * @return $this
     */
    public function get_Full_vCard_From_Storage($uid= null, $vcard_id = null) {
        if (isset($uid) && ($uid != '')) {
            /**
             * 此处需要增加对 $uid 的检查
             */
            $this->vCard_Explanatory_Properties['UID'] = $uid;
        } elseif (isset($vcard_id) && (gettype(intval($vcard_id)) == 'integer')) {
            $this->vCard_Explanatory_Properties['RESOURCE_ID'] = $vcard_id;
        } elseif (!isset($this->vCard_Explanatory_Properties['RESOURCE_ID']) and !isset($this->vCard_Explanatory_Properties['UID'])) {
            return FALSE;
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
        $re = $this->get_vCard_Extension_Properties(true);
        debugLog(__FILE__, __METHOD__, __LINE__, var_export($re, true));
        return $this;
    }

    /**
     * 取得一个完整的vcard text
     * @param <bool> true | false
     * @param <UUID> $uid
     * @param <int> $max_size 
     * $uid 在设计中，$uid为保存在 USER 表中的 user_vcard 的 vcard_name 字段，该字段被设计为vcard标准中的UID
     */
    public function get_vCard_Text($from_storage=false, $uid='', $max_size=null) {

        if ($from_storage == true) {
            $this->get_Full_vCard_From_Storage($uid);
        }
        debugLog(__FILE__, __METHOD__, __LINE__, var_export($this, true));

        // version 3.0 uses \n for new lines,
        // version 2.1 uses \r\n
        $newline = "\n";
        if ($this->vCard_Explanatory_Properties['VERSION'] == '3.0') {
            $newline = "\r\n";
        }

        $re_lines = array();
        $re_lines[] = "BEGIN:VCARD";

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

        $re_lines[] = 'FN;CHARSET=UTF-8:' . $this->vCard_Identification_Properties['FN'];
        $re_lines[] = 'N;CHARSET=UTF-8:' . $this->vCard_Identification_Properties['N'];
        if ($this->vCard_Explanatory_Properties['VERSION'] == '3.0') {
            if ($this->vCard_Identification_Properties['NICKNAME'] != '')
                $re_lines[] = 'NICKNAME;CHARSET=UTF-8:' . $this->vCard_Identification_Properties['NICKNAME'];
        }



        if ($this->vCard_Identification_Properties['BDAY'] != '' and $this->vCard_Identification_Properties['BDAY'] != '1970-01-01')
            $re_lines[] = 'BDAY:' . $this->vCard_Identification_Properties['BDAY'];
        if ($this->vCard_Identification_Properties['URL'] != '')
            $re_lines[] = 'URL:' . $this->vCard_Identification_Properties['URL'];
        if ($this->vCard_Identification_Properties['SOUND'] != '')
            $re_lines[] = 'SOUND:' . $this->vCard_Identification_Properties['SOUND'];
        if ($this->vCard_Identification_Properties['NOTE'] != '')
            $re_lines[] = 'NOTE;CHARSET=UTF-8:' . $this->vCard_Identification_Properties['NOTE'];
//        $re_lines[] = ."\n";



        if ($this->vCard_Organizational_Properties['TITLE'] != '')
            $re_lines[] = 'TITLE;CHARSET=UTF-8:' . $this->vCard_Organizational_Properties['TITLE'];
        if ($this->vCard_Organizational_Properties['ROLE'] != '')
            $re_lines[] = 'ROLE;CHARSET=UTF-8:' . $this->vCard_Organizational_Properties['ROLE'];
        if ($this->vCard_Organizational_Properties['LOGO'] != '')
            $re_lines[] = 'LOGO;' . 'TYPE=' . $this->vCard_Organizational_Properties['LogoType'] . ':' . $this->vCard_Organizational_Properties['LOGO'];
        if (isset($this->vCard_Organizational_Properties['AGENT']) and ($this->vCard_Organizational_Properties['AGENT'] != ''))
            $re_lines[] = 'AGENT:' . $this->vCard_Organizational_Properties['AGENT'];
        if ($this->vCard_Organizational_Properties['ORG'] != '')
            $re_lines[] = 'ORG;CHARSET=UTF-8:' . $this->vCard_Organizational_Properties['ORG'];

//        $re_lines[] = ."\n";
        if (isset($this->vCard_Geographical_Properties['TZ']) and ($this->vCard_Geographical_Properties['TZ'] != ''))
            $re_lines[] = 'TZ:' . $this->vCard_Geographical_Properties['TZ'];
        if (isset($this->vCard_Geographical_Properties['GEO']) and (strlen($this->vCard_Geographical_Properties['GEO']) > 2))
            $re_lines[] = 'GEO:' . $this->vCard_Geographical_Properties['GEO'];


        if (count($this->vCard_Delivery_Addressing_Properties_ADR) > 0) {
            foreach ($this->vCard_Delivery_Addressing_Properties_ADR as $v) {
                debugLog(__FILE__, __METHOD__, __LINE__, var_export($v, true));
                $re_lines[] = 'ADR;TYPE=' . $v['AdrType'] . ';CHARSET=UTF-8:' . $v['ADR'];
            }
        }

        if (count($this->vCard_Delivery_Addressing_Properties_LABEL) > 0) {
            foreach ($this->vCard_Delivery_Addressing_Properties_LABEL as $v) {
                debugLog(__FILE__, __METHOD__, __LINE__, var_export($v, true));
                $re_lines[] = 'LABEL;TYPE=' . $v['LabelType'] . ';CHARSET=UTF-8:' . $v['LABEL'];
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


        if (isset($this->vCard_Identification_Properties['PHOTO']) and $this->vCard_Identification_Properties['PHOTO'] != '') {
            if ($this->vCard_Identification_Properties['PhotoType'] === 'URL') {
                $t = getImg::get_url_img($this->vCard_Identification_Properties['PHOTO']);
                $this->vCard_Identification_Properties['PHOTO'] = isset($t['data']) ? $t['data'] : '';
                $this->vCard_Identification_Properties['PhotoType'] = isset($t['type']) ? $t['type'] : '';
            }

            $pt = 'ENCODING=BASE64;TYPE=' . $this->vCard_Identification_Properties['PhotoType'];
            $re_lines_photo[] = 'PHOTO;' . $pt . ':' . $this->vCard_Identification_Properties['PHOTO'];
        }

        if (count($this->vCard_Extension_Properties) > 0) {
            foreach ($this->vCard_Extension_Properties as $k => $v) {
                if (isset($v['RESOURCE_ID'])) {
                    unset($v['RESOURCE_ID']);
                }
                debugLog(__FILE__, __METHOD__, __LINE__, var_export($k, true));
                debugLog(__FILE__, __METHOD__, __LINE__, var_export($v, true));
                if (is_array($v)) {
                    $re_lines[] = $k . ':' . implode('@', $v);
                } else {
                    $re_lines_ext[] = $k . ':' . $v;
                }
            }
        }

        if (isset($re_lines_photo)) {
            if (!isset($max_size) or (isset($max_size) and mb_strlen(implode($newline, $re_lines), 'utf8') + mb_strlen(implode($newline, $re_lines_photo), 'utf8') < ($max_size - 10))) {
                foreach ($re_lines_photo as $_p) {
                    $re_lines[] = $_p;
                }
            }
        }
        if (isset($re_lines_ext)) {
            if (!isset($max_size) or (isset($max_size) and mb_strlen(implode($newline, $re_lines), 'utf8') + mb_strlen(implode($newline, $re_lines_ext), 'utf8') < ($max_size - 10))) {
                foreach ($re_lines_ext as $_e) {
                    $re_lines[] = $_e;
                }
            }
        }

        debugLog(__FILE__, __METHOD__, __LINE__, var_export($re_lines, true));

        $re_lines[] = "END:VCARD";



        // fold lines at 75 characters
        $regex = "(.{1,75})";
        foreach ($re_lines as $key => $val) {
            $re_lines[$key] = stripslashes($val);
            if (mb_strlen($val, 'utf8') > 75) {
                // we trim to drop the last newline, which will be added
                // again by the implode function at the end of fetch()
                $re_lines[$key] = trim(preg_replace("/$regex/iu", "\\1$newline ", $val));
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
    public function get_vCard_Data($from_storage=null, $uuid=null) {
        if (isset($from_storage) && $from_storage) {
            if (!isset($uuid) or strlen($uuid) < 36) {
                return FALSE;
            }
            $this->get_Full_vCard_From_Storage($uuid);
        }
        return array(
            'vCard_Explanatory_Properties' => $this->get_vCard_Explanatory_Properties(),
            'vCard_Identification_Properties' => $this->get_vCard_Identification_Properties(),
            'vCard_Delivery_Addressing_Properties_ADR' => $this->get_vCard_Delivery_Addressing_Properties_ADR(),
            'vCard_Delivery_Addressing_Properties_LABEL' => $this->get_vCard_Delivery_Addressing_Properties_LABEL(),
            'vCard_Geographical_Properties' => $this->get_vCard_Geographical_Properties(),
            'vCard_Organizational_Properties' => $this->get_vCard_Organizational_Properties(),
            'vCard_Telecommunications_Addressing_Properties_Email' => $this->get_vCard_Telecommunications_Addressing_Properties_Email(),
            'vCard_Telecommunications_Addressing_Properties_Tel' => $this->get_vCard_Telecommunications_Addressing_Properties_Tel(),
            'vCard_Extension_Properties' => $this->get_vCard_Extension_Properties(),
        );
    }

    public static function varify_vCard_data($vcard) {
        if (!is_array($vcard) and (count($vcard) <= 0) and !($vcard instanceof class_vCard)) {
            return FALSE;
        }
        /**
         * @todo 该函数需要完善
         * 
         */
        return TRUE;
    }

    public function store_vCard() {
        if (!self::varify_vCard_data($this)) {
            return false;
        }

        /**
         * @tutorial 对于 store_* 类方法的返回值判断 应使用 === 
         */
        debugLog(__FILE__, __CLASS__, __METHOD__, __LINE__, var_export($this, TRUE));
        $re = $this->store_vCard_Explanatory_Properties();
        debugLog(__FILE__, __CLASS__, __METHOD__, __LINE__, var_export($re, true));
        if ($re === FALSE) {
            debugLog(__FILE__, __CLASS__, __METHOD__, __LINE__, var_export($this->get_vCard_Explanatory_Properties(), true));
//            return false;
        }

        $re = $this->store_vCard_Identification_Properties();
        debugLog(__FILE__, __CLASS__, __METHOD__, __LINE__, var_export($re, true));
        if ($re === FALSE) {
            debugLog(__FILE__, __CLASS__, __METHOD__, __LINE__, var_export($this->get_vCard_Identification_Properties(), true));
//            return false;
        }

        $re = $this->store_vCard_Organizational_Properties();
        debugLog(__FILE__, __CLASS__, __METHOD__, __LINE__, var_export($re, true));
        if ($re === FALSE) {
            debugLog(__FILE__, __CLASS__, __METHOD__, __LINE__, var_export($this->get_vCard_Organizational_Properties(), true));
//            return false;
        }

        $re = $this->store_vCard_Delivery_Addressing_Properties_ADR();
        debugLog(__FILE__, __CLASS__, __METHOD__, __LINE__, var_export($re, true));
        if ($re === FALSE) {
            debugLog(__FILE__, __CLASS__, __METHOD__, __LINE__, var_export($this->get_vCard_Delivery_Addressing_Properties_ADR(), true));
//            return false;
        }

        $re = $this->store_vCard_Geographical_Properties();
        debugLog(__FILE__, __CLASS__, __METHOD__, __LINE__, var_export($re, true));
        if ($re === FALSE) {
            debugLog(__FILE__, __CLASS__, __METHOD__, __LINE__, var_export($this->get_vCard_Geographical_Properties(), true));
//            return false;
        }


        $re = $this->store_vCard_Delivery_Addressing_Properties_LABEL();
        debugLog(__FILE__, __CLASS__, __METHOD__, __LINE__, var_export($re, true));
        if ($re === FALSE) {
            debugLog(__FILE__, __CLASS__, __METHOD__, __LINE__, var_export($this->get_vCard_Delivery_Addressing_Properties_LABEL(), true));
//            return false;
        }

        $re = $this->store_vCard_Telecommunications_Addressing_Properties_Tel();
        debugLog(__FILE__, __CLASS__, __METHOD__, __LINE__, var_export($re, true));
        if ($re === FALSE) {
            debugLog(__FILE__, __CLASS__, __METHOD__, __LINE__, var_export($this->get_vCard_Telecommunications_Addressing_Properties_Tel(), true));
//            return false;
        }

        $re = $this->store_vCard_Telecommunications_Addressing_Properties_Email();
        debugLog(__FILE__, __CLASS__, __METHOD__, __LINE__, var_export($re, true));
        if ($re === FALSE) {
            debugLog(__FILE__, __CLASS__, __METHOD__, __LINE__, var_export($this->get_vCard_Telecommunications_Addressing_Properties_Email(), true));
//            return false;
        }

        $re = $this->store_vCard_Extension_Properties();
        debugLog(__FILE__, __CLASS__, __METHOD__, __LINE__, var_export($re, true));
        if ($re === FALSE) {
            debugLog(__FILE__, __CLASS__, __METHOD__, __LINE__, var_export($this->get_vCard_Extension_Properties(), true));
//            return false;
        }

        return $this->get_vCard_Data();
    }

}

?>