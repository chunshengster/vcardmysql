<?php

/**
 * 在通讯录数据库中查找可能重复的 vcard 数据
 * @author chunsheng
 */
class vCard_Duplicate_Lib {

    protected static $vcard_db_para_file = null; //dirname(__FILE__).'/config.ini';
    protected $dbh = null;
    protected static $db_host = null;
    protected static $db_port = null;
    protected static $db_user = null;
    protected static $db_pass = null;
    protected static $db_driver = null;
    protected static $db_name = null;
//	private static $storage_id;
    private static $vCard_Explanatory_Properties = 'vCard_Explanatory_Properties';
    private static $vCard_Identification_Properties = 'vCard_Identification_Properties';
    private static $vCard_Delivery_Addressing_Properties_ADR = 'vCard_Delivery_Addressing_Properties_ADR';
    private static $vCard_Delivery_Addressing_Properties_LABEL = 'vCard_Delivery_Addressing_Properties_LABEL';
    private static $vCard_Geographical_Properties = 'vCard_Geographical_Properties';
    private static $vCard_Organizational_Properties = 'vCard_Organizational_Properties';
    private static $vCard_Telecommunications_Addressing_Properties_Email = 'vCard_Telecommunications_Addressing_Properties_Email';
    private static $vCard_Telecommunications_Addressing_Properties_Tel = 'vCard_Telecommunications_Addressing_Properties_Tel';

    function __construct() {
        self::$vcard_db_para_file = dirname(__FILE__) . '/../config/config.ini';
        self::getMysqlPara();
    }

    function __destruct() {
        if ($this->dbh) {
            unset($this->dbh);
        }
    }

