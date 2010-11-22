<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

//$insert_sql = 'INSERT INTO vCard_Explanatory_Properties (`UID`,`VERSION`,`REV`,`LANG`,`CATEGORIES`,`PRODID`,`SORT-STRING`) VALUES (:UID,:VERSION,:REV,:LANG,:CATEGORIES,:PRODID,:SORT-STRING)';
$insert_sql = 'INSERT INTO vCard_Explanatory_Properties (`UID`,`VERSION`,`REV`,`LANG`,`CATEGORIES`,`PRODID`,`SORT-STRING`) VALUES (:UID,:VERSION,:REV,:LANG,:CATEGORIES,"",:SORT-STRING)';
$select_sql = 'SELECT * FROM vCard_Explanatory_Properties WHERE UID = :UID';
$dbh = new PDO('mysql:host=192.168.88.129;port=3306;dbname=DB_vCard', 'root', '123qwe', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
$sth = $dbh->prepare($insert_sql);
//$sth = $dbh->prepare($select_sql);

$vcard_data_array = array(
    'UID' => '46464646646464654654646464646464646456464646',
    'REV' => '20101013111111',
    'VERSION' => '3.0',
    'LANGAGE' => '',
    'CATEGORIES' => '',
    'PRODID' => '',
    'SORT-STRING' => ''
);

$sth->bindParam(':UID', $vcard_data_array['UID']);
$sth->bindParam(':VERSION', $vcard_data_array['VERSION']);
$sth->bindParam(':REV', $vcard_data_array['REV']);
$sth->bindParam(':LANG', $vcard_data_array['LANG']);
$sth->bindParam(':CATEGORIES', $vcard_data_array['CATEGORIES']);
$sth->bindParam(':PRODID', $vcard_data_array['PRODID']);
$sth->bindParam(':SORT-STRING', $vcard_data_array['SORT-STRING']);

//$sth->bindParam('UID', $vcard_data_array['UID']);
print_r($sth);
try {
    $sth->execute();
    print_r($sth->fetchAll());
} catch (Exception $e) {
    print_r($e->getMessage());
}
?>
