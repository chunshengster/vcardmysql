<?php

/**
 * @author chunsheng
 * use mysql for vCard backend
 * @date
 * @ver
 */
class class_vcard_storage {

    protected static $vcard_db_para_file = 'E:\xinshixun\Code\wo_vCard\trunk\config\config.ini';
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
        echo __CLASS__ . __METHOD__ . __LINE__ . "\n";
        echo "\n" . $dsn . "\n";
        try {
            $this->dbh = new PDO($dsn, self::$db_user, self::$db_pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
        } catch (PDOException $e) {
            print_r($e->getMessage());
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

    private function is_alive() {
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
        $uuid_array = $this->dbh->query($sql);

        //$uuid = uuid_create(UUID_TYPE_RANDOM);
        return $uuid_array['uuid'];
    }

    /* 	public function get_vCard_Attr($attr_name, $key) {
      if (! isset ( self::$attr_name )) {
      print "Error ,tb_" . $attr_name . "\n<br>";
      return NULL;
      }
      switch ($attr_name) {
      case self::$vCard_Explanatory_Properties :
      $sql = '';
      break;
      case self::$vCard_Identification_Properties :
      $sql = '';
      break;
      case self::$vCard_Telecommunications_Addressing_Properties_Tel :
      $sql = '';
      break;
      case self::$vCard_Telecommunications_Addressing_Properties_Email :
      $sql = '';
      break;
      case self::$vCard_Delivery_Addressing_Properties_LABEL :
      $sql = '';
      break;
      case self::$vCard_Delivery_Addressing_Properties_ADR :
      $sql = '';
      break;
      case self::$vCard_Organizational_Properties :
      $sql = '';
      break;
      case self::$vCard_Geographical_Properties :
      $sql = '';
      break;
      default :
      return NULL;
      }
      return 1;
      }
     */

    /*
     * @param: array('idvCard_Explanatory_Properties') or array('UID')
     *
     */

    public function get_vCard_Explanatory_Properties($key) {
        //        $sql = '';
        if (key($key) !== 'idvCard_Explanatory_Properties' or key($key) !== 'UID') {
            return NULL;
        }
        return self::_get_vcard_data_from_db('vCard_Explanatory_Properties', $key);
        /*
          $sql = "Select * From " . self::$vCard_Explanatory_Properties . " Where " . key ( $key ) . " = :KEY";
          $sth = $this->dbh->prepare ( $sql );
          $sth->bindParam ( ':KEY', $key [key ( $key )] );
          $sth->execute ();
          return $sth->fetchAll ();
         */
    }

    /*
     * @param array('vCard_Explanatory_Properties_idvCard_Explanatory_Properties')
     *      or array('idvCard_Identification_Properties')
     */

    public function get_vCard_Identification_Properties($key) {
        if (key($key) !== 'vCard_Explanatory_Properties_idvCard_Explanatory_Properties' or $key($key) !== 'idvCard_Identification_Properties') {
            return NULL;
        }
        return self::_get_vcard_data_from_db('vCard_Identification_Properties', $key);
    }

    public function get_vCard_Telecommunications_Addressing_Properties_Tel($key) {
        if (key($key) !== 'vCard_Explanatory_Properties_idvCard_Explanatory_Properties' or key($key) !== 'idvCard_Telecommunications_Addressing_Properties_Tel') {
            return NULL;
        }
        return self::_get_vcard_data_from_db('vCard_Telecommunications_Addressing_Properties_Tel', $key);
    }

    public function get_vCard_Telecommunications_Addressing_Properties_Email($key) {
        if (key($key) !== 'vCard_Explanatory_Properties_idvCard_Explanatory_Properties' or key($key) !== 'idvCard_Telecommunications_Addressing_Properties_Email') {
            return NULL;
        }
        return self::_get_vcard_data_from_db('vCard_Telecommunications_Addressing_Properties_Email', $key);
    }

    public function get_vCard_Delivery_Addressing_Properties_LABEL($key) {
        if (key($key) !== 'vCard_Explanatory_Properties_idvCard_Explanatory_Properties' or key($key) !== 'idvCard_Delivery_Addressing_Properties_LABEL') {
            return NULL;
        }
        return self::_get_vcard_data_from_db('vCard_Delivery_Addressing_Properties_LABEL', $key);
    }

    public function get_vCard_Delivery_Addressing_Properties_ADR($key) {
        if (key($key) !== 'vCard_Explanatory_Properties_idvCard_Explanatory_Properties' or key($key) !== 'idvCard_Delivery_Addressing_Properties_ADR') {
            return NULL;
        }
        return self::_get_vcard_data_from_db('vCard_Delivery_Addressing_Properties_ADR', $key);
    }

    public function get_vCard_Organizational_Properties($key) {
        if (key($key) !== 'vCard_Explanatory_Properties_idvCard_Explanatory_Properties' or key($key) !== 'idvCard_Organizational_Properties') {
            return NULL;
        }
        return self::_get_vcard_data_from_db('vCard_Organizational_Properties', $key);
    }

    public function get_vCard_Geographical_Properties($key) {
        if (key($key) !== 'vCard_Explanatory_Properties_idvCard_Explanatory_Properties' or key($key) !== 'idvCard_Geographical_Properties') {
            return NULL;
        }
        return self::_get_vcard_data_from_db('vCard_Geographical_Properties', $key);
    }

    private static function _get_vcard_data_from_db($table, $key) {
        $this->_gen_mysql_resource();
        $sql = "Select * From " . $table . " Where " . key($key) . " = :KEY";
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':KEY', $key [key($key)]);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function get_vcard_id_by_uid($uid) {
        if ($uid == '' or !isset($uid)) {
            return false;
        }
        if (strlen($uid) == 36) {
            /**
             * todo: check if $uid is UUID
             */
            $this->_gen_mysql_resource();
            $select_sql = "SELECT idvCard_Explanatory_Properties FROM " . self::$vCard_Explanatory_Properties . "WHERE UID = " . $uid;
            $sth = $this->dbh->execute($select_sql);
            return $sth->fetchAll();
        }
        return NULL;
    }

    public function store_data($vcard_comp, $vcard_data_array, $gen_uid=false) {

        echo __FILE__ . __METHOD__ . __LINE__ . var_export($vcard_comp, true) . var_export($vcard_data_array, true);
        if (!isset($vcard_comp) or $vcard_comp == '') {
            return false;
        }
        /*
          if ($vcard_data_array['UID'] == '' or !isset($vcard_data_array['UID'])) {

          } elseif(isset($vcard_data_array['V_ID']) && $vcard_data_array['V_ID'] !='') {


          }else{
          return false;
          }
          }elseif ($gen_uid !== true) {
          $vcard_exist = $this->check_vcard_exist_via_uid($vcard_data_array['UID']);
          }
         */
        //$this->dbh = $this->getInstance();
        $vcard_exist = false;
        $new_record = false;
        $this->_gen_mysql_resource();
        if ($gen_uid == true) {
            $vcard_data_array['UID'] = $this->_gen_uuid();
        } else {
            if ($vcard_data_array['UID'] !== '' && isset($vcard_data_array['UID'])) {
                $vcard_exist = $this->check_vcard_exist_via_uid($vcard_data_array['UID']);
            } elseif (isset($vcard_data_array['V_ID']) && $vcard_data_array['V_ID'] != '') {
                /**
                 * @todo 需要增加 对 V_ID 的检查，检查其是否存在与数据库中，并且该vcard 可用
                 *  V_ID 为 vcard db中的 vCard_Explanatory_Properties_idvCard_Explanatory_Properties 字段
                 */
                $vcard_exist = true;
            }
        }

        switch ($vcard_comp) {
            case self::$vCard_Explanatory_Properties:
                if (!$vcard_exist) {
                    //Importent: 'SORTSTRING',for PDO does not work with 'SORT-STRING'
                    $store_sql = "INSERT INTO " . self::$vCard_Explanatory_Properties . " (`UID`,`VERSION`,`REV`,`LANG`,`CATEGORIES`,`PRODID`,`SORT-STRING`) VALUES (:UID,:VERSION,:REV,:LANG,:CATEGORIES,:PRODID,:SORTSTRING)";
                } else {

                    $store_sql = "UPDATE " . self::$vCard_Explanatory_Properties . " SET `VERSION` = :VERSION,`REV` = :REV,`LANG` = :LANG,`CATEGORIES` = :CATEGORIES,`PRODID` = :PRODID,`SORT-STRING` = :SORTSTRING  WHERE UID = :UID";
                }
                echo "\n" . $store_sql . "\n";
                try {
                    $sth = $this->dbh->prepare($store_sql);
                } catch (Exception $e) {
                    echo $e->getMessage();
                }

                $sth->bindParam(':UID', $vcard_data_array['UID']);
                $sth->bindParam(':VERSION', $vcard_data_array['VERSION']);
                $sth->bindParam(':REV', $vcard_data_array['REV']);
                $sth->bindParam(':LANG', $vcard_data_array['LANG']);
                $sth->bindParam(':CATEGORIES', $vcard_data_array['CATEGORIES']);
                $sth->bindParam(':PRODID', $vcard_data_array['PRODID']);
                $sth->bindParam(':SORTSTRING', $vcard_data_array['SORT-STRING']);
                // SORTSTRING,for pdo does not work with 'SORT-STRING'
                echo "\n>>>>" . __CLASS__ . __METHOD__ . __LINE__ . "\n";
                try {
                    $sth->execute();
                } catch (PDOException $e) {
                    print_r($e->getMessage());
                }
                if (!$vcard_exist) {
                    $id = $this->dbh->lastInsertId();
                } else {
                    $id = $vcard_exist;
                }
                echo "\n >>>>" . __FILE__ . __METHOD__ . __LINE__ . var_export(array('UID' => $vcard_data_array['UID'], 'RESOURCE_ID' => isset($id) ? $id : null), true) . "\n";
                return array('UID' => $vcard_data_array['UID'], 'RESOURCE_ID' => isset($id) ? $id : null);
                break;

            case self::$vCard_Identification_Properties:
                /**
                  ＊if($vcard_exist && isset($vcard_data_array['RESOURCE_ID'])) {
                 * @todo 此处暂时去掉对 $vcard_exist 的检查
                 */
                if (isset($vcard_data_array['RESOURCE_ID'])) {
                    $new_record = false;
                    $store_sql = "UPDATE " . self::$vCard_Identification_Properties . " SET `N` = :N,`FN` = :FN,`NICKNAME` = :NICKNAME,`PHOTO` = :PHOTO,`PhotoType` = :PhotoType,`BDAY` = :BDAY,`URL` = :URL,`SOUND` = :SOUND,`NOTE` = :NOTE where `idvCard_Identification_Properties` = :RESOURCEID ";
                } elseif ((!isset($vcard_data_array['RESOURCE_ID']) && isset($vcard_data_array['V_ID']))) {
                    /**
                     * (($vcard_exist) && (!isset($vcard_data_array['RESOURCE_ID']) && isset($vcard_data_array['V_ID']))) {
                     * @todo 此处暂时去掉对 $vcard_exist的检查
                     */
                    $new_record = true;
                    $vcard_data_array['RESOURCE_ID'] = $vcard_data_array['V_ID'];
                    $store_sql = "INSERT INTO " . self::$vCard_Identification_Properties . " (`vCard_Explanatory_Properties_idvCard_Explanatory_Properties`,`N`,`FN`,`NICKNAME`,`PHOTO`,`PhotoType`,`BDAY`,`URL`,`SOUND`,`NOTE`) VALUES (:RESOURCEID,:N,:FN,:NICKNAME,:PHOTO,:PhotoType,:BDAY,:URL,:SOUND,:NOTE) ";
                } else {
                    echo '>>>>>>>> return false  ' . __FILE__ . __METHOD__ . __LINE__ . "\n";
                    return false;
                }
                echo "\n" . $store_sql . "\n";
                try {
                    $sth = $this->dbh->prepare($store_sql);
                } catch (Exception $e) {
                    print_r($e->getMessage());
                }
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
                try {
                    $sth->execute();
                } catch (Exception $e) {
                    print_r($e->getMessage());
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
                    $store_sql = "UPDATE " . self::$vCard_Geographical_Properties . " SET TZ = :TZ , GEO = :GEO where idvCard_Geographical_Properties = :RESOURCEID";
                } else {
                    return false;
                }
                echo '>>>>> $store_sql : ' . __LINE__ . ' :' . $store_sql . "\n";

                $sth = $this->dbh->prepare($store_sql);
                $sth->bindParam(':RESOURCEID', $vcard_data_array['RESOURCE_ID']);
                $sth->bindParam(':TZ', $vcard_data_array['TZ']);
                $sth->bindParam(':GEO', $vcard_data_array['GEO']);

                try {
                    $sth->execute();
                } catch (Exception $e) {
                    print_r($e->getMessage());
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
                    $store_sql = "UPDATE " . self::$vCard_Organizational_Properties . " SET `TITLE` = :TITLE ,`ROLE` = :ROLE ,`LOGO` = :LOGO ,`LogoType` = :LogoType ,`ORG` = :ORG WHERE vCard_Explanatory_Properties_idvCard_Explanatory_Properties = :RESOURCEID";
                }

                $sth = $this->dbh->prepare($store_sql);
                $sth->bindParam(':TITLE', $vcard_data_array['TITLE']);
                $sth->bindParam(':ROLE', $vcard_data_array['ROLE']);
                $sth->bindParam(':LOGO', $vcard_data_array['LOGO']);
                $sth->bindParam(':LogoType', $vcard_data_array['LogoType']);
                $sth->bindParam(':ORG', $vcard_data_array['ORG']);
                $sth->bindParam(':RESOURCEID', $vcard_data_array['RESOURCE_ID']);

                try {
                    $sth->execute();
                } catch (Exception $e) {
                    print_r($e->getMessage());
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
                            $store_sql = "UPDATE " . self::$vCard_Delivery_Addressing_Properties_ADR . " SET ADR=:ADR, AdrType=:AdrType WHERE idvCard_Delivery_Addressing_Properties_ADR=:RESOURCEID";
                        }
                        try {
                            $sth = $this->dbh->prepare($store_sql);
                        } catch (Exception $e) {
                            print_r($e->getMessage());
                        }
                        $sth->bindParam(':RESOURCEID', $t_vcard_data['RESOURCE_ID']);
                        $sth->bindParam(':ADR', $t_vcard_data['ADR']);
                        $sth->bindParam(':AdrType', $t_vcard_data['AdrType']);
                        try {
                            $sth->execute();
                        } catch (Exception $e) {
                            print_r($e->getMessage());
                        }

                        if ($new_record) {
                            $re[$k]['RESOURCE_ID'] = $this->dbh->lastInsertId();
                        } else {
                            echo '>>>>>>$t_vcard_data:' . var_export($t_vcard_data);
                            $re[$k]['RESOURCE_ID'] = $t_vcard_data['RESOURCE_ID'];
                        }
                    }
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
                            $store_sql = "UPDATE " . self::$vCard_Delivery_Addressing_Properties_LABEL . " SET LABEL=:LABEL ,LabelType=:LabelType WHERE idvCard_Delivery_Addressing_Properties_LABEL=:RESOURCEID";
                        }
                        echo '>>>>>>$store_sql:'.var_export($store_sql,true)."\n";
                        try {
                            $sth = $this->dbh->prepare($store_sql);
                        } catch (Exception $e) {
                            print_r($e->getMessage());
                        }
                        $sth->bindParam(':RESOURCEID', $t_vcard_data['RESOURCE_ID']);
                        $sth->bindParam(':LABEL', $t_vcard_data['LABEL']);
                        $sth->bindParam(':LabelType', $t_vcard_data['LabelType']);
                        try {
                            $sth->execute();
                        } catch (Exception $e) {
                            print_r($e->getMessage());
                        }
                        if ($new_record) {
                            $re[$k]['RESOURCE_ID'] = $this->dbh->lastInsertId();
                        } else {
                            echo '>>>>>>$t_vcard_data:' . var_export($t_vcard_data,true);
                            $re[$k]['RESOURCE_ID'] = $t_vcard_data['RESOURCE_ID'];
                        }
                    }
                    echo '>>>>>>$t_vcard_data:' . var_export($re,true);
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
                            $store_sql = "UPDATE " . self::$vCard_Telecommunications_Addressing_Properties_Tel . " SET TEL=:TEL ,TelType=:TelType WHERE idvCard_Telecommunications_Addressing_Properties_Tel=:RESOURCEID";
                        }
                        try {
                            $sth = $this->dbh->prepare($store_sql);
                        } catch (Exception $e) {
                            print_r($e->getMessage());
                        }
                        $sth->bindParam(':RESOURCEID', $t_vcard_data['RESOURCE_ID']);
                        $sth->bindParam(':TEL', $t_vcard_data['TEL']);
                        $sth->bindParam(':TelType', $t_vcard_data['TelType']);
                        try {
                            $sth->execute();
                        } catch (Exception $e) {
                            print_r($e->getMessage());
                        }
                        if ($new_record) {
                            $re[$k]['RESOURCE_ID'] = $this->dbh->lastInsertId();
                        } else {
                            echo '>>>>>>$t_vcard_data:' . var_export($t_vcard_data);
                            $re[$k]['RESOURCE_ID'] = $t_vcard_data['RESOURCE_ID'];
                        }
                    }
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
                            $store_sql = "UPDATE " . self::$vCard_Telecommunications_Addressing_Properties_Email . " SET EMAIL=:EMAIL ,EmailType=:EmailType WHERE idvCard_Telecommunications_Addressing_Properties_Email=:RESOURCEID";
                        }
                        try {
                            $sth = $this->dbh->prepare($store_sql);
                        } catch (Exception $e) {
                            print_r($e->getMessage());
                        }
                        $sth->bindParam(':RESOURCEID', $t_vcard_data['RESOURCE_ID']);
                        $sth->bindParam(':EMAIL', $t_vcard_data['EMAIL']);
                        $sth->bindParam(':EmailType', $t_vcard_data['EmailType']);
                        try {
                            $sth->execute();
                        } catch (Exception $e) {
                            print_r($e->getMessage());
                        }
                        if ($new_record) {
                            $re[$k]['RESOURCE_ID'] = $this->dbh->lastInsertId();
                        } else {
                            echo '>>>>>>$t_vcard_data:' . var_export($t_vcard_data);
                            $re[$k]['RESOURCE_ID'] = $t_vcard_data['RESOURCE_ID'];
                        }
                    }
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
        echo implode(':', array(__FILE__, __METHOD__, __LINE__, 'uid:', $uid)) . "\n";
        $this->_gen_mysql_resource();
        $FindUidSql = "SELECT `idvCard_Explanatory_Properties` FROM " . self::$vCard_Explanatory_Properties . " WHERE UID = :UID";
        echo ">>>>>" . $FindUidSql . "\n";
        $sth = $this->dbh->prepare($FindUidSql);
        $sth->bindParam(':UID', $uid);
        $sth->execute();
        $re = $sth->fetchColumn();
        echo ">>>>>>" . var_export($re, true) . "\n";
        if ($re > 0) {
            return $re;
        } else {
            return false;
        }
    }

}

?>