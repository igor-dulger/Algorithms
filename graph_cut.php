<?php

function load_graph($data) {
    $vs = $es =array();
    $e_i = 0;
    $e_uniq = array();
    foreach ($data as $id => $string) {
        $list = explode(" ", $string);
        $v_i = array_shift($list);
        Foreach ($list as $v) {
            if (!isset($e_uniq[$v_i."_".$v]) && !isset($e_uniq[$v."_".$v_i])) {
                $es[++$e_i] = array($v_i, $v);
                $e_uniq[$v_i."_".$v] = $e_i;
                $vs[$v_i][]   = $e_i;
            } else {
                $vs[$v_i][]   = (isset($e_uniq[$v_i."_".$v])) ? $e_uniq[$v_i."_".$v] : $e_uniq[$v."_".$v_i];
            }
        }
    }
    return array($vs, $es);
}

$data = array(
    "3 1 2 4",
    "1 2 3" ,
    "2 1 3 4",
    "4 2 3"
);

list ($v, $e) = load_graph($data) ;

print_r(array($v, $e));
?>
