<?php

/**
 * 身份验证
 *
 * @return boolean
 */
function isLogin() {
    if (!isset($_SESSION["user"])) {
        // 校验cookie
        if (empty($_COOKIE["bs_auth"])) {
            return false;
        }

        // 校验cookie值的有效性
        require_once(dirname(__FILE__) . "/../class/user.class.php");

        $User = new User();
        list($email, $password) = explode("|", $_COOKIE["bs_auth"]);
        $user = $User->get($email, $password);
        if ($user->error != 0) {
            return false;
        }
    }
    return true;
}

