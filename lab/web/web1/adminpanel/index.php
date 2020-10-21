<?php

require_once("flag.php");

if (isset($_GET['source'])) {
    highlight_file(__FILE__);
    exit();
}


// IP Detection
if (!empty($_SERVER['HTTP_VIA'])) {
    $ip = $_SERVER['HTTP_VIA'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}


if (isset($_POST['user']) && isset($_POST['pass'])) {
    if ($_POST['user'] === "admin" && $_POST['pass'] === "admin") {
        if ($ip != "127.0.0.1") {
            $warning = "Admin panel 只接受從 127.0.0.1 來的連線";
        } else {
            $getFlag = true;
        }
    } else {
        $warning = "錯誤的帳號或密碼";
    }
}


?>
<!DOCTYPE html>
<html>
<head>
    <title>ITAC | HTTP Forge</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tocas-ui/2.3.3/tocas.css">
</head>
<body>
    <br/>
    <br/>
    <div class="ts very narrow container">
        <h1 class="ts center aligned header">
            Login
        </h1>
        <div class="ts hidden divider"></div>
        <div class="ts center aligned secondary segment">
            <?php if ($getFlag) : ?>
                <div class="ts info message">
                    <div class="header"><?= $flag ?></div>
                </div>
            <?php else : ?>
            <form class="ts form" action="<?= htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
                <?php if ($warning) : ?>
                    <div class="ts warning message">
                        <div class="header"><?= $warning ?></div>
                    </div>
                <?php endif; ?>
                <div class="ts info message">
                    <div class="header">使用 <code>admin/admin</code> 登入</div>
                </div>
                <div class="field">
                    <label>Username: </label>
                    <input type="text" name="user">
                </div>
                <div class="field">
                    <label>Password: </label>
                    <input type="text" name="pass">
                </div>
                <button class="ts button" type="submit" value="Submit">Login</button>
            </form>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
