<?php
    session_start();
    require_once("../../include/auth.php");
    redirect_unless_login("../login.php");

    require_once("../../include/smarty.php");
    $smarty->assign("page_title", "我的信息");
    $smarty->assign("user", $_SESSION["user"]);
    $smarty->display("user/index.tpl");

