<?php
include "heap.php";

$hh = new Heap\Heap(array());
$hl = new Heap\Heap(array(), "max");
$count = count($data);

$result = 0;

for ($i=0; $i<$count; $i++) {
    $el = $data[$i];
    if ($hl->getSize() == 0){
        $hl->insert($el);
    } else {
        if ($hl->getTop() >= $el) {
            $hl->insert($el);
        } else {
            $hh->insert($el);          
        }
    }
    if ($hl->getSize() - $hh->getSize() > 1) {
        $hh->insert($hl->extractTop());
    } else if ($hh->getSize() - $hl->getSize() > 1) {
        $hl->insert($hh->extractTop());
    }
    
    if (($i+1) % 2 == 0) {
        $m = $hl->getTop();
    } else {
        $m = ($hl->getSize() > $hh->getSize()) ? $hl->getTop() : $hh->getTop();
    }
    $result += $m;
//print_r(array("i" => $i+1, "el" => $el, "m" => $m, "hl" => $hl->getSize(), "hh" => $hh->getSize()));    
//print("\n HL");    
//print($hl);
//print("\n HH");
//print($hh);  
}
print("Result ". ($result % 10000));
?>