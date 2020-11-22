<?php

require_once("flag.php");

if (isset($_GET['source'])) {
    highlight_file(__FILE__);
    exit();
}

$connection = new PDO('mysql:host=db;dbname=login;charset=utf8mb4', 'itac', '174c_v3ry_L0n9_p4ZZW0rd_L0L');

$getFlag = false;


function safe_filter($str)
{
    $strl = strtolower($str);
    if (strstr($strl, '1=1') || strstr($strl, 'drop') ||
        strstr($strl, 'update') || strstr($strl, 'delete') ||
        strstr($strl, ' ')
    ) {
        return '';
    } else {
        return $str;
    }
}


if (isset($_POST['user']) || isset($_POST['pass'])) {
    $sql = "SELECT id FROM users WHERE username='".
        safe_filter($_POST['user']).
        "' AND password='".
        safe_filter($_POST['pass'])."';";

    $query = $connection->query($sql);
    if ($query) {
        $result = $query->fetch();
        if ($result) {
            $getFlag = true;
        } else {
            $warning = "Login Failed";
        }
    } else {
        $warning = "Login Failed";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>ITAC | Login As Admin Advanced</title>
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
                <?php if ($sql) : ?>
                <div class="ts info message">
                    <div class="header">你的 SQL 語法：<?php echo $sql; ?></div>
                </div>
                <?php endif; ?>
                <div class="ts info message">
                    <div class="header">原始碼：<a href="?source">Source</a></div>
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
