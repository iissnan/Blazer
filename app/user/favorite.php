<?php
    session_start();
    require_once("../include/auth.php");
    redirect_unless_login("../login.php");

    require_once("../include/smarty.php");
    $smarty->display("user/favorite.tpl");
