<?php
$inversions = 0;

function concat_merge($a, $b){
    global $inversions;
    $res = array();
//print_r(array($a, $b));
    $a_length = count($a);
    $b_length = count($b);
    $n = $a_length + $b_length;
    $i = $j = 0;
    for ($m=0; $m<$n; $m++){
        if (($i< $a_length && $a[$i] < $b[$j]) || $j >= $b_length) {
            $res[$m] = $a[$i++];
        } else if(($j<$b_length && $a[$i] > $b[$j]) || $i >= $a_length) {
            $res[$m] = $b[$j++];
            $inversions += ($a_length - $i);
        }
    }
    return $res;
}

function concat_sort(&$data, $start, $len){
    $half = ceil($len/2);
    if ($len == 1) return array($data[$start]);
    if ($len == 0) return array();
    $a = concat_sort($data, $start, $half);
    $b = concat_sort($data, $start+$half, $len-$half);
    return concat_merge($a, $b);
}

function simple_test($data) {
    $res = 0;
    $cnt = count($data);
    for ($i=0;$i<$cnt;$i++){
        for ($j=$i+1;$j<$cnt;$j++){
            if ($data[$i] > $data[$j])  
                $res++;
        }
    }
    return $res;
}

print_r(array(time()));

$data = file("IntegerArray.txt");
$data = array();
for ($i=1;$i<=10;$i++){
    $data[] = $i;
}
shuffle($data);

print_r($data);
print_r(count($data));
$sorted = concat_sort($data, 0, count($data) );
print_r(array(time(),$inversions));

print_r(array(simple_test($data)));
print_r(array(time()));


?>
