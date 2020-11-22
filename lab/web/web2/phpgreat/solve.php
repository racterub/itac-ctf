<?php

$target = "QNKCDZO";

for ($i = 0; $i<10000000000000; $i++) {
    echo $i."\n";
    $tmp = "ITAC".$i;
    if (md5($tmp) == md5($target)) {
        echo $tmp;
        echo "\n";
        echo md5($tmp);
        echo "\n";
        exit();
    }
}


