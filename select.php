<?php
$work = 0;
function swap(&$data, $a, $b){
    $t = $data[$a];
    $data[$a] = $data[$b];
    $data[$b] = $t;
}

function partitionate(&$data, $left, $right){
    global $work;
    $work += ($right - $left) - 1;
    $pivit = mt_rand($left, $right-1);
    swap($data, $left, $pivit);

    $pivit = $left;
    $i = $left+1;
    for ($j=$left+1; $j<$right; $j++){
        if ($data[$pivit] > $data[$j] ) {
            swap($data, $i, $j);
            $i++;
        }
    }
    swap($data, $pivit, $i-1);
    return $i-1-$left;
}

function rselect(&$data, $left, $right, $target){
    global $work;

//print_r(array("left" => $left, "right" => $right, "target" => $target, "data" => $data));

    if ($right == $left+1) return $data[$left];

    $pivit = partitionate($data, $left, $right);

    if ($pivit == $target) return $data[$left+$pivit];

    if ($pivit > $target) {
        return rselect($data, $left, $left+$pivit, $target);
    }

    if ($pivit < $target) {
        return rselect($data, $left+$pivit+1, $right, $target-$pivit-1);
    }
}

$res = rselect($data, 0, count($data), 44);
print_r(array($res, $work));

?>

