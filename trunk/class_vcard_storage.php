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
    private static $vCard_Delivvery_Addressing_Properties_ADR = 'vCard_Delivery_Addressing_Properties_ADR';
    private static $vCard_Delivvery_Addressing_Properties_LABEL = 'vCard_Delivery_Addressing_Properties_LABEL';
    private static $vCard_Geographical_Properties = 'vCard_Geographical_Properties';
    private static $vCard_Organizational_Properties = 'vCard_Organizational_Properties';
    private static $vCard_Telecommunications_Addressing_Properties_Email = 'vCard_Telecommunications_Addressing_Properties_Email';
    private static $vCard_Telecommunications_Addressing_Properties_Tel = 'vCard_Telecommunications_Addressing_Properties_Tel';

    function __construct() {
        self::getMysqlPara ();
        self::getInstance ();
    }

    function __destruct() {
        if ($this->dbh) {
            unset($this->dbh);
        }
    }

    private static function getInstance() {
        $dsn = self::$db_driver . ":host=" . self::$db_host . ";port=" . self::$db_port . ";dbname=" . self::$db_name;
        echo __CLASS__ . __METHOD__ . __LINE__ . "\n";
        echo "\n" . $dsn . "\n";
        try {
            $this->dbh = new PDO($dsn, self::$db_user, self::$db_pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            return $this->dbh;
        } catch (PDOException $e) {
            print_r($e->getMessage());
        }
    }

    public function is_alive() {
        if ($this->dbh->getAttribute(PDO::ATTR_CONNECTION_STATUS) > 0) {
            return true;
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
      case self::$vCard_Delivvery_Addressing_Properties_LABEL :
      $sql = '';
      break;
      case self::$vCard_Delivvery_Addressing_Properties_ADR :
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

    public function get_vCard_Delivvery_Addressing_Properties_LABEL($key) {
        if (key($key) !== 'vCard_Explanatory_Properties_idvCard_Explanatory_Properties' or key($key) !== 'idvCard_Delivery_Addressing_Properties_LABEL') {
            return NULL;
        }
        return self::_get_vcard_data_from_db('vCard_Delivery_Addressing_Properties_LABEL', $key);
    }

    public function get_vCard_Delivvery_Addressing_Properties_ADR($key) {
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
            $select_sql = "SELECT idvCard_Explanatory_Properties FROM " . self::$vCard_Explanatory_Properties . "WHERE UID = " . $uid;
            $sth = $this->dbh->execute($select_sql);
            return $sth->fetchAll();
        }
        return NULL;
    }

    public function store_data($vcard_comp, $vcard_data_array, $gen_uid=false) {
        if (!isset($vcard_comp) or $vcard_comp == '') {
            return false;
        }
        if ($vcard_data_array['UID'] == '' or !isset($vcard_data_array['UID'])) {
            if ($gen_uid == true) {
                $vcard_data_array['UID'] = $this->_gen_uuid();
            } else {
                return false;
            }
        }
        if ($gen_uid !== true) {
            $vcard_exist = $this->check_vcard_exist_via_uid($vcard_data_array['UID']);
        }
        $this->dbh = self::getInstance();
        print_r($vcard_data_array);
        switch ($vcard_comp) {
            case self::$vCard_Explanatory_Properties:
                if (!$vcard_exist) {
                    //Importent: 'SORTSTRING',for PDO does not work with 'SORT-STRING'
                    $store_sql = "INSERT INTO " . self::$vCard_Explanatory_Properties . " (`UID`,`VERSION`,`REV`,`LANG`,`CATEGORIES`,`PRODID`,`SORT-STRING`) VALUES (:UID,:VERSION,:REV,:LANG,:CATEGORIES,:PRODID,:SORTSTRING)";
                } else {
                    $store_sql = "UPDATE " . self::$vCard_Explanatory_Properties . " SET `VERSION` = :VERSION,`REV` = :REV,`LANG` = :LANG,`CATEGORIES` = :CATEGORIES,`PRODID` = :PRODID,`SORT-STRING` = :SORTSTRING  WHERE UID = :UID";
                }
                echo "\n" . $store_sql . "\n";
                try{
                    $sth = $this->dbh->prepare($store_sql);
                }  catch (Exception $e){
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
                $id = $this->dbh->lastInsertId();
                return array('UID' => $vcard_data_array['UID'], 'RESOURCE_ID' => isset($id) ? $id : null);

            case self::$vCard_Identification_Properties:
                if ((!$vcard_exist) && (!isset($vcard_data_array['RESOURCE_ID']) && isset($vcard_data_array['V_ID']))) {
                    $vcard_data_array['RESOURCE_ID'] = $vcard_data_array['V_ID'];
                    $store_sql = "INSERT INTO " . self::$vCard_Identification_Properties . " (`vCard_Explanatory_Properties_idvCard_Explanatory_Properties`,`N`,`FN`,`NICKNAME`,`PHOTO`,`PhotoType`,`BDAY`,`URL`,`SOUND`,`NOTE`) VALUES (:RESOURCEID,:N,:FN,:NICKNAME,:PHOTO,:PhotoType,:BDAY,:URL,:SOUND,:NOTE) ";
                } elseif($vcard_exist && isset($vcard_data_array['RESOURCE_ID'])) {
                    $store_sql = "UPDATE " . self::$vCard_Identification_Properties . " SET `N` = :N,,`FN` = :FN,`NICKNAME` = :NICKNAME,`PHOTO` = :PHOTO,`PhotoType` = :PhotoType,`BDAY` = :BDAY,`URL` = :URL,`SOUND` = :SOUND,`NOTE` = :NOTE where `idvCard_Identification_Properties` = :RESOURCEID ";
                }else{
                    return false;
                }
                try{
                    $sth = $this->dbh->prepare($store_sql);
                }catch (Exception $e){
                    print_r($e->getMessage());
                }
                $sth->bindParam(':RESOURCEID',$vcard_data_array['RESOURCE_ID']);
                $sth->bindParam(':N',$vcard_data_array['N']);
                $sth->bindParam(':FN',$vcard_data_array['FN']);
                $sth->bindParam(':NICKNAME',$vcard_data_array['NICKNAME']);
                $sth->bindParam(':PHOTO',$vcard_data_array['PHOTO']);
                $sth->bindParam(':PhotoType',$vcard_data_array['PhotoType']);
                $sth->bindParam(':BDAY',$vcard_data_array['BDAY']);
                $sth->bindParam(':URL',$vcard_data_array['URL']);
                $sth->bindParam(':SOUND',$vcard_data_array['SOUND']);
                $sth->bindParam(':NOTE',$vcard_data_array['NOTE']);
                try {
                    $sth->execute();
                } catch (Exception $e) {
                    print_r($e->getMessage());
                }
                if ((!$vcard_exist) && (!isset($vcard_data_array['RESOURCE_ID']) && isset($vcard_data_array['V_ID']))) {
                    $vcard_data_array['RESOURCE_ID'] = $this->dbh->lastInsertId();
                }
                return array('RESOURCE_ID' => $vcard_data_array['RESOURCE_ID']);
                break;

            case self::$vCard_Delivery_Addressing_Properties_ADR:
                if (!$vcard_exist) {
                    $store_sql = "INSERT INTO " . self::$vCard_Delivvery_Addressing_Properties_ADR . " (`vCard_Explanatory_Properties_idvCard_Explanatory_Properties`,`ADR`,`AdrType`) VALUES (:RESOURCE_ID,:ADR,:AdrType)";
                } else {
                    /**
                     * @todo “ADR 可以有多个条目，更新策略要独立设计”
                     */
                    $store_sql = "";
                }
                $sth = $this->dbh->prepare($insert_sql);
                $_tmp = $vcard_data_array['RESOURCE_ID'];
                unset($vcard_data_array['RESOURCE_ID']);
                foreach ($vcard_data_array as $vcard_r) {
                    $vcard_r['RESOURCE_ID'] = $_tmp;
                    try {
                        $sth->execute($vcard_r);
                    } catch (Exception $e) {
                        print_r($e->getMessage());
                    }
                }
                return array('RESOURCE_ID' => $_tmp);
                break;
                
            case self::$vCard_Delivery_Addressing_Properties_LABEL:

                if(!$vcard_exist ){
                    $store_sql = "INSERT INTO " . self::$vCard_Delivvery_Addressing_Properties_LABEL . " (`vCard_Explanatory_Properties_idvCard_Explanatory_Properties`,`LABEL`,`LabelType`,) VALUES(:RESOURCE_ID,:LABEL,:LabelType)";
                } else{
                    /**
                     * @todo ADR Lable 会有多条记录，更新策略需要进行设计
                     */
                    $store_sql = "";
                }
                
                $sth = $this->dbh->prepare($store_sql);
                $_tmp = $vcard_data_array['RESOURCE_ID'];
                unset($vcard_data_array['RESOURCE_ID']);
                foreach ($vcard_data_array as $vcard_r) {
                    $vcard_r['RESOURCE_ID'] = $_tmp;
                    try {
                        $sth->execute($vcard_r);
                    } catch (Exception $e) {
                        print_r($e->getMessage());
                    }
                }
                return array('RESOURCE_ID' => $_tmp);
                break;
                
            case self::$vCard_Geographical_Properties:
                if(!$vcard_exist){
                    /**
                     * :RESOURCE_ID change to :RESOURCEID
                     */
                    $store_sql = "INSERT INTO " . self::$vCard_Geographical_Properties . " (`vCard_Explanatory_Properties_idvCard_Explanatory_Properties`,`TZ`,`GEO`) VALUES (:RESOURCEID,:TZ,:GEO)";
                }else{
                    $store_sql = "UPDATE ". self::$vCard_Geographical_Properties . " SET TZ = :TZ , GEO = :GEO where vCard_Explanatory_Properties_idvCard_Explanatory_Properties = :RESOURCEID";
                }
                $sth = $this->dbh->prepare($store_sql);
                $sth->bindParam(':RESOURCEID', $vcard_data_array['RESOURCE_ID']);
                $sth->bindParam(':TZ', $vcard_data_array['TZ']);
                $sth->bindParam(':GEO', $vcard_data_array['GEO']);
                
                try {
                    $sth->execute();
                } catch (Exception $e) {
                    print_r($e->getMessage());
                }
                return array('RESOURCE_ID' => $vcard_data_array['RESOURCE_ID']);
                break;
                
            case self::$vCard_Organizational_Properties:
                if(!$vcard_exist){
                    $store_sql = "INSERT INTO " . self::$vCard_Organizational_Properties . " (`vCard_Explanatory_Properties_idvCard_Explanatory_Properties` ,`TITLE` ,`ROLE` ,`LOGO` ,`LogoType` ,`ORG`) VALUES (:RESOURCEID,:TITLE,:ROLE,:LOGO,:LogoType,:ORG)";
                }else{
                    $store_sql = "UPDATE ".self::$vCard_Organizational_Properties. " SET `TITLE` = :TITLE ,`ROLE` = :ROLE ,`LOGO` = :LOGO ,`LogoType` = :LogoType ,`ORG` = :ORG WHERE vCard_Explanatory_Properties_idvCard_Explanatory_Properties = :RESOURCEID";
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
                return array('RESOURCE_ID' => $vcard_data_array['RESOURCE_ID']);
                break;
            
            case self::$vCard_Telecommunications_Addressing_Properties_Tel:
                $insert_sql = "INSERT INTO " . self::$vCard_Telecommunications_Addressing_Properties_Tel . " (`vCard_Explanatory_Properties_idvCard_Explanatory_Properties`, `TEL` ,`TelType`) VALUES (:RESOURCE_ID, :TEL, :TelType)";
                $sth = $this->dbh->prepare($insert_sql);
                $_tmp = $vcard_data_array['RESOURCE_ID'];
                unset($vcard_data_array['RESOURCE_ID']);
                foreach ($vcard_data_array as $vcard_r) {
                    $vcard_r['RESOURCE_ID'] = $_tmp;
                    try {
                        $sth->execute($vcard_r);
                    } catch (Exception $e) {
                        print_r($e->getMessage());
                    }
                }
                return array('RESOURCE_ID' => $vcard_data_array['RESOURCE_ID']);
                break;
                
            case self::$vCard_Telecommunications_Addressing_Properties_Email:
                $insert_sql = "INSERT INTO " . self::$vCard_Telecommunications_Addressing_Properties_Email . " (`vCard_Explanatory_Properties_idvCard_Explanatory_Properties`, `EMAIL`, `EmailType`) VALUES (:RESOURCE_ID, :EMAIL, :EMAIL)";
                $sth = $this->dbh->prepare($insert_sql);
                $_tmp = $vcard_data_array['RESOURCE_ID'];
                unset($vcard_data_array['RESOURCE_ID']);
                foreach ($vcard_data_array as $vcard_r) {
                    $vcard_r['RESOURCE_ID'] = $_tmp;
                    try {
                        $sth->execute($vcard_r);
                    } catch (Exception $e) {
                        print_r($e->getMessage());
                    }
                }
                return array('RESOURCE_ID' => $vcard_data_array['RESOURCE_ID']);
                break;
        }
    }

    public static function check_vcard_exist_via_uid($uid = null) {
        if ($uid == null) {
            return false;
        }
        $FindUidSql = "SELECT count(UID) FROM " . self::$vCard_Explanatory_Properties . " WHERE UID = :UID";
        $sth = $this->dbh->prepare($FindUidSql);
        $sth->bindParam(':UID', $uid);
        $sth->execute();
        return $sth->rowCount() > 0 ? true : false;
    }

}

?>