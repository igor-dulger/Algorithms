<?php
set_time_limit(3600*5);

function load_graph($data) {
    $vs = $es =array();
    $e_i = 0;
    $e_uniq = array();
    foreach ($data as $id => $string) {
        $list = explode("\t", trim($string));
        $v_i = array_shift($list);
        Foreach ($list as $v) {
            if (!isset($e_uniq[$v_i."_".$v]) && !isset($e_uniq[$v."_".$v_i])) {
                $es[++$e_i] = array($v_i, $v);
                $e_uniq[$v_i."_".$v] = $e_i;
                $vs[$v_i][$e_i] = 1;
            } else {
                $vs[$v_i][((isset($e_uniq[$v_i."_".$v])) ? $e_uniq[$v_i."_".$v] : $e_uniq[$v."_".$v_i])] = 1;
            }
        }
    }
    return array($vs, $es);
}

function minCut($v, $edges) {
    $cnt = count($v);

$reset = 0;
    for ($i=1; $i<=$cnt - 2; $i++) {
        $edge = array_rand($edges);
//print_r(array("Edge" => $edge, "Vert" => $edges[$edge]));
        $l_v = $edges[$edge][0];
        $r_v = $edges[$edge][1];

//$start = microtime(true);
        foreach ($v[$r_v] as $ed_id => $val) {
            if (isset($v[$l_v][$ed_id])) {
                unset($v[$l_v][$ed_id]);
                unset($edges[$ed_id]);
            } else {
                $v[$l_v][$ed_id] = 1;
                if ($edges[$ed_id][0] === $r_v){
                    $edges[$ed_id][0] = $l_v;
                } else if ($edges[$ed_id][1] === $r_v){
                    $edges[$ed_id][1] = $l_v;
                }
            }

        }
//$reset += microtime(true)- $start;

//        unset($v[$r_v]);
//print_r(array($v, $edges));
    }
//print_r(
//    array(
//        "reset" => $reset,
//        "diff_all" => $diff_all,
//        "diff_uniq" => $diff_uniq,
//        "diff_to_unset" => $diff_to_unset,
//        "sum" => $reset+$diff_all+$diff_uniq+$reindex+$diff_to_unset,
//    )
//);
    return count($edges);
}

$data = array(
    "1	2	3" ,
    "2	1	3	4",
    "3	1	2	4",
    "4	2	3"
);
$data = file("kargerMinCut.txt");
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
