<?php
    session_start();
    header("Content-Type: text/html; charset=utf-8");
    isset($_SESSION["user"]) and header("Location: list.php");

    require_once("class/user.class.php");
    require_once("vendor/smarty/Smarty.class.php");
    $smarty = new Smarty();

    $error = "";
    if (isset($_POST["submitted"]) && $_POST["submitted"] == "yes") {
        $isValidate = true;
        $email = trim($_POST["email"]);
        $password = trim($_POST["password"]);

        if ($email == "" || !preg_match("/[-\w\.]+@(?:[a-zA-Z0-9]+\.)*[a-zA-Z0-9]+/", $email)) {
            $isValidate = false;
            $error_message = $error_message .  '<li>请输入正确的登录邮箱地址</li>';
        }

        if ($password == "") {
            $isValidate = false;
            $error_message = $error_message . '<li>请输入登录密码</li>';
        }

        if (!$isValidate) {
            $smarty->assign("email", $email);
            $smarty->assign("password", $password);
            $error = "<div class='error' id='error'><ul>$error_message</ul></div>";
        } else {
            $user_instance = new User();
            $user = $user_instance->get($email, $password);
            if ($user->error == 0) {
                $_SESSION["user"] = $user;
                echo "<script>location.href='list.php';</script>";
            } else {
                $smarty->assign("email", $email);
                $smarty->assign("password", $password);
                $error_message = "<li>$user->msg</li>";
                $error = "<div class='error' id='error'><ul>" . $error_message . "</ul></div>";
            }
        }
    }
    $smarty->assign("error", $error);
    $smarty->display("login.tpl");