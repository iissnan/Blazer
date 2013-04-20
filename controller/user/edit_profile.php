<?php
    session_start();
    require_once("../require.global.php");
    redirect_unless_login("/login.php");
    require_once(MODEL_DIR . "/user.class.php");

    $alert_mode = "alert-error";
    $alert_message = "";
    $error = false;

    if (isset($_POST["submitted"]) && $_POST["submitted"] == "yes") {
        $username = isset($_POST["username"]) ? $_POST["username"] : "";
        $signature = isset($_POST["signature"]) ? $_POST["signature"] : "";

        if ($username == "") {
            $error = true;
            $alert_message = "请输入用户名";
            $smarty->assign("signature", $signature);
        } else if(strlen($signature) > 140){
            $error = true;
            $alert_message = "签名长度超过140个字符";
            $smarty->assign("signature", $signature);
        } else {
            $user_model = new UserModel();
            $user_update_result = $user_model->update(array("username" => $username, "signature" => $signature))
                                                ->where("id='" . $_SESSION["user"]->id . "'")
                                                ->execute();
            if ($user_update_result) {
                $alert_mode = "alert-success";
                $alert_message = "更新个人信息成功";
                $_SESSION["user"]->username = $username;
                $_SESSION["user"]->signature = $signature;
            } else {
                $error = true;
                $alert_message = $user_model->get_last_error();
            }
        }
    }
    $alert = "<div class='alert $alert_mode'>$alert_message</div>";
    $error and $smarty->assign("error", true);
    $alert_message != "" and $smarty->assign("alert", $alert);
    $smarty->assign("user", $_SESSION["user"]);
    if (!$error) {
        $smarty->assign("username", $_SESSION["user"]->username);
        $smarty->assign("signature", $_SESSION["user"]->signature);
    }
    $smarty->assign("page_title", "更新我的信息");
    $smarty->display("user/edit_profile.tpl");

    isset($user_model) and $user_model->release();
