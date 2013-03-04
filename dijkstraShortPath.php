<?php
require "graph.php";

use graph\dijkstra as d;

$data = array(
"1   2,10    4,30    5,100",
"2   3,50",
"3   5,10",
"4   3,20    5,60",
"5    ",
);

list($v, $e) = d\load_graph_with_length($data);
$state = array(
    "v-x"   => $v,
    "x"     => array(),
    "len"   => array(),
    "path"  => array(),
    "e"     => $e
);



print_r($state);

d\init(1, $state);
while (count($state["v_x"])) {
    $min = 9999999999;
    $min_e = 0;
    foreach($state['e'] as $id => $e){
        if ($path = d\crosses_frontier($e, $state)) {
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

print_r($state);
//print_r($e);
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
