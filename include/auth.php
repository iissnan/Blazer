<?php

/**
 * 身份验证
 *
 * @return boolean
 */
function is_login() {
    if (!isset($_SESSION["user"])) {
        // 校验cookie
        if (empty($_COOKIE["auth"])) {
            return false;
        }

        // 校验cookie值的有效性
        require_once(__DIR__ . "/../model/user.class.php");

        $user_model = new UserModel();
        list($email, $password) = explode("|", $_COOKIE["bs_auth"]);
        $user = $user_model->get($email, $password);
        if ($user->error != 0) {
            return false;
        }
    }
    return true;
}

/**
 * 未登录时跳转$redirect_url
 *
 * @param string $redirect_url
 */
function redirect_unless_login($redirect_url) {
    !is_login() and header("location: $redirect_url");
}
