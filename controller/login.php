<?php
    session_start();
    header("Content-Type: text/html; charset=utf-8");
    require_once("../include/auth.php");
    is_login() and header("location: index.php");

    require_once("../include/smarty.php");
    require_once("../model/user.class.php");
    require_once("../vendor/recaptchalib.php");

    $alert_mode = "alert-error";
    $alert_message = "";
    $error = false;

    if (isset($_POST["submitted"]) && $_POST["submitted"] == "yes") {
        $email = isset($_POST["email"]) ? trim($_POST["email"]) : "";
        $password = isset($_POST["password"]) ? trim($_POST["password"]) : "";
        $remember = $_POST["remember"];

        // 登录尝试统计，超三次后提示验证码
        $_SESSION["login_try_count"] = isset($_SESSION["login_try_count"]) ?
            $_SESSION["login_try_count"] + 1 :
            1;

        $smarty->assign("email", $email);

        // 校验验证码
        if ($_SESSION["login_try_count"] > 3) {

            // recaptcha 私有密钥
            $recaptcha_private_key = "";
            $resp = recaptcha_check_answer ($recaptcha_private_key,
                $_SERVER["REMOTE_ADDR"],
                $_POST["recaptcha_challenge_field"],
                $_POST["recaptcha_response_field"]);

            if (!$resp->is_valid) {
                $error = true;
                $alert_message = "验证码不正确";
            }
        }
        if (!$error && !preg_match("/[-\w\.]+@(?:[a-zA-Z0-9]+\.)*[a-zA-Z0-9]+/", $email)) {
            $error = true;
            $alert_message = $alert_message .  '请输入正确的登录邮箱地址';
        } else if (!preg_match("/[-_a-zA-Z0-9\.,#]{6,}/", $password)) {
            // 密码至少6位，并且仅包含: - _ , # . 字母 数字
            $error = true;
            $alert_message = $alert_message . '登录密码不正确';
        }

        if (!$error) {
            $user_instance = new UserModel();
            $user = $user_instance->get($email, $password);
            if ($user->error == 0) {
                $_SESSION["user"] = $user;

                // 清除登录尝试统计
                unset($_SESSION["login_try_count"]);

                // 自动登录
                if (isset($remember)) {
                    setcookie(
                        "auth",
                        $email . "|" . sha1($password),
                        time() + 14 * 24 * 3600
                    );
                }
                header("location: index.php");
            } else {
                $error = true;
                $alert_message = $user->msg;
            }
        }
    }

    // 来源检测
    $source = isset($_GET["s"]) ? $_GET["s"] : "";
    $code = isset($_GET["code"]) ? $_GET["code"] : "0";

    if ($source == "reg" && $code == "1") {
        $alert_mode = "alert-info";
        $alert_message = "注册成功，请登录";
        $show_alert = true;
    }

    // 若出现错误或者明确指定显示alert则显示
    if ($error || $show_alert) {
        $alert = "<div class='alert $alert_mode'>$alert_message</div>";
        $smarty->assign("alert", $alert);
    }

    // 若尝试次数大于3次，显示验证码
    if ($_SESSION["login_try_count"] > 3) {
        $public_recaptcha_key = "6LfbAeASAAAAAKGOX1J5uXfYX_QBBGOkoze4WA6H";
        $smarty->assign("recaptcha", recaptcha_get_html($public_recaptcha_key));
    }

    $smarty->display("login.tpl");