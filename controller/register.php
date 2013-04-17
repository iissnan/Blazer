<?php
    session_start();
    header("Content-Type: text/html; charset=utf-8");
    require_once("../include/auth.php");
    is_login() and header("location: index.php");

    require_once("../include/smarty.php");
    require_once("../model/user.class.php");
    require_once("../model/invitation.class.php");

    $alert_mode = "alert-error";
    $alert_message = "";
    $error = false;

    if (isset($_POST["submitted"]) && $_POST["submitted"] == "yes") {
        $email = isset($_POST["email"]) ? trim($_POST["email"]) : "";
        $password = isset($_POST["password"]) ? trim($_POST["password"]) : "";
        $re_password = isset($_POST["re-password"]) ? trim($_POST["re-password"]) : "";
        $username = isset($_POST["username"]) ? trim($_POST["username"]) : "";
        $invitation = isset($_POST["username"]) ? trim($_POST["invitation"]) : "";

        if ($username == "") {
            $error = true;
            $alert_message = "用户名不能为空";
        } else if (!preg_match("/[-\w\.]+@(?:[a-zA-Z0-9]+\.)*[a-zA-Z0-9]+/", $email)) {
            $error = true;
            $alert_message = "登录邮箱不正确";
        } else if (!preg_match("/[-_a-zA-Z0-9\.#,]{6,}/", $password)) {
            $error = true;
            $alert_message = "登录密码不正确";
        } else if ($password != $re_password) {
            $error = true;
            $alert_message = "确认密码不匹配";
        } else if ($invitation == "") {
            $error = true;
            $alert_message = "请输入邀请码";
        }

        if (!$error) {
            $user_model = new UserModel();
            $result = $user_model->add(array($email, $password, $username, $invitation));
            if ($result) {

                // 生成此用户的邀请码
                $user_id = $user_model->get_last_id();
                $invitation_model = new InvitationModel();
                $new_invitation = array("value" => uniqid(), "user_id" => $user_id);
                $invitation_model->insert($new_invitation)->execute();

                header("location: login.php?s=reg&code=1");
            } else {
                $error = true;
                $alert_message = "注册失败了，服务器在开小差...:<br />" . $user->get_last_error();
            }
        } else {
            $smarty->assign("email", $email);
            $smarty->assign("username", $username);
            $smarty->assign("invitation", $invitation);
        }
    }

    if ($error) {
        $alert = "<div class='alert $alert_mode' id='alert'>$alert_message</div>";
        $smarty->assign("alert", $alert);
    }

    $smarty->display("register.tpl");

    isset($user_model) and $user_model->release();