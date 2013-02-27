<?php
require "graph.php";
ini_set("memory_limit","4000M");

$data = array(
    "1 5",
    "2 4",
    "3 1",
    "3 2",
    "3 6",
    "4 10",
    "5 3",
    "6 1",
    "6 10",
    "7 8",
    "8 9",
    "8 11",
    "9 3",
    "9 5",
    "9 7",
    "10 2",
    "11 2",
    "11 4",
);

//$data = file("data/SCC.txt");
//$data = file("data/zones.txt");

//print_r($data);
list ($v, $e) = \graph\load_directed_graph($data) ;
//print_r(array($v, $e));
print_r(array(count ($v),count ($e)));
die();

$map = array();
$size = count($v);
$timelife = 0;
$leader = 0;
$result = array();

for ($i=1; $i < $size; $i++) {
    if ($v[$i]['exp'] == false) {
        \graph\dfs_directed($v, $e, $i, 'b');
    }
}

for ($i=1; $i <= $size; $i++) {
    $v[$i]['exp'] = false;
}

//print_r("=============\n");

for ($i=$size; $i > 0; $i--) {
    $leader = $i;
    $result[$i] = 0;
    if ($v[$map[$i]]['exp'] != true) {
        \graph\dfs_directed($v, $e, $map[$i], 'f');
    }
}

foreach ($v as $el) {
    $result[$el['leader']]++;
}
$zones = array_values($result);
rsort($zones);


print_r(array(array_slice($zones, 0, 5)));

?>
