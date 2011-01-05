<?php
/**
 * @author chunshengster@gmail.com
 * 导入一个vcf文件到数据库中，并指定该vcard属于某个用户id
 * @tutorial php.exe import_vcf.php 'a.vcf' 'user_id'
 * @todo 完成更新vcard与user之间关系的逻辑
 */
require_once dirname(__FILE__).'/../class_vCard.php';

$gen_uid = false;

$vcf_file = $argv[1];
$user_id = $argv[2];
if(!isset ($argv[1]) && !isset ($argv[2])){
    useage();
    exit(0);
}



$vcard_text = file_get_contents($vcf_file);
echo __FILE__,__LINE__,var_export($vcard_text,true);
$vcard = new class_vCard();
$re = $vcard->parse_vCard($vcard_text);
echo __FILE__,__LINE__,  var_export($re,true);
$vcard_explanatory_properties = $vcard->get_vCard_Explanatory_Properties();
if($vcard_explanatory_properties['UID'] != ''){
    $gen_uid = false;
}else{
    $gen_uid = true;
}


$re = $vcard->store_vCard_Explanatory_Properties($gen_uid);
echo __FILE__,__LINE__,  var_export($re,true);
if($re == ''){
    exit(0);
}
$re = $vcard->store_vCard_Identification_Properties();
echo __FILE__,__LINE__,  var_export($re,true);

$re = $vcard->store_vCard_Geographical_Properties();
echo __FILE__,__LINE__,  var_export($re,true);

$re = $vcard->store_vCard_Organizational_Properties();
echo __FILE__,__LINE__,  var_export($re,true);

$re = $vcard->store_vCard_Delivery_Addressing_Properties_ADR();
echo __FILE__,__LINE__,  var_export($re,true);

$re = $vcard->store_vCard_Delivery_Addressing_Properties_LABEL();
echo __FILE__,__LINE__,  var_export($re,true);

$re = $vcard->store_vCard_Telecommunications_Addressing_Properties_Tel();
echo __FILE__,__LINE__,  var_export($re,true);

$re = $vcard->store_vCard_Telecommunications_Addressing_Properties_Email();
echo __FILE__,__LINE__,  var_export($re,true);


echo __FILE__,__LINE__,var_export($vcard->get_vCard_Text(),true);



function useage() {
    echo "---------***************--------------\n";
    echo "import one .vcf file into DB_vCard then make relationship between vcard_id and user_id\n";
    echo "php import_vcf.php 'a.vcf' 'user_id'\n";
    echo "lucky for you ! \n";
}

?>
