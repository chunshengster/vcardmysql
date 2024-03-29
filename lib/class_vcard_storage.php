<?php

/**
 * @author chunsheng
 * use mysql for vCard backend
 * @date
 * @ver
 * @todo 存储层需要增加逻辑：入库时检查vcard标准中同一分类的条目是否已经存在，如果存在则增加逻辑
 */
class class_vcard_storage {

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
    private static $vCard_Extension_Properties = 'vCard_Extension_Properties';
    function __construct() {
        self::$vcard_db_para_file = dirname(__FILE__) . '/../config/config.ini';
        self::getMysqlPara ();
//        $this->getInstance ();
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
            $this->dbh->setAttribute( PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
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

    private function _gen_uuid() {

        $sql = "Select uuid() as uuid";
        $this->_gen_mysql_resource();
        try {
            $sth = $this->dbh->query($sql);
            $re = $sth->fetchColumn();

        }catch (PDOException $e) {
            debugLog(__FILE__,__METHOD__,__LINE__,var_export($e->getMessage(),true));
        }
//        debugLog(__FILE__,__METHOD__,__LINE__,var_export($re,true));

        return $re;
    }


    /**
     * @param: array('idvCard_Explanatory_Properties') or array('UID')
     *
     */

    public function get_vCard_Explanatory_Properties($key) {
        //        $sql = '';
        debugLog(__FILE__, __METHOD__, __LINE__, var_export($key, true));
        if (key($key) !== 'idvCard_Explanatory_Properties' and key($key) !== 'UID') {
            return NULL;
        }
        $re = $this->_get_vcard_data_from_db('vCard_Explanatory_Properties', $key);
//        debugLog(__FILE__, __METHOD__, __LINE__, var_export($re, true));
        if (count($re) > 1 or $re === FALSE) {
            /**
             * @todo 系统中应该只存在一份 Explanatory properties，如果有多份，需要…………
             */
            debugLog(__FILE__,__CLASS__,__METHOD__,__LINE__,var_export($re,true));
            return false;
        }
        
        if(count($re) == 0){
            return array(
            );
        }

        return array(
                'UID' => $re[0]['UID'],
                'VERSION' => $re[0]['VERSION'],
                'REV' => $re[0]['REV'],
                'LANG' => $re[0]['LANG'],
                'CATEGORIES' => $re[0]['CATEGORIES'],
                'PRODID' => $re[0]['PRODID'],
                'SORT-STRING' => $re[0]['SORT-STRING'],
                'RESOURCE_ID' => $re[0]['idvCard_Explanatory_Properties']
        );
    }

    /**
     * @param array('vCard_Explanatory_Properties_idvCard_Explanatory_Properties')
     *      or array('idvCard_Identification_Properties')
     */

    public function get_vCard_Identification_Properties($key) {
//        debugLog(__FILE__, __METHOD__, __LINE__, var_export($key, true));
        if (key($key) !== 'vCard_Explanatory_Properties_idvCard_Explanatory_Properties' and key($key) !== 'idvCard_Identification_Properties') {
            return NULL;
        }

        $re = $this->_get_vcard_data_from_db('vCard_Identification_Properties', $key);
        debugLog(__FILE__, __METHOD__, __LINE__, var_export($re, true));
        if (count($re) > 1 or $re === false) {
            /**
             * @todo 系统中应该只存在一份 identification properties，如果有多份，需要…………
             */
            debugLog(__FILE__, __METHOD__, __LINE__, var_export($re, true));
        }
        if(count($re) == 0){
            return array(
            );
        }
        return array(
                'N' => stripcslashes($re[0]['N']),
                'FN' => stripcslashes($re[0]['FN']),
                'PHOTO' => $re[0]['PHOTO'],
                'PhotoType' => $re[0]['PhotoType'],
                'BDAY' => $re[0]['BDAY'],
                'URL' => $re[0]['URL'],
                'SOUND' => $re[0]['SOUND'],
                'NOTE' => stripslashes($re[0]['NOTE']),
                'NICKNAME' => stripcslashes($re[0]['NICKNAME']),
                'RESOURCE_ID' => $re[0]['idvCard_Identification_Properties']
        );
    }

    public function get_vCard_Geographical_Properties($key) {
//        debugLog(__FILE__, __METHOD__, __LINE__, var_export($key, true));
        if (key($key) !== 'vCard_Explanatory_Properties_idvCard_Explanatory_Properties' and key($key) !== 'idvCard_Geographical_Properties') {
            return NULL;
        }
        $re = $this->_get_vcard_data_from_db('vCard_Geographical_Properties', $key);

        if (count($re) > 1 or $re === false) {
            /**
             * @todo 系统中应该只存在一份 Geographical properties，如果有多份，需要…………
             */
            return false;
        }

//        debugLog(__FILE__, __METHOD__, __LINE__, var_export($re, true));
        if(count($re) == 0){
            return array(
            );
        }
        
        return array(
                'TZ' => $re[0]['TZ'],
                'GEO' => $re[0]['GEO'],
                'RESOURCE_ID' => $re[0]['idvCard_Geographical_Properties']
        );

//        return $this->_get_vcard_data_from_db('vCard_Geographical_Properties', $key);
    }

    public function get_vCard_Organizational_Properties($key) {
//        debugLog(__FILE__, __METHOD__, __LINE__, var_export($key, true));
        if (key($key) !== 'vCard_Explanatory_Properties_idvCard_Explanatory_Properties' and key($key) !== 'idvCard_Organizational_Properties') {
            return NULL;
        }
        $re = $this->_get_vcard_data_from_db('vCard_Organizational_Properties', $key);
        if (count($re) > 1 or $re == false) {
            /**
             * @todo 系统中应该只存在一份 Organizational properties，如果有多份，需要…………
             */
            return FALSE;
        }
//        debugLog(__FILE__, __METHOD__, __LINE__, var_export($re, true));

        if(count($re) == 0){
            return array(
            );
        }

        /**
         *  'idvCard_Organizational_Properties' => '172',
            'vCard_Explanatory_Properties_idvCard_Explanatory_Properties' => '166',
            'TITLE' => '',
            'ROLE' => '',
            'LOGO' => '',
            'LogoType' => NULL,
            'AGENT' => NULL,
            'ORG' => '息通网络',
         */
        if( mb_strlen($re[0]['TITLE'],'utf-8') > 0 and mb_strlen($re[0]['ROLE'],'utf-8') < 1){
            $re[0]['ROLE'] = $re[0]['TITLE'];
        }
        if( mb_strlen($re[0]['ROLE'],'utf-8') > 0 and mb_strlen($re[0]['TITLE'],'utf-8') < 1){
            $re[0]['TITLE'] = $re[0]['ROLE'];
        }
        
        return array(
                'TITLE' => stripcslashes($re[0]['TITLE']),
                'ROLE' => stripcslashes($re[0]['ROLE']),
                'LOGO' => $re[0]['LOGO'],
                'LogoType' => $re[0]['LogoType'],
                'AGENT' => $re[0]['AGENT'],
                'ORG' => stripcslashes($re[0]['ORG']),
                'RESOURCE_ID' => $re[0]['idvCard_Organizational_Properties']
        );
    }

    public function get_vCard_Delivery_Addressing_Properties_ADR($key) {
//        debugLog(__FILE__, __METHOD__, __LINE__, var_export($key, true));
        if (key($key) !== 'vCard_Explanatory_Properties_idvCard_Explanatory_Properties' and key($key) !== 'idvCard_Delivery_Addressing_Properties_ADR') {
            return NULL;
        }
        $re = $this->_get_vcard_data_from_db('vCard_Delivery_Addressing_Properties_ADR', $key);
//        debugLog(__FILE__, __METHOD__, __LINE__, var_export($re, true));

        if($re === false){
            return FALSE;
        }

        if(count($re) == 0){
            return array(
            );
        }

        $re_array = array();
        foreach ($re as $k => $val) {
            $re_array[$k]['ADR'] = stripcslashes($val['ADR']);
            $re_array[$k]['AdrType'] = $val['AdrType'];
            $re_array[$k]['RESOURCE_ID'] = $val['idvCard_Delivery_Addressing_Properties_ADR'];
        }
//        debugLog(__FILE__, __METHOD__, __LINE__, var_export($re_array, true));
        return $re_array;
    }

    public function get_vCard_Delivery_Addressing_Properties_LABEL($key) {
//        debugLog(__FILE__, __METHOD__, __LINE__, var_export($key, true));
        if (key($key) !== 'vCard_Explanatory_Properties_idvCard_Explanatory_Properties' and key($key) !== 'idvCard_Delivery_Addressing_Properties_LABEL') {
            return NULL;
        }
        $re = $this->_get_vcard_data_from_db('vCard_Delivery_Addressing_Properties_LABEL', $key);
//        debugLog(__FILE__, __METHOD__, __LINE__, var_export($re, true));
        
        if($re === FALSE){
            return FALSE;
        }

        if(count($re) == 0){
            return array(
            );
        }
        $re_array = array();
        foreach ($re as $k => $val) {
            $re_array[$k]['LABEL'] = stripcslashes($val['LABEL']);
            $re_array[$k]['LabelType'] = $val['LabelType'];
            $re_array[$k]['RESOURCE_ID'] = $val['idvCard_Delivery_Addressing_Properties_LABEL'];
        }
//        debugLog(__FILE__, __METHOD__, __LINE__, var_export($re_array, true));
        return $re_array;
    }

    public function get_vCard_Telecommunications_Addressing_Properties_Tel($key) {
//        debugLog(__FILE__, __METHOD__, __LINE__, var_export($key, true));
        if (key($key) !== 'vCard_Explanatory_Properties_idvCard_Explanatory_Properties' and key($key) !== 'idvCard_Telecommunications_Addressing_Properties_Tel') {
            return NULL;
        }
        $re = $this->_get_vcard_data_from_db('vCard_Telecommunications_Addressing_Properties_Tel', $key);
//        debugLog(__FILE__, __METHOD__, __LINE__, var_export($re, true));

        if($re === FALSE){
            return FALSE;
        }

        if(count($re) === 0){
            return array(
            );
        }
        $re_array = array();
        foreach ($re as $k => $val) {
            $re_array[$k]['TEL'] = $val['TEL'];
            $re_array[$k]['TelType'] = $val['TelType'];
            $re_array[$k]['RESOURCE_ID'] = $val['idvCard_Telecommunications_Addressing_Properties_Tel'];
        }
//        debugLog(__FILE__, __METHOD__, __LINE__, var_export($re_array, true));
        return $re_array;
    }

    public function get_vCard_Telecommunications_Addressing_Properties_Email($key) {
//        debugLog(__FILE__, __METHOD__, __LINE__, var_export($key, true));
        if (key($key) !== 'vCard_Explanatory_Properties_idvCard_Explanatory_Properties' and key($key) !== 'idvCard_Telecommunications_Addressing_Properties_Email') {
            return NULL;
        }
        $re = $this->_get_vcard_data_from_db('vCard_Telecommunications_Addressing_Properties_Email', $key);
//        debugLog(__FILE__, __METHOD__, __LINE__, var_export($re, true));
        
        if($re === FALSE){
            return FALSE;
        }

        if(count($re) === 0){
            return array(
            );
        }
        $re_array = array();
        foreach ($re as $k => $val) {
            $re_array[$k]['EMAIL'] = $val['EMAIL'];
            $re_array[$k]['EmailType'] = $val['EmailType'];
            $re_array[$k]['RESOURCE_ID'] = $val['idvCard_Telecommunications_Addressing_Properties_Email'];
        }
//        debugLog(__FILE__, __METHOD__, __LINE__, var_export($re_array, true));
        return $re_array;
    }

    public function get_vCard_Extension_Properties($key) {
//        debugLog(__FILE__,__METHOD__,__LINE__,  var_export($key, true));
        if (key($key) !== 'vCard_Explanatory_Properties_idvCard_Explanatory_Properties' and key($key) !== 'idvCard_Extension_Properties') {
            return NULL;
        }
        $re = $this->_get_vcard_data_from_db('vCard_Extension_Properties', $key);
//        debugLog(__FILE__, __METHOD__, __LINE__, var_export($re, true));

        if($re === FALSE){
            return FALSE;
        }

        if(count($re) === 0){
            return array(
            );
        }
        $re_array = array();
        /**
         * @todo 同一种类型的 extension 只能出现一次，对此，需要增加冲突解决机制
         */
        foreach ($re as $k => $val) {
            $re_array[$val['ExtensionName']]['Value'] = stripcslashes($val['ExtensionValue']);
            $re_array[$val['ExtensionName']]['RESOURCE_ID'] = $val['idvCard_Extension_Properties'];
        }
//        debugLog(__FILE__, __METHOD__, __LINE__, var_export($re_array, true));
        return $re_array;

    }

    private function _get_vcard_data_from_db($table, $key) {
        $this->_gen_mysql_resource();
        $sql = "Select * From " . $table . " Where " . key($key) . " = :KEY";
        try {
            $sth = $this->dbh->prepare($sql);
            $sth->bindParam(':KEY', $key[key($key)]);
//            debugLog(__FILE__, __METHOD__, __LINE__, var_export($sth, true), var_export($key, true));
            $sth->execute();
        } catch (PDOException $e) {
//            debugLog(__FILE__, __METHOD__, __LINE__, $e->getMessage());
            return FALSE;
        }
        $re = $sth->fetchAll(PDO::FETCH_ASSOC);
//        debugLog(__FILE__, __METHOD__, __LINE__, var_export($re, true));
        return $re;
    }

    public function get_vcard_id_by_uid($uid) {
        if ($uid == '' or !isset($uid)) {
            return false;
        }
        if (mb_strlen($uid,'utf8') == 36) {
            /**
             * todo: 调整检查$uid的算法
             */
            $this->_gen_mysql_resource();
            $select_sql = "SELECT idvCard_Explanatory_Properties FROM " . self::$vCard_Explanatory_Properties . " WHERE UID = :UID";

            try {
                $sth = $this->dbh->prepare($select_sql);
            } catch (PDOException $e) {
//                echo $exc->getTraceAsString();
                debugLog(__FILE__, __METHOD__, __LINE__, $e->getMessage());
            }
            $sth->bindParam(':UID', $uid);
            try {
                $sth->execute();
            } catch (PDOException $e) {
//                echo $exc->getTraceAsString();
                debugLog(__FILE__, __METHOD__, __LINE__, $e->getMessage());
                return FALSE;
            }
            return $sth->fetchColumn();
        }
        return false;
    }


    /**
     *
     * @param <string> $vcard_comp
     * @param <mixed> $vcard_data_array
     * @param <bool> $gen_uid
     * @return <mixed> return data or false
     */
    public function store_data($vcard_comp, $vcard_data_array, $gen_uid=false) {

        debugLog(__FILE__, __METHOD__, __LINE__, var_export($vcard_comp, true), var_export($vcard_data_array, true));
        if (!isset($vcard_comp) or $vcard_comp == '') {
            return false;
        }

        if(count($vcard_data_array) < 2 and isset ($vcard_data_array['V_ID'])){
            return FALSE;
        }

        $vcard_exist = false;
        $new_record = false;
        $this->_gen_mysql_resource();
        debugLog(__FILE__, __METHOD__, __LINE__, var_export($this->dbh, true));
        if ($gen_uid == true) {
            $vcard_data_array['UID'] = $this->_gen_uuid();
        } else {
            if (isset($vcard_data_array['UID'])) {
                if ($vcard_data_array['UID'] !== '') {
                    $vcard_exist = $this->check_vcard_exist_via_uid($vcard_data_array['UID']);
                }else {
                    $vcard_data_array['UID'] = $this->_gen_uuid();
                }
            } elseif (isset($vcard_data_array['V_ID']) && $vcard_data_array['V_ID'] != '') {
                /**
                 * @todo 需要增加 对 V_ID 的检查，检查其是否存在与数据库中，并且该vcard 可用
                 *  V_ID 为 vcard db中的 vCard_Explanatory_Properties_idvCard_Explanatory_Properties 字段
                 */
                $vcard_exist = true;
            } else {
                return false;
            }
        }

        switch ($vcard_comp) {
            case self::$vCard_Explanatory_Properties:
                if (!$vcard_exist) {
                    //Importent: 'SORTSTRING',for PDO does not work with 'SORT-STRING'
                    $store_sql = "INSERT INTO " . self::$vCard_Explanatory_Properties . " (`UID`,`VERSION`,`REV`,`LANG`,`CATEGORIES`,`PRODID`,`SORT-STRING`) VALUES (:UID,:VERSION,:REV,:LANG,:CATEGORIES,:PRODID,:SORTSTRING)";
                } else {
                    if(isset ($vcard_data_array['FLAG'])){
                        if($vcard_data_array['FLAG']=='CHANGED') {
                            $store_sql = "UPDATE " . self::$vCard_Explanatory_Properties . " SET `VERSION` = :VERSION,`REV` = :REV,`LANG` = :LANG,`CATEGORIES` = :CATEGORIES,`PRODID` = :PRODID,`SORT-STRING` = :SORTSTRING  WHERE UID = :UID";
                            debugLog(__FILE__,__METHOD__,__LINE__,var_export($store_sql,true));
                        }
                        else {
                            /**
                             * vCard_Explanatory_Properties 属性中 $vcard_data_array['FLAG'] 不能是 "NEW" 或 "DELETED"
                             */
                            return false;
                        }
                    }else{
                        return ;
                    }
                }
                try {
                    $sth = $this->dbh->prepare($store_sql);

                    if(!isset($vcard_data_array['REV']) or mb_strlen($vcard_data_array['REV'],'utf8')<=0) {
                        $vcard_data_array['REV'] = date("Y-m-d H:i:s");
                    }

                    if(!isset($vcard_data_array['VERSION'])) {
                        $vcard_data_array['VERSION'] = '3.0';
                    }
                    $sth->bindParam(':UID', $vcard_data_array['UID']);
                    $sth->bindParam(':VERSION', $vcard_data_array['VERSION']);
                    $sth->bindParam(':REV', $vcard_data_array['REV']);
                    $sth->bindParam(':LANG', $vcard_data_array['LANG']);
                    $sth->bindParam(':CATEGORIES', $vcard_data_array['CATEGORIES']);
                    $sth->bindParam(':PRODID', $vcard_data_array['PRODID']);
                    $sth->bindParam(':SORTSTRING', $vcard_data_array['SORT-STRING']);
                    // SORTSTRING,for pdo does not work with 'SORT-STRING'
                    $sth->execute();
                } catch (PDOException $e) {
//                    print_r($e->getMessage());
                    debugLog(__FILE__, __METHOD__, __LINE__, $e->getMessage());
                }
                if (!$vcard_exist) {
                    $id = $this->dbh->lastInsertId();
                } else {
                    $id = $vcard_exist;
                }
//                echo "\n >>>>" . __FILE__ . __METHOD__ . __LINE__ . var_export(array('UID' => $vcard_data_array['UID'], 'RESOURCE_ID' => isset($id) ? $id : null), true) . "\n";
                debugLog(__FILE__, __METHOD__, __LINE__, var_export(array('UID' => $vcard_data_array['UID'], 'RESOURCE_ID' => isset($id) ? $id : null), true));
                return array('UID' => $vcard_data_array['UID'], 'RESOURCE_ID' => isset($id) ? $id : null);
                break;

            case self::$vCard_Identification_Properties:
            /**
             ＊if($vcard_exist && isset($vcard_data_array['RESOURCE_ID'])) {
             * @todo 此处暂时去掉对 $vcard_exist 的检查
             */
                if (isset($vcard_data_array['RESOURCE_ID'])) {
                    $new_record = false;
                    if(isset($vcard_data_array['FLAG'])) {
                        if($vcard_data_array['FLAG'] == 'CHANGED') {
                            $store_sql = "UPDATE " . self::$vCard_Identification_Properties . " SET `N` = :N,`FN` = :FN,`NICKNAME` = :NICKNAME,`PHOTO` = :PHOTO,`PhotoType` = :PhotoType,`BDAY` = :BDAY,`URL` = :URL,`SOUND` = :SOUND,`NOTE` = :NOTE where `idvCard_Identification_Properties` = :RESOURCEID ";
                        }elseif($vcard_data_array['FLAG'] == 'DELETED') {
                            $store_sql = 'DELETE FROM '.self::$vCard_Identification_Properties . ' WHERE  `idvCard_Identification_Properties` = :RESOURCEID';
                        }
                    }else{
                        return ;
                    }

                } elseif ((!isset($vcard_data_array['RESOURCE_ID']) && isset($vcard_data_array['V_ID']))) {
                    /**
                     * (($vcard_exist) && (!isset($vcard_data_array['RESOURCE_ID']) && isset($vcard_data_array['V_ID']))) {
                     * @todo 此处暂时去掉对 $vcard_exist的检查
                     */
                    $new_record = true;
                    $vcard_data_array['RESOURCE_ID'] = $vcard_data_array['V_ID'];
                    $store_sql = "INSERT INTO " . self::$vCard_Identification_Properties . " (`vCard_Explanatory_Properties_idvCard_Explanatory_Properties`,`N`,`FN`,`NICKNAME`,`PHOTO`,`PhotoType`,`BDAY`,`URL`,`SOUND`,`NOTE`) VALUES (:RESOURCEID,:N,:FN,:NICKNAME,:PHOTO,:PhotoType,:BDAY,:URL,:SOUND,:NOTE) ";
                } else {
//                    echo '>>>>>>>> return false  ' . __FILE__ . __METHOD__ . __LINE__ . "\n";
                    debugLog(__FILE__, __METHOD__, __LINE__, 'return false');
                    return false;
                }
                debugLog(__FILE__, __METHOD__, __LINE__, '$store_sql', $store_sql);
                try {
                    $sth = $this->dbh->prepare($store_sql);
                    debugLog(__FILE__, __METHOD__, __LINE__, var_export($vcard_data_array,true));
                    if(preg_match("/^DELETE/", $store_sql)) {
                        $sth->bindParam(':RESOURCEID', $vcard_data_array['RESOURCE_ID']);
                    }else {
                        $sth->bindParam(':RESOURCEID', $vcard_data_array['RESOURCE_ID']);
                        $sth->bindParam(':N', $vcard_data_array['N']);
                        $sth->bindParam(':FN', $vcard_data_array['FN']);
                        $sth->bindParam(':NICKNAME', $vcard_data_array['NICKNAME']);
                        $sth->bindParam(':PHOTO', $vcard_data_array['PHOTO']);
                        $sth->bindParam(':PhotoType', $vcard_data_array['PhotoType']);
                        $sth->bindParam(':BDAY', $vcard_data_array['BDAY']);
                        $sth->bindParam(':URL', $vcard_data_array['URL']);
                        $sth->bindParam(':SOUND', $vcard_data_array['SOUND']);
                        $sth->bindParam(':NOTE', $vcard_data_array['NOTE']);
                        $sth->execute();
                    }
                }catch (PDOException $e) {
//                    print_r($e->getMessage());
                    debugLog(__FILE__, __METHOD__, __LINE__, $e->getMessage());
                }
                if ($new_record) {
                    $vcard_data_array['RESOURCE_ID'] = $this->dbh->lastInsertId();
                }
                return array('RESOURCE_ID' => $vcard_data_array['RESOURCE_ID']);
                break;

            case self::$vCard_Geographical_Properties:
                if ((!isset($vcard_data_array['RESOURCE_ID']) && isset($vcard_data_array['V_ID']))) {
                    /**
                     * :RESOURCE_ID change to :RESOURCEID
                     */
                    $vcard_data_array['RESOURCE_ID'] = $vcard_data_array['V_ID'];
                    $new_record = true;
                    $store_sql = "INSERT INTO " . self::$vCard_Geographical_Properties . " (`vCard_Explanatory_Properties_idvCard_Explanatory_Properties`,`TZ`,`GEO`) VALUES (:RESOURCEID,:TZ,:GEO)";
                } elseif (isset($vcard_data_array['RESOURCE_ID'])) {
                    $new_record = false;
                    if(isset($vcard_data_array['FLAG']) && $vcard_data_array['FLAG'] == 'CHANGED') {
                        $store_sql = "UPDATE " . self::$vCard_Geographical_Properties . " SET TZ = :TZ , GEO = :GEO where idvCard_Geographical_Properties = :RESOURCEID";
                    }elseif(isset($vcard_data_array['FLAG']) && $vcard_data_array['FLAG']=='DELETED') {
                        $store_sql = 'DELETE FROM '.self::$vCard_Geographical_Properties. ' WHERE idvCard_Geographical_Properties = :RESOURCEID';
                    }else {
                        return false;
                    }
                } else {
                    return false;
                }
//                echo '>>>>> $store_sql : ' . __LINE__ . ' :' . $store_sql . "\n";
                debugLog(__FILE__, __METHOD__, __LINE__, $store_sql);

                $sth = $this->dbh->prepare($store_sql);
                if(preg_match("/^DELETE/", $store_sql)) {
                    $sth->bindParam(':RESOURCEID', $vcard_data_array['RESOURCE_ID']);
                }else {
                    $sth->bindParam(':RESOURCEID', $vcard_data_array['RESOURCE_ID']);
                    $sth->bindParam(':TZ', $vcard_data_array['TZ']);
                    $sth->bindParam(':GEO', $vcard_data_array['GEO']);
                }

                try {
                    $sth->execute();
                } catch (PDOException $e) {
//                    print_r($e->getMessage());
                    debugLog(__FILE__, __METHOD__, __LINE__, $e->getMessage());
                }
                if ($new_record) {
                    $vcard_data_array['RESOURCE_ID'] = $this->dbh->lastInsertId();
                }
                return array('RESOURCE_ID' => $vcard_data_array['RESOURCE_ID']);
                break;

            case self::$vCard_Organizational_Properties:
                if ((!isset($vcard_data_array['RESOURCE_ID']) && isset($vcard_data_array['V_ID']))) {
                    $vcard_data_array['RESOURCE_ID'] = $vcard_data_array['V_ID'];
                    $new_record = true;
                    $store_sql = "INSERT INTO " . self::$vCard_Organizational_Properties . " (`vCard_Explanatory_Properties_idvCard_Explanatory_Properties` ,`TITLE` ,`ROLE` ,`LOGO` ,`LogoType` ,`ORG`) VALUES (:RESOURCEID,:TITLE,:ROLE,:LOGO,:LogoType,:ORG)";
                } else {
                    $new_record = false;
                    if(isset($vcard_data_array['FLAG']) && $vcard_data_array['FLAG'] == 'CHANGED') {
                        $store_sql = "UPDATE " . self::$vCard_Organizational_Properties . " SET `TITLE` = :TITLE ,`ROLE` = :ROLE ,`LOGO` = :LOGO ,`LogoType` = :LogoType ,`ORG` = :ORG WHERE idvCard_Organizational_Properties = :RESOURCEID";
                    }elseif(isset ($vcard_data_array['FLAG']) && $vcard_data_array['FLAG'] == 'DELETED') {
                        $store_sql = 'DELETE FROM '. self::$vCard_Organizational_Properties . ' WHERE idvCard_Organizational_Properties = :RESOURCEID';
                    }else{
                        return;
                    }
                }
                debugLog(__FILE__, __METHOD__, __LINE__, $store_sql);
                try {
                    $sth = $this->dbh->prepare($store_sql);
                    if(preg_match("/^DELETE/", $store_sql)) {
                        $sth->bindParam(':RESOURCEID', $vcard_data_array['RESOURCE_ID']);
                    }else {
                        $sth->bindParam(':TITLE', $vcard_data_array['TITLE']);
                        $sth->bindParam(':ROLE', $vcard_data_array['ROLE']);
                        $sth->bindParam(':LOGO', $vcard_data_array['LOGO']);
                        $sth->bindParam(':LogoType', $vcard_data_array['LogoType']);
                        $sth->bindParam(':ORG', $vcard_data_array['ORG']);
                        $sth->bindParam(':RESOURCEID', $vcard_data_array['RESOURCE_ID']);
                        debugLog(__FILE__,__CLASS__,__METHOD__,__LINE__,  var_export($sth,true));
                    }
                    $sth->execute();
                } catch (PDOException $e) {
//                    print_r($e->getMessage());
                    debugLog(__FILE__, __METHOD__, __LINE__, $e->getMessage());
                }
                if ($new_record) {
                    $vcard_data_array['RESOURCE_ID'] = $this->dbh->lastInsertId();
                }
                return array('RESOURCE_ID' => $vcard_data_array['RESOURCE_ID']);
                break;

            case self::$vCard_Delivery_Addressing_Properties_ADR:
                $re = array();
                /**
                 * @todo V_ID 数据需要校验
                 */
                if (isset($vcard_data_array['V_ID'])) {
                    $v_id = $vcard_data_array['V_ID'];
                    unset($vcard_data_array['V_ID']);
                    foreach ($vcard_data_array as $k => $t_vcard_data) {
                        if (!isset($t_vcard_data['RESOURCE_ID'])) {
                            $new_record = true;
                            $t_vcard_data['RESOURCE_ID'] = $v_id;
                            $store_sql = "INSERT INTO " . self::$vCard_Delivery_Addressing_Properties_ADR . " (`vCard_Explanatory_Properties_idvCard_Explanatory_Properties`,`ADR`,`AdrType`) VALUES (:RESOURCEID,:ADR,:AdrType)";
                        } else {
                            $new_record = false;
                            if(isset($t_vcard_data['FLAG']) && $t_vcard_data['FLAG']=='CHANGED') {
                                $store_sql = "UPDATE " . self::$vCard_Delivery_Addressing_Properties_ADR . " SET ADR=:ADR, AdrType=:AdrType WHERE idvCard_Delivery_Addressing_Properties_ADR=:RESOURCEID";
                            }elseif(isset ($t_vcard_data['FLAG']) && $t_vcard_data['FLAG'] == 'DELETED') {
                                $store_sql = 'DELETE FROM '.self::$vCard_Delivery_Addressing_Properties_ADR.' WHERE idvCard_Delivery_Addressing_Properties_ADR=:RESOURCEID';
                            }else {
                                return false;
                            }
                        }

                        try {
                            $sth = $this->dbh->prepare($store_sql);
                            $sth->bindParam(':RESOURCEID', $t_vcard_data['RESOURCE_ID']);
                            if(!preg_match("/^DELETE/", $store_sql)) {
                                $sth->bindParam(':ADR', $t_vcard_data['ADR']);
                                $sth->bindParam(':AdrType', $t_vcard_data['AdrType']);
                            }
                            $sth->execute();
                        } catch (PDOException $e) {
//                            print_r($e->getMessage());
                            debugLog(__FILE__, __METHOD__, __LINE__, $e->getMessage());
                        }

                        if ($new_record) {
                            $re[$k]['RESOURCE_ID'] = $this->dbh->lastInsertId();
                        } else {
//                            echo '>>>>>>$t_vcard_data:' . var_export($t_vcard_data);
                            debugLog(__FILE__, __METHOD__, __LINE__, var_export($t_vcard_data,true));
                            $re[$k]['RESOURCE_ID'] = $t_vcard_data['RESOURCE_ID'];
                        }
                    }
                    debugLog(__FILE__, __METHOD__, __LINE__, var_export($re, TRUE));
                    return $re;
                } else {
                    return false;
                }
                break;

            case self::$vCard_Delivery_Addressing_Properties_LABEL:
                $re = array();
                /**
                 * @todo V_ID 数据需要校验
                 */
                if (isset($vcard_data_array['V_ID'])) {
                    $v_id = $vcard_data_array['V_ID'];
                    unset($vcard_data_array['V_ID']);
                    foreach ($vcard_data_array as $k => $t_vcard_data) {
                        if (!isset($t_vcard_data['RESOURCE_ID'])) {
                            $new_record = true;
                            $t_vcard_data['RESOURCE_ID'] = $v_id;
                            $store_sql = "INSERT INTO " . self::$vCard_Delivery_Addressing_Properties_LABEL . " (`vCard_Explanatory_Properties_idvCard_Explanatory_Properties`,`LABEL`,`LabelType`) VALUES (:RESOURCEID,:LABEL,:LabelType)";
                        } else {
                            $new_record = false;
                            if(isset($t_vcard_data['FLAG']) && $t_vcard_data['FLAG'] == 'CHANGED'){
                                $store_sql = "UPDATE " . self::$vCard_Delivery_Addressing_Properties_LABEL . " SET LABEL=:LABEL ,LabelType=:LabelType WHERE idvCard_Delivery_Addressing_Properties_LABEL=:RESOURCEID";
                            }elseif(isset ($t_vcard_data['FLAG']) && $t_vcard_data['FLAG'] == 'DELETED'){
                                $store_sql = 'DELETE FROM '. self::$vCard_Delivery_Addressing_Properties_LABEL. ' WHERE idvCard_Delivery_Addressing_Properties_LABEL=:RESOURCEID';
                            }else{
                                return false;
                            }

                        }
                        debugLog(__FILE__, __METHOD__, __LINE__, var_export($store_sql, true));
                        try {
                            $sth = $this->dbh->prepare($store_sql);
                            $sth->bindParam(':RESOURCEID', $t_vcard_data['RESOURCE_ID']);
                            if(!preg_match("/^DELETE/", $store_sql)){
                                $sth->bindParam(':LABEL', $t_vcard_data['LABEL']);
                                $sth->bindParam(':LabelType', $t_vcard_data['LabelType']);
                            }
                            $sth->execute();
                        } catch (PDOException $e) {
                            debugLog(__FILE__, __METHOD__, __LINE__, var_export($e->getMessage(),true));
                        }
                        if ($new_record) {
                            $re[$k]['RESOURCE_ID'] = $this->dbh->lastInsertId();
                        } else {
                            debugLog(__FILE__, __METHOD__, __LINE__, var_export($t_vcard_data, true));
                            $re[$k]['RESOURCE_ID'] = $t_vcard_data['RESOURCE_ID'];
                        }
                    }
                    debugLog(__FILE__, __METHOD__, __LINE__, var_export($re, true));
                    return $re;
                } else {
                    return false;
                }
                break;

            case self::$vCard_Telecommunications_Addressing_Properties_Tel:
            //$insert_sql = "INSERT INTO " . self::$vCard_Telecommunications_Addressing_Properties_Tel . " (`vCard_Explanatory_Properties_idvCard_Explanatory_Properties`, `TEL` ,`TelType`) VALUES (:RESOURCE_ID, :TEL, :TelType)";
                $re = array();
                /**
                 * @todo V_ID 数据需要校验
                 */
                if (isset($vcard_data_array['V_ID'])) {
                    $v_id = $vcard_data_array['V_ID'];
                    unset($vcard_data_array['V_ID']);
                    foreach ($vcard_data_array as $k => $t_vcard_data) {
                        if (!isset($t_vcard_data['RESOURCE_ID'])) {
                            $new_record = true;
                            $t_vcard_data['RESOURCE_ID'] = $v_id;
                            $store_sql = "INSERT INTO " . self::$vCard_Telecommunications_Addressing_Properties_Tel . " (`vCard_Explanatory_Properties_idvCard_Explanatory_Properties`, `TEL` ,`TelType`) VALUES (:RESOURCEID, :TEL, :TelType)";
                        } else {
                            $new_record = false;
                            if(isset($t_vcard_data['FLAG']) && $t_vcard_data['FLAG'] == 'CHANGED'){
                                $store_sql = "UPDATE " . self::$vCard_Telecommunications_Addressing_Properties_Tel . " SET TEL=:TEL ,TelType=:TelType WHERE idvCard_Telecommunications_Addressing_Properties_Tel=:RESOURCEID";
                            }elseif(isset($t_vcard_data['FLAG']) && $t_vcard_data['FLAG'] == 'DELETED'){
                                $store_sql = 'DELETE FROM '.self::$vCard_Telecommunications_Addressing_Properties_Tel.' WHERE idvCard_Telecommunications_Addressing_Properties_Tel=:RESOURCEID';
                            }else{
                                debugLog(__FILE__,__CLASS__,__METHOD__,__LINE__,var_export($store_sql,true));
                                return false;
                            }
                        }
                        debugLog(__FILE__,__CLASS__,__METHOD__,__LINE__,var_export($store_sql,true));
                        try {
                            $sth = $this->dbh->prepare($store_sql);
                            $sth->bindParam(':RESOURCEID', $t_vcard_data['RESOURCE_ID']);
                            if(!preg_match("/^DELETE/", $store_sql)){
                                $sth->bindParam(':TEL', $t_vcard_data['TEL']);
                                $sth->bindParam(':TelType', $t_vcard_data['TelType']);
                            }
                            $sth->execute();
                        } catch (PDOException $e) {
//                            print_r($e->getMessage());
                            debugLog(__FILE__, __METHOD__, __LINE__, $e->getMessage());
                        }
                        if ($new_record) {
                            $re[$k]['RESOURCE_ID'] = $this->dbh->lastInsertId();
                        } else {
//                            echo '>>>>>>$t_vcard_data:' . var_export($t_vcard_data);
                            debugLog(__FILE__, __METHOD__, __LINE__, var_export($t_vcard_data, true));
                            $re[$k]['RESOURCE_ID'] = $t_vcard_data['RESOURCE_ID'];
                        }
                    }
                    debugLog(__FILE__, __METHOD__, __LINE__, var_export($re, true));
                    return $re;
                } else {
                    return false;
                }
                break;

            case self::$vCard_Telecommunications_Addressing_Properties_Email:
            //$insert_sql = "INSERT INTO " . self::$vCard_Telecommunications_Addressing_Properties_Email . " (`vCard_Explanatory_Properties_idvCard_Explanatory_Properties`, `EMAIL`, `EmailType`) VALUES (:RESOURCE_ID, :EMAIL, :EmailType)";
                $re = array();
                /**
                 * @todo V_ID 数据需要校验
                 */
                if (isset($vcard_data_array['V_ID'])) {
                    $v_id = $vcard_data_array['V_ID'];
                    unset($vcard_data_array['V_ID']);
                    foreach ($vcard_data_array as $k => $t_vcard_data) {
                        if (!isset($t_vcard_data['RESOURCE_ID'])) {
                            $new_record = true;
                            $t_vcard_data['RESOURCE_ID'] = $v_id;
                            $store_sql = "INSERT INTO " . self::$vCard_Telecommunications_Addressing_Properties_Email . " (`vCard_Explanatory_Properties_idvCard_Explanatory_Properties`, `EMAIL`, `EmailType`) VALUES (:RESOURCEID, :EMAIL, :EmailType)";
                        } else {
                            $new_record = false;
                            if(isset($t_vcard_data['FLAG']) && $t_vcard_data['FLAG']=='CHANGED'){
                                $store_sql = "UPDATE " . self::$vCard_Telecommunications_Addressing_Properties_Email . " SET EMAIL=:EMAIL ,EmailType=:EmailType WHERE idvCard_Telecommunications_Addressing_Properties_Email=:RESOURCEID";
                            }elseif(isset($t_vcard_data['FLAG']) && $t_vcard_data['FLAG'] == 'DELETED'){
                                $store_sql = 'DELETE FROM '.self::$vCard_Telecommunications_Addressing_Properties_Email.' WHERE idvCard_Telecommunications_Addressing_Properties_Email=:RESOURCEID';
                            }else{
                                return false;
                            }
                        }
                        debugLog(__FILE__,__CLASS__,__METHOD__,__LINE__,var_export($store_sql,true));
                        try {
                            $sth = $this->dbh->prepare($store_sql);
                            $sth->bindParam(':RESOURCEID', $t_vcard_data['RESOURCE_ID']);
                            if(!preg_match("/^DELETE/", $store_sql)){
                                $sth->bindParam(':EMAIL', $t_vcard_data['EMAIL']);
                                $sth->bindParam(':EmailType', $t_vcard_data['EmailType']);
                            }
                            $sth->execute();
                        } catch (PDOException $e) {
                            debugLog(__FILE__, __METHOD__, __LINE__, $e->getMessage());
                        }
                        if ($new_record) {
                            $re[$k]['RESOURCE_ID'] = $this->dbh->lastInsertId();
                        } else {
                            debugLog(__FILE__, __METHOD__, __LINE__, var_export($t_vcard_data, true));
                            $re[$k]['RESOURCE_ID'] = $t_vcard_data['RESOURCE_ID'];
                        }
                    }
                    debugLog(__FILE__, __METHOD__, __LINE__, var_export($re, true));
                    return $re;
                } else {
                    return false;
                }
                break;
            case self::$vCard_Extension_Properties:
                $re = array();
                if (isset($vcard_data_array['V_ID'])) {
                    $v_id = $vcard_data_array['V_ID'];
                    unset($vcard_data_array['V_ID']);
                    foreach ($vcard_data_array as $k => $t_vcard_data) {
                        if (!isset($t_vcard_data['RESOURCE_ID'])) {
                            $new_record = true;
                            $t_vcard_data['RESOURCE_ID'] = $v_id;
                            $store_sql = "INSERT INTO " . self::$vCard_Extension_Properties . " (`vCard_Explanatory_Properties_idvCard_Explanatory_Properties`, `ExtensionName`, `ExtensionValue`) VALUES (:RESOURCEID, :ExtensionName, :ExtensionValue)";
                        } else {
                            $new_record = false;
                            if(isset($t_vcard_data['FLAG']) && $t_vcard_data['FLAG']=='CHANGED'){
                                $store_sql = "UPDATE " . self::$vCard_Extension_Properties . " SET ExtensionName=:ExtensionName ,ExtensionValue=:ExtensionValue WHERE idvCard_Extension_Properties=:RESOURCEID";
                            }elseif(isset($t_vcard_data['FLAG']) && $t_vcard_data['FLAG'] == 'DELETED'){
                                $store_sql = 'DELETE FROM '.self::$vCard_Extension_Properties .' WHERE idvCard_Extension_Properties =:RESOURCEID';
                            }else{
                                return false;
                            }
                        }
                        debugLog(__FILE__,__CLASS__,__METHOD__,__LINE__,var_export($store_sql,true));
                        try {
                            $sth = $this->dbh->prepare($store_sql);
                            $sth->bindParam(':RESOURCEID', $t_vcard_data['RESOURCE_ID']);
                            if(!preg_match("/^DELETE/", $store_sql)){
                                $sth->bindParam(':ExtensionName', $k);
                                $sth->bindParam(':ExtensionValue', $t_vcard_data['Value']);
                            }
                            $sth->execute();
                        } catch (PDOException $e) {
                            debugLog(__FILE__, __METHOD__, __LINE__, $e->getMessage());
                        }
                        if ($new_record) {
                            $re[$k]['RESOURCE_ID'] = $this->dbh->lastInsertId();
                        } else {
                            debugLog(__FILE__, __METHOD__, __LINE__, var_export($t_vcard_data, true));
                            $re[$k]['RESOURCE_ID'] = $t_vcard_data['RESOURCE_ID'];
                        }
                    }
                    debugLog(__FILE__, __METHOD__, __LINE__, var_export($re, true));
                    return $re;
                } else {
                    return false;
                }
                break;
                
            default:
                return false;
        }
    }

    public function check_vcard_exist_via_uid($uid = null) {
        if ($uid == null) {
            return false;
        }
//        echo implode(':', array(__FILE__, __METHOD__, __LINE__, 'uid:', $uid)) . "\n";
        debugLog(__FILE__, __METHOD__, __LINE__, 'uid', $uid);

        $this->_gen_mysql_resource();
        $FindUidSql = "SELECT `idvCard_Explanatory_Properties` FROM " . self::$vCard_Explanatory_Properties . " WHERE UID = :UID";
//        echo ">>>>>" . $FindUidSql . "\n";
        try {
            $sth = $this->dbh->prepare($FindUidSql);
        } catch (PDOException $e) {
            debugLog(__FILE__, __METHOD__, __LINE__, $e->getMessage());
        }
        $sth->bindParam(':UID', $uid);
        try {
            $sth->execute();
        } catch (PDOException $e) {
            debugLog(__FILE__, __METHOD__, __LINE__, $e->getMessage());
        }
        $re = $sth->fetchColumn();
//        echo ">>>>>>" . var_export($re, true) . "\n";
        if ($re > 0) {
            return $re;
        } else {
            return false;
        }
    }

}

?>
