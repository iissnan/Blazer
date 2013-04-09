<?php

/**
 * 身份验证
 */

if (!isset($_SESSION["user"])) {
    // Cookie校验
    empty($_COOKIE["bs_identity"]) and header("location: ../login.php");

    require_once("../class/user.class.php");
    $User = new User();
    $identity = explode("|", $_COOKIE["bs_identity"]);
    $user = $User->get($identity[0], $identity[1]);
    if ($user->error != 0) {
        header("location: ../login.php");
    } else {
        $_SESSION["user"] = $user;
    }
}