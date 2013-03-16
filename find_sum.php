<?php

foreach ($data as $el){
    $hash[$el] = 0;
}
$result = 0;

for ($t=2500; $t<=4000; $t++) {
    foreach (array_keys($hash) as $i){
        if (isset($hash[$t - $i]) && $i != $t-$i) {
            print_r("$t = $i + ". ($t - $i) . "\n");
            $result++;
            break;
        }
    }
}
print_r($result);
?>