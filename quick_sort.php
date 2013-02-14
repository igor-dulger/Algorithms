<?php
$work = 0;
function swap(&$data, $a, $b){
    $t = $data[$a];
    $data[$a] = $data[$b];
    $data[$b] = $t;
}
function partisionate(&$data, $left, $right){
    global $work;
    $work += ($right - $left) - 1;
    
    $m = $left + ceil(($right - $left)/2) - 1;
//    if (
//        $data[$right-1] < $data[$m] && $data[$left] < $data[$right-1] ||
//        $data[$right-1] > $data[$m] && $data[$left] > $data[$right-1]
//    ) {
//        swap($data, $left, $right-1); //Last as pivot
//    }    
//    if (
//        $data[$left] > $data[$m] && $data[$m] > $data[$right-1] ||
//        $data[$left] < $data[$m] && $data[$m] < $data[$right-1]
//    ) {
//        swap($data, $left, $m); //middle as pivot
//    }   
    
    $pivit = $left;
    $i = $left+1;
    for ($j=$left+1; $j<$right; $j++){
        if ($data[$pivit] > $data[$j] ) {
            swap($data, $i, $j);
            $i++;
        }
    }
    swap($data, $pivit, $i-1);
    return $i-1;
}

function quick_sort(&$data, $left, $right){
    
    if ($right - $left <= 1) return;
    $pivit = partisionate($data, $left, $right);
    quick_sort($data, $left, $pivit);
    quick_sort($data, $pivit+1, $right);
}

quick_sort($data, 0, count($data));
print_r(array($work));
?>

