<?php
require "graph.php";

$data = array(
    "1	2	3" ,
    "2	1	3	4",
    "3	1	2	4",
    "4	2	3"
);

$data = file("dijkstraData.txt");

//print_r($data);
list ($v, $e) = load_graph($data) ;
//print_r(array($v, $e));

//bfs_explore($v, $e, 1);

dfs_explore($v, $e, 1, "");


print_r($v);

?>
