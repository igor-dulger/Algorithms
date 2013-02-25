<?php
set_time_limit(3600*5);

require "graph.php";

$data = array(
    "1	2	3" ,
    "2	1	3	4",
    "3	1	2	4",
    "4	2	3"
);
//$data = file("kargerMinCut.txt");
//$data = file("testCut.txt");

//print_r($data);
list ($v, $e) = load_graph($data) ;
//print_r(array($v, $e));

$min = count($e)+1;
$cnt = count($v);
print_r(intval($cnt*$cnt*log($cnt)));

for ($i=0; $i< intval($cnt*$cnt*log($cnt)); $i++) {
$start = microtime(true);
//for ($i=0; $i<1800; $i++) {
    $cut = minCut($v, $e);
    if ($min > $cut) $min = $cut;
//break;
}
print_r(array("cut" => $cut, "time" => microtime(true)- $start));

print_r(array($min));
?>
