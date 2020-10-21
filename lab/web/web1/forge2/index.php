<?php

$flag="ITAC{Forging_HTTP_Request_is_boring_:/}";

if (empty($_GET['secret'])) {
    die("secret query not set");
}


if (empty($_POST['user'])) {
    die("user POST data not set");
}

if (empty($_POST['pass'])) {
    die("pass POST data not set");
}

if ($_GET['secret'] !== "ITACSECRET") {
    die("secret query not set to ITACSECRET");
}

if ($_POST['user'] !== "admin") {
    die("user POST data not set to admin");
}
if ($_POST['pass'] !== "P4ssw0rd") {
    die("pass POST data not set to P4ssw0rd");
}

echo $flag;