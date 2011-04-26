<?php
require_once dirname(__FILE__).'/../lib/class_vCard.php';

$gen_uid = false;


//$user_id = $argv[2];
if(!isset ($argv[1])){
    useage();
    exit(0);
}


function useage() {
    echo "php $argv[0] uuid vcard_id";
    echo "ether uuid or vcard_id should be \'\' if it is null";
}


$vcard = new class_vCard();

if($argv[2] == '' ){
    $re = $vcard->get_Full_vCard_From_Storage($argv[1]);
    
}else{
    $re = $vcard->get_Full_vCard_From_Storage('',$argv[2]);

}

var_export($re);
$re = $vcard->get_vCard_Text(true, $uuid);
var_export($re);
var_export($vcard->get_vCard_Data());

?>
