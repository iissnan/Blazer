<?php
    session_start();
    unset($_SESSION["user"]);
    session_destroy();
    setcookie("auth", "", time() - 1);
    require_once("require.global.php");
    $smarty->assign("page_title", "已退出登录");
    $smarty->display("logout.tpl");
