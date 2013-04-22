<?php
    session_start();
    header("Content-Type: text/html; charset=utf-8");
    require_once("require.global.php");
    is_login() and header("location: index.php");

    require_once(MODEL_DIR . "/user.class.php");
    require_once(VENDOR_DIR . "/recaptchalib.php");

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
            $resp = recaptcha_check_answer (RECAPTCHA_PRIVATE,
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
            $user_model = new UserModel();
            $user = $user_model->get($email, $password);
            if ($user->error == 0) {

                // 登录计数++
                $user_model->update(array("times"=>$user->times + 1));
                $_SESSION["user"] = $user;
                $_SESSION["user"]->times = $user->times + 1;

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

    if ($code == "1") {
        $alert_mode = "alert-info";
        $show_alert = true;

        switch($source) {
            case "reg":
                $alert_message = "注册成功，请登录"; break;
            case "install":
                $alert_message = "安装成功，请登录"; break;
            default:
        }
    }

    // 若出现错误或者明确指定显示alert则显示
    if ($error || $show_alert) {
        $alert = "<div class='alert $alert_mode'>$alert_message</div>";
        $smarty->assign("alert", $alert);
    }

    // 若尝试次数大于3次，显示验证码
    if ($_SESSION["login_try_count"] > 3) {
        $smarty->assign("recaptcha", recaptcha_get_html(RECAPTCHA_PUBLIC));
    }

    $smarty->assign("page_title", "帐号登录");
    $smarty->assign("page_class", "login");
    $smarty->display("login.tpl");

    isset($user_model) and $user_model->release();