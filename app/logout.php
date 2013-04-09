<?php
    session_start();
    unset($_SESSION["user"]);
    session_destroy();

    require_once("config.php");
    $smarty->display("logout.tpl");
