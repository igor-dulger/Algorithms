<?php
require "graph.php";

use graph\dijkstra as d;

//$data = array(
//"1   2,10    4,30    5,100",
//"2   3,50",
//"3   5,10",
//"4   3,20    5,60",
//"5    ",
//);
//
//$data = array(
//"1   2,1 4,4",
//"2   1,1 3,1",
//"3   2,1 4,1",
//"4   1,4 3,1"
//);
//
//$data = array(
//"1   2,1 3,2 4,4",
//"2   1,1 3,2",
//"3   1,2 2,2 4,0",
//"4   1,4 3,0"
//);
//
//$data = array(
//"1   2,1 3,3",
//"2   1,1 3,2",
//"3   1,3 2,2",
//"4   5,8",
//"5   4,8",
//);
//
//$data = array(
//"1   2,7 3,9 6,14",
//"2   1,7 3,10    4,15",
//"3   1,9 2,10    4,11    6,2",
//"4   2,15    3,11    5,6",
//"5   4,6 6,9",
//"6   1,14    3,2 5,9"
//);
//
//$data = array(
//"1   2,11    3,6 4,7 5,5",
//"2   9,12",
//"3   2,4 4,8 6,7 9,16",
//"4   7,3",
//"5   4,3 7,4 8,11",
//"6   9,7",
//"7   8,8 10,10",
//"8   10,3",
//"9   8,7",
//"10  9,13",
//);

list($v, $e) = d\load_graph_with_length(file("data/dijkstraData.txt"));
$state = array(
    "v-x"   => $v,
    "x"     => array(),
    "len"   => array(),
    "path"  => $v,
    "e"     => $e
);



//print_r($state);

d\init(1, $state);
while (count($state["v-x"])) {
    $min = 1000000;
    $min_e = 0;
    foreach($state['e'] as $id => $e){
        if ($path = d\crosses_frontier($id, $state)) {
            if ($min > $path) {
                $min = $path;
                $min_e = $id;
            }
        }
    }
    if ($min_e) {
        d\move($min_e, $state);
    } else {
        break;
    }
}

foreach ($state["v-x"] as $v => $t)  {
    $state['x'][$v] = 0;
    $state['len'][$v] = 1000000;
}
ksort($state['len']);
print_r($state['len']);
//print_r($e);
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
