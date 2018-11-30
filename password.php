<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/inc/functions.php');
$dbFcts = new DatabaseHelpers();

$crypt = $dbFcts->blowfishCrypt('pass', 10);
echo $crypt;
?>
