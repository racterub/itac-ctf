<?php

require_once("flag.php");

$username = "admin";
$password = "v3rY_l0NG_p422w0RD_7h47_N0_0N3_c4n_gu355_17_R1gh7_XD";

if (isset($_POST['user']) && isset($_POST['pass'])) {
    if ($_POST['user'] === $username && $_POST['pass'] === $password) {
        $getFlag = true;
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
            Admin Login
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
