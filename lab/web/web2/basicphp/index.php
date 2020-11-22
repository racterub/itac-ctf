<?php

highlight_file(__FILE__);


require_once("flag.php");

if (isset($_GET['input']) && !empty($_GET['input']) && isset($_GET['hi']) && !empty($_GET['hi'])) {
    if ($_GET['input'] === "M4g1c_PHP") {
        if (is_array($_GET['hi']) && count($_GET['hi']) >= 5) {
            die($flag);
        } else {
            die("hi 參數錯惹");
        }
    } else {
        die("input 參數錯惹");
    }
}


