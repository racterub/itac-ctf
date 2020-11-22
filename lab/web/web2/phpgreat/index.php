<?php

require_once("flag.php");

highlight_file(__FILE__);

$target = "QNKCDZO";

if (isset($_GET['input']) && !empty($_GET['input']) && !is_array($_GET['input'])) {
    if (substr($_GET['input'], 0, 4) == "ITAC") {
        if (@md5($_GET['input']) == @md5($target)) {
            die($flag);
        } else {
            die("HASH 錯ㄌ");
        }
    } else {
        die("input 前面要是 ITAC");
    }
}

