<?php
    session_start();
    !isset($_SESSION["user"]) and header("location: /login.php");
    unset($_SESSION["user"]);
    session_destroy();
    setcookie("auth", "", time() - 1);
    require_once("require.global.php");
    $smarty->assign("page_title", "已退出登录");
    $smarty->display("logout.tpl");