    private function getInstance() {
        $dsn = self::$db_driver . ":host=" . self::$db_host . ";port=" . self::$db_port . ";dbname=" . self::$db_name;
        try {
            $this->dbh = new PDO($dsn, self::$db_user, self::$db_pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->dbh;
        } catch (PDOException $e) {
            debugLog(__FILE__, __METHOD__, __LINE__, $e->getMessage());
        }
    }

    private function _gen_mysql_resource() {
        if (!($this->dbh instanceof PDO)) {
            $this->getInstance();
        } elseif (!($this->is_alive())) {
            $this->getInstance();
        }
        return true;
    }

    public function is_alive() {
        if ($this->dbh instanceof PDO) {
            if ($this->dbh->getAttribute(PDO::ATTR_CONNECTION_STATUS) > 0) {
                return true;
            }
        } else {
            return false;
        }
    }

    private static function getMysqlPara() {
        $config_data = parse_ini_file(self::$vcard_db_para_file, 'vcard_db');

        self::$db_driver = $config_data ['vcard_db'] ['driver'];
        self::$db_host = $config_data ['vcard_db'] ['mysql_host'];
        self::$db_port = $config_data ['vcard_db'] ['mysql_port'];
        self::$db_name = $config_data ['vcard_db'] ['db_name'];
        self::$db_user = $config_data ['vcard_db'] ['db_user'];
        self::$db_pass = $config_data ['vcard_db'] ['db_pass'];
    }

    /**
     * @param <string> $key 查找可能重复vcard条目的key（如 EMAIL,TEL，FN等，分别表示查找email相同的不同vcard条目，tel相同的不同vcard条目，FN相同的不同vcard条目）
     * @param <mixed> $array  如 array(160,189,191)，array中的元素表示 vcard_id 
     * @return <array> $r_array 返回差重的结果
     */
    public function findDuplicate($key, $id_list) {
        $this->_gen_mysql_resource();

        if ($key === 'FN') {
            /** 原始SQL
              $SQL_FIND_DUPLICATE = "SELECT
              group_concat(`vCard_Explanatory_Properties_idvCard_Explanatory_Properties`)
              as 'result_group',FN
              FROM " . self::$vCard_Identification_Properties .
              " WHERE `vCard_Explanatory_Properties_idvCard_Explanatory_Properties`
              IN (" . $id_list . ") GROUP BY `FN`;";
             */
            /**
             * 对FN字段中的空格进行过滤
             */
            $SQL_FIND_DUPLICATE = "SELECT 
                group_concat(`vCard_Explanatory_Properties_idvCard_Explanatory_Properties`) 
                as 'result_group',replace(TRIM(FN),' ','') as FN_O  
                FROM " . self::$vCard_Identification_Properties .
                    " WHERE `vCard_Explanatory_Properties_idvCard_Explanatory_Properties`
                IN (" . $id_list . ") and FN <> '' GROUP BY FN_O;";

            try {
                $sth = $this->dbh->query($SQL_FIND_DUPLICATE);
                $re_array = $sth->fetchAll(PDO::FETCH_ASSOC);
                foreach ($re_array as $k => $v) {
                    $t = explode(',', $v['result_group']);
                    if (count($t) < 2) {
                        unset($re_array[$k]);
                        continue;
                    }
                    unset($re_array[$k]);
                    $re_array[$v['FN_O']] = $t;
                }
                return $re_array;
            } catch (PDOException $e) {
                debugLog(__FILE__, __CLASS__, __METHOD__, var_export($e->getMessage(), true));
            }
        }

        if ($key === 'EMAIL') {
            $SQL_FIND_DUPLICATE = "SELECT 
                group_concat(`vCard_Explanatory_Properties_idvCard_Explanatory_Properties`) 
                as `result_group`,`EMAIL`,group_concat(`EmailType`) as `EmailType`   
                FROM " . self::$vCard_Telecommunications_Addressing_Properties_Email .
                    " WHERE `vCard_Explanatory_Properties_idvCard_Explanatory_Properties`
                IN (" . $id_list . ") and length(EMAIL) > 5 GROUP BY `EMAIL`;";
            try {
                $sth = $this->dbh->query($SQL_FIND_DUPLICATE);
                $re_array = $sth->fetchAll(PDO::FETCH_ASSOC);
//                echo var_export($re_array, TRUE);
                foreach ($re_array as $k => $v) {
                    $t = explode(',', $v['result_group']);
                    if (count($t) < 2) {
                        unset($re_array[$k]);
                        continue;
                    }
                    $et = explode(',', $v['EmailType']);

                    unset($re_array[$k]);

                    $re_array[$v['EMAIL']] = $t;
                    $re_array[$v['EMAIL']]['EmailType'] = array_unique($et);
                }

                return $re_array;
                /**
                  $r = array();
                  foreach ($re_array as $k => $v) {
                  array_push($r, $v['result_group']);
                  }
                  return $r;
                 * 
                 */
            } catch (PDOException $e) {
                debugLog(__FILE__, __CLASS__, __METHOD__, var_export($e->getMessage(), true));
            }
        } elseif ($key === 'TEL') {
            $SQL_FIND_DUPLICATE = "SELECT 
                group_concat(`vCard_Explanatory_Properties_idvCard_Explanatory_Properties`)
                as `result_group`, TEL , group_concat(`TelType`) as `TelType` 
                FROM " . self::$vCard_Telecommunications_Addressing_Properties_Tel
                    . " WHERE `vCard_Explanatory_Properties_idvCard_Explanatory_Properties`
                IN (" . $id_list . ") and length(TEL) > 10 GROUP BY `TEL`";
            try {
                $sth = $this->dbh->query($SQL_FIND_DUPLICATE);
                $re_array = $sth->fetchAll(PDO::FETCH_ASSOC);
//                var_export($re_array);
                foreach ($re_array as $k => $v) {
                    $t = explode(',', $v['result_group']);
//                    if(count($t)<2){
//                        unset($re_array[$k]);
//                        continue;
//                    }
                    $tt = explode(',', $v['TelType']);

                    $re_array[$v['TEL']] = $t;
                    $re_array[$v['TEL']]['TelType'] = array_unique($tt);
                    unset($re_array[$k]);
                }
//                echo var_export($re_array, true);
                return $re_array;
            } catch (PDOException $e) {
                debugLog(__FILE__, __CLASS__, __METHOD__, var_export($e->getMessage(), true));
            }
        }
    }

}

?>
