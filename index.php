<?php
error_reporting(E_ALL);
ini_set('display_errors','On');
date_default_timezone_set('Europe/Lisbon');

$data = array();

//$data_temp = file("QuickSort.txt");
//foreach($data_temp as $el) {
//    $data[] = (int)$el;
//}


//$data = array();
//for ($i=1;$i<=15;$i++){
////for ($i=100;$i>=1;$i--){
//    $data[] = $i;
//}
//shuffle($data);

include "dijkstraShortPath.php";
//include "merge_sort.php";
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
