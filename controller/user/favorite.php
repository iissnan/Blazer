<?php
    session_start();
    require_once("../../include/auth.php");
    redirect_unless_login("/login.php");

    require_once("../../include/smarty.php");
    $smarty->assign("user", $_SESSION["user"]);
    $smarty->assign("page_title", "我的收藏");
    $smarty->display("user/favorite.tpl");
