<?php
error_reporting(E_ALL);
ini_set('display_errors','On');
date_default_timezone_set('Europe/Lisbon');
ini_set("memory_limit","1000M");

$data = array();

//$data_temp = file("data/HashInt.txt");
$data_temp = file("data/Median.txt");
foreach($data_temp as $el) {
    $data[] = (int)$el;
}


//$data = array();
//for ($i=1;$i<=15;$i++){
////for ($i=100;$i>=1;$i--){
//    $data[] = $i;
//}
//shuffle($data);

include "median.php";