<?php
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    die("ITAC{HTTP_REQUEST_CAN_BE_FORGED}");
} else if ($_SERVER['REQUEST_METHOD'] !== "OPTIONS") {
    header("HTTP/1.1 405 Method Not Allowed");
    die("錯誤的 HTTP 請求方式 :D");
} else {
    header("allow: POST");
    die("錯誤的 HTTP 請求方式 :D");
}


