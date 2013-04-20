<?php
    session_start();
    require_once("../require.global.php");
    redirect_unless_login("/login.php");

    $smarty->assign("user", $_SESSION["user"]);
    $smarty->assign("page_title", "我的收藏");
    $smarty->display("user/favorite.tpl");
