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
require_once 'class_vCard.php';

$c = file_get_contents('./a.vcf');
$b = new class_vCard();
//print $b->parse_vcard($c);
//print_r($b->get_VCard_Explanatory_Properties());

$b->_builder->setFromArray($b->_parse)

?>
