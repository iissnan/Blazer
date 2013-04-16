<?php
    session_start();
    require_once("../include/auth.php");
    redirect_unless_login("../login.php");

    require_once("../class/user.class.php");
    require_once("../include/smarty.php");
    $smarty->assign("page_title", "密码设置");

    if (isset($_POST["submit"]) && $_POST["submit"] == "yes") {
        $old_password = isset($_POST["old_password"]) ? trim($_POST["old_password"]) : "";
        $new_password = isset($_POST["new_password"]) ? trim($_POST["new_password"]) : "";
        $re_password = isset($_POST["re_password"]) ? trim($_POST["re_password"]) : "";

        $user = $_SESSION["user"];
        $alert_type = "alert-error";
        $alert_message = "";
        if (strlen($old_password) < 7) {
            $alert_message = "请输入当前密码，至少6位数";
        } else if (strlen($new_password) < 7) {
            $alert_message = "请输入新密码，至少6位数";
        } else if ($re_password != $new_password) {
            $alert_message = "确认密码与新密码不匹配";
        } else if (sha1($old_password) != $user->password) {
            $alert_message = "当前密码不正确，请重新输入";
        } else {
            $user_model = new UserModel();
            $update_result = $user_model->update(
                $user->email,
                array("password" => sha1($new_password), "update_at" => date("Y-m-d H:i:s"))
            );
            if ($update_result) {
                $alert_type = "alert-success";
                $alert_message = "密码已更新，请牢记密码";
                $user->password = sha1($new_password);
                $_SESSION["user"] = $user;
            } else {
                $alert_message = "服务器在打盹...";
            }
        }

        $alert = "<div class='alert $alert_type'>$alert_message</div>";
        $smarty->assign("alert", $alert);
        $smarty->assign("user", $_SESSION["user"]);
        $smarty->display("user/edit_password.tpl");
    } else {
        $smarty->assign("user", $_SESSION["user"]);
        $smarty->display("user/edit_password.tpl");
    }
