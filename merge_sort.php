<?php

function concat_merge($a, $b){
    $res = array();
//print_r(array($a, $b));
    $a_length = count($a);
    $b_length = count($b);
    $n = $a_length + $b_length;
    $i = $j = 0;
    for ($m=0; $m<$n; $m++){
        if ($j >= $b_length || ($i< $a_length && $a[$i] < $b[$j])) {
            $res[$m] = $a[$i++];
        } else if($i >= $a_length || ($j<$b_length && $a[$i] > $b[$j])) {
            $res[$m] = $b[$j++];
        }
    }
    return $res;
}

function concat_sort(&$data, $start, $len){
    if ($len <= 1) return array_slice ($data, $start, $len);
    $a = concat_sort($data, $start, ceil($len/2));
    $b = concat_sort($data, $start+ceil($len/2), $len-ceil($len/2));
    return concat_merge($a, $b);
}

$sorted = concat_sort($data, 0, count($data));
print_r($sorted);
?>
