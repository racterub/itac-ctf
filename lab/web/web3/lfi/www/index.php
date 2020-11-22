<?php
session_start();

include("flag.php"); // This includes our flag1

if (isset($_SERVER['HTTP_USER_AGENT']) && !empty($_SERVER['HTTP_USER_AGENT'])) {
    $_SESSION['UA'] = $_SERVER['HTTP_USER_AGENT'];
}

if (isset($_GET['p']) && !empty($_GET['p'])) {
    @include($_GET['p']);
} else {
    @include("base.php");
}
