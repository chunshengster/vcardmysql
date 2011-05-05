<?php
/*
  $a = array('id' => 1,
             'gid' => 2
       );
  print_r($a);
  print key($a);
  $b = array('c' => 2);
  print "\n";
  print $b[key($b)];

include_once 'File/IMC.php';
if (!class_exists('File_IMC')) {
    die('SKIP File_IMC is not installed, or your include_path is borked.');
}

require_once 'File/IMC.php';

$parse = File_IMC::parse ( 'vcard' );
$card_info = $parse->fromFile ( './a.vcf' );
#print_r ($card_info);
$builder = File_IMC::build ( 'vcard' );
$builder->setFromArray ( $card_info['VCARD'] );
#print_r($builder);
echo $builder->getName();
echo "hello\n";

echo $builder->getAddress(0);
echo $builder->getMeta('ADR');
echo $builder->getParam('ADR',0);

require_once('File/IMC.php');

$parse = File_IMC::parse('vCard');
$parse = File_IMC::parse('vcard')
$card_info = $parse->fromFile('./a.vcf');
#var_export($card_info);
print_r($card_info['VCARD'][0]['FN'][0]['value'][0][0]);
#print_r($card_info);
  #$parse = new File_IMC::parse('vCard');
  echo "\n";
  echo "\n";
*/
/*require_once 'class_vCard.php';

$c = file_get_contents('./a.vcf');*/
/*
$b = new class_vCard();
print $b->parse_vcard($c);
//print_r($b->get_VCard_Explanatory_Properties());
$b->print_parse_data();
*/

//$parse = File_IMC::parse ( 'vcard' );
//$card_info = $parse->fromFile ( './a.vcf' );
//
//$builder = File_IMC::build ( 'vcard' );
//$builder->setFromArray ( $card_info['vcard'] );
//$builder->getAddress();
/**
require_once 'class_vCard.php';
$obj_vcard = new class_vCard();
$c = file_get_contents('./a.vcf');
$obj_vcard->parse_vcard($c);
print_r($obj_vcard);
 *
 */

//$str = 'one|two|three|four';
//
//// positive limit
//print_r(explode('|', $str, 2));
//
//print_r(explode('|', $str,1));
//
//// negative limit (since PHP 5.1)
//print_r(explode('|', $str, -1));

//require_once 'lib/vCard_Diff_Lib.php';
//
//$a = array (
//  'vCard_Explanatory_Properties' =>
//  array (
//    'UID' => '',
//    'REV' => '2011-03-15T11:15:37+08:00',
//    'VERSION' => '2.1',
//    'LANG' => '',
//    'CATEGORIES' => '',
//    'PRODID' => 'Wo-Push',
//    'SORT-STRING' => '',
//  ),
//  'vCard_Identification_Properties' =>
//  array (
//    'FN' => '王春生',
//    'N' => '王春生;;;;',
//    'NICKNAME' => '',
//    'PHOTO' => '',
//    'PhotoType' => NULL,
//    'BDAY' => '',
//    'URL' => '',
//    'SOUND' => '',
//    'NOTE' => '',
//  ),
//  'vCard_Delivery_Addressing_Properties_ADR' =>
//  array (
//  ),
//  'vCard_Delivery_Addressing_Properties_LABEL' =>
//  array (
//  ),
//  'vCard_Geographical_Properties' =>
//  array (
//    'TZ' => '',
//    'GEO' => ';',
//  ),
//  'vCard_Organizational_Properties' =>
//  array (
//    'TITLE' => '',
//    'ROLE' => '',
//    'LOGO' => '',
//    'LogoType' => NULL,
//    'AGENT' => '',
//    'ORG' => '',
//  ),
//  'vCard_Telecommunications_Addressing_Properties_Email' =>
//  array (
//    0 =>
//    array (
//      'EMAIL' => 'chunshengster@gmail.com',
//      'EmailType' => 'INTERNET',
//    ),
//  ),
//  'vCard_Telecommunications_Addressing_Properties_Tel' =>
//  array (
//    0 =>
//    array (
//      'TEL' => '01066505725',
//      'TelType' => 'WORK',
//    ),
//    1 =>
//    array (
//      'TEL' => '13810154397',
//      'TelType' => 'CELL',
//    ),
//  ),
//);
//
//$b = array (
//  'vCard_Explanatory_Properties' =>
//  array (
//    'UID' => '9a004c9c-3e3e-11e0-b3cb-fefdade6870a',
//    'VERSION' => '2.1',
//    'REV' => '2011-02-22 12:45:41',
//    'LANG' => '',
//    'CATEGORIES' => '',
//    'PRODID' => 'Wo-Push',
//    'SORT-STRING' => '',
//    'RESOURCE_ID' => '162',
//  ),
//  'vCard_Identification_Properties' =>
//  array (
//    'N' => '王春生;;;;',
//    'FN' => '王春生',
//    'PHOTO' => '',
//    'PhotoType' => NULL,
//    'BDAY' => '0000-00-00',
//    'URL' => '',
//    'SOUND' => '',
//    'NOTE' => '',
//    'NICKNAME' => '',
//    'RESOURCE_ID' => '168',
//  ),
//  'vCard_Delivery_Addressing_Properties_ADR' =>
//  array (
//  ),
//  'vCard_Delivery_Addressing_Properties_LABEL' =>
//  array (
//  ),
//  'vCard_Geographical_Properties' =>
//  array (
//    'TZ' => '',
//    'GEO' => ';',
//    'RESOURCE_ID' => '168',
//  ),
//  'vCard_Organizational_Properties' =>
//  array (
//    'TITLE' => '',
//    'ROLE' => '',
//    'LOGO' => '',
//    'LogoType' => NULL,
//    'ORG' => '',
//    'RESOURCE_ID' => '168',
//  ),
//  'vCard_Telecommunications_Addressing_Properties_Email' =>
//  array (
//    0 =>
//    array (
//      'EMAIL' => 'chunshengster@gmail.com',
//      'EmailType' => 'INTERNET',
//      'RESOURCE_ID' => '419',
//    ),
//  ),
//  'vCard_Telecommunications_Addressing_Properties_Tel' =>
//  array (
//    0 =>
//    array (
//      'TEL' => '01066505725',
//      'TelType' => 'WORK',
//      'RESOURCE_ID' => '1277',
//    ),
//    1 =>
//    array (
//      'TEL' => '18601108092',
//      'TelType' => 'CELL',
//      'RESOURCE_ID' => '1278',
//    ),
//  ),
//);
//
//$re = vCard_Diff_Lib::vCard_Diff($b, $a);
//
//var_export($re);

require_once 'lib/class_vCard.php';
require_once 'lib/vCard_Diff_Lib.php';
$v = new class_vCard();
$v->set_vCard_Explanatory_Properties(
        array(
            'RESOURCE_ID'=>190,
            ));
//print_r($v);
$re = $v->get_Full_vCard_From_Storage();
//print_r($v->get_vCard_Text());
//print_r($v);
$vb = new class_vCard($v);
$vb->set_vCard_Extension_Properties(array(
    'X-MICROBLOG'=>array('Value'=>'http://weibo.com/abc@abc'),
    'X-fjsdlj' => array('Value'=>'fjlsdjflsflj'),
));
print_r($v);
print_r($vb);

$re = vCard_Diff_Lib::vCard_Diff($v->get_vCard_Data(), $vb->get_vCard_Data());
print_r($re);


?>
