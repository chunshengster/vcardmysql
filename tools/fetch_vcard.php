<?php
require_once dirname(__FILE__).'/../class_vCard.php';

$gen_uid = false;

$uuid = $argv[1];
//$user_id = $argv[2];
if(!isset ($argv[1])){
//    useage();
    exit(0);
}

$vcard = new class_vCard();
$re = $vcard->get_vCard_Text(true, $uuid);
var_export($re);
?>
