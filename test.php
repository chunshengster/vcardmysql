<?php
require_once 'class_vCard.php';

$c = file_get_contents('./a.vcf');
$b = new class_vCard();
print $b->parse_vcard($c);
?>
