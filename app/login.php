<?php
    session_start();
    header("Content-Type: text/html; charset=utf-8");
    require_once("include/auth.php");
    isLogin() and header("location: admin/index.php");

    require_once("include/smarty.php");
    require_once("class/user.class.php");

    $alert = "";
    if (isset($_POST["submitted"]) && $_POST["submitted"] == "yes") {
        $isValidate = true;
        $email = trim($_POST["email"]);
        $password = trim($_POST["password"]);
        $remember = $_POST["remember"];

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
            $alert = "<div class='alert alert-error' id='alert'><ul>$error_message</ul></div>";
        } else {
            $user_instance = new UserModel();
            $user = $user_instance->get($email, $password);
            if ($user->error == 0) {
                $_SESSION["user"] = $user;

                // 自动登录
                if (isset($remember)) {
                    setcookie(
                        "bs_auth",
                        $email . "|" . sha1($password),
                        time() + 14 * 24 * 3600
                    );
                }
                header("location: admin/index.php");
            } else {
                $smarty->assign("email", $email);
                $smarty->assign("password", $password);
                $error_message = "$user->msg";
                $alert = "<div class='alert alert-error' id='alert'>" .
                    $error_message . "</div>";
            }
        }
    }

    $smarty->assign("alert", $alert);

    $source = $_GET["s"];
    $code = $_GET["code"];

    if (isset($source) && $source == "reg") {
        if ($code == "1") {
            $alert = "<div class='alert alert-success' id='alert'>注册成功，请登录</div>";
            $smarty->assign("alert", $alert);
        }
    }

    $smarty->display("login.tpl");