<?php
    session_start();
    unset($_SESSION["user"]);
    session_destroy();
    setcookie("bs_identity", "", time() - 1);

    require_once("config.php");
    $smarty->display("logout.tpl");
