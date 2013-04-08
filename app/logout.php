<?php
session_start();
unset($_SESSION["user"]);
session_destroy();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>退出登录</title>
    </head>

    <body>
        <p>已退出登录</p>
        <p><a href="login.php">重新登录</a></p>
    </body>
</html>
