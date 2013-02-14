<?php
error_reporting(E_ALL);
ini_set('display_errors','On');
date_default_timezone_set('Europe/Lisbon');

$data = array();

$data_temp = file("QuickSort.txt");
foreach($data_temp as $el) {
    $data[] = (int)$el;
} 

//$data = array(2, 8, 9, 3, 7, 5, 10, 1, 6, 4);
//$data = array();
//for ($i=1;$i<=100;$i++){
////for ($i=100;$i>=1;$i--){
//    $data[] = $i;
//}
//shuffle($data);

include "quick_sort.php";
//include "merge_sort.php";
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
