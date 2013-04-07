<?php
    session_start();
    header("Content-Type: text/html; charset=utf-8");
    isset($_SESSION["user"]) and header("Location: list.php");
    require_once("class/user.class.php");
    require_once("vendor/smarty/Smarty.class.php");
    $smarty = new Smarty();

    $error = "";
    if (isset($_POST["submitted"]) && $_POST["submitted"] == "yes") {
        $email = trim($_POST["email"]);
        $password = trim($_POST["password"]);
        $re_password = trim($_POST["re-password"]);
        $nickname = trim($_POST["nickname"]);
        $invitation = trim($_POST["invitation"]);

        $isValidate = true;
        if ($email == "" || preg_match("/[-\w\.]+@(?:[a-zA-Z0-9]+\.)*[a-zA-Z0-9]+/", $email)) {
            $isValidate = false;
            $error_message = "<li>登录邮箱有误</li>";
        }
        if ($password == "") {
            $isValidate = false;
            $error_message .= "<li>密码不能为空</li>";
        }
        if ($password != $_POST["re-password"]) {
            $isValidate = false;
            $error_message .= "<li>确认密码不匹配</li>";
        }
        if ($nickname == "") {
            $isValidate = false;
            $error_message .= "<li>昵称不能为空</li>";
        }

        if ($isValidate) {
            $user = new User();
            if ($user->add($email, $password, $nickname)) {
                echo "<script>location.href = 'login.php';</script>";
            } else {
                $error_message = "<li>注册失败，请稍后再试</li>";
                $error = "<div class='error' id='error'><ul>" . $error_message . "</ul></div>";
                $smarty->assign("error", $error);
            }
        } else {
            $error = "<div class='error' id='error'><ul>" . $error_message . "</ul></div>";
            $smarty->assign("error", $error);
            $smarty->assign("email", $email);
            $smarty->assign("password", $password);
            $smarty->assign("re_password", $re_password);
            $smarty->assign("nickname", $nickname);
            $smarty->assign("invitation", $invitation);
        }
    }

    $smarty->display("register.tpl");
