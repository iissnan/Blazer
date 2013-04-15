<?php
    session_start();
    header("Content-Type: text/html; charset=utf-8");
    require_once("include/auth.php");
    is_login() and header("location: index.php");

    require_once("include/smarty.php");
    require_once("class/user.class.php");

    $alert = "";
    if (isset($_POST["submitted"]) && $_POST["submitted"] == "yes") {
        $email = trim($_POST["email"]);
        $password = trim($_POST["password"]);
        $re_password = trim($_POST["re-password"]);
        $nickname = trim($_POST["nickname"]);
        $invitation = trim($_POST["invitation"]);

        $isValidate = true;
        if ($nickname == "") {
            $isValidate = false;
            $error_message .= "昵称不能为空";
        } else if ($email == "" || !preg_match("/[-\w\.]+@(?:[a-zA-Z0-9]+\.)*[a-zA-Z0-9]+/", $email)) {
            $isValidate = false;
            $error_message = "登录邮箱有误";
        } else if ($password == "") {
            $isValidate = false;
            $error_message .= "密码不能为空";
        } else if ($password != $_POST["re-password"]) {
            $isValidate = false;
            $error_message .= "确认密码不匹配";
        } else if ($invitation == "") {
            $isValidate = false;
            $error_message = "请输入邀请码";
        }

        if ($isValidate) {
            $user = new UserModel();
            $result = $user->add(array($email, $password, $nickname, $invitation));
            if ($result) {
                header("location: login.php?s=reg&code=1");
            } else {
                $error_message = "注册失败，请稍后再试";
                $alert = "<div class='alert alert-error' id='alert'>" .
                    $error_message . "</div>";
                $smarty->assign("alert", $alert);
            }
        } else {
            $alert = "<div class='alert alert-error' id='alert'>" .
                $error_message . "</div>";
            $smarty->assign("alert", $alert);
            $smarty->assign("email", $email);
            $smarty->assign("password", $password);
            $smarty->assign("re_password", $re_password);
            $smarty->assign("nickname", $nickname);
            $smarty->assign("invitation", $invitation);
        }
    }

    $smarty->display("register.tpl");
