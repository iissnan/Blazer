<?php
    session_start();
    require_once("../require.global.php");
    redirect_unless_login("/login.php");
    require_once(MODEL_DIR . "/user.class.php");

    if (isset($_POST["submit"]) && $_POST["submit"] == "yes") {
        $old_password = isset($_POST["old_password"]) ? trim($_POST["old_password"]) : "";
        $new_password = isset($_POST["new_password"]) ? trim($_POST["new_password"]) : "";
        $re_password = isset($_POST["re_password"]) ? trim($_POST["re_password"]) : "";

        $user = $_SESSION["user"];
        if (strlen($old_password) < 7) {
            $alert->set_message("请输入当前密码")->show();
        } else if (strlen($new_password) < 7) {
            $alert->set_message("请输入新密码，至少6位数")->show();
        } else if ($re_password != $new_password) {
            $alert->set_message("新密码两次输入不匹配")->show();
        } else if (sha1($old_password) != $user->password) {
            $alert->set_message("当前密码不正确，请重新输入")->show();
        } else {
            $user_model = new UserModel();
            $update_data = array("password" => sha1($new_password), "update_at" => date("Y-m-d H:i:s"));
            $update_result = $user_model->update($update_data)->where("email='$user->email'")->execute();
            if ($update_result) {
                $alert->set_mode("pass")->set_message("密码已更新，请牢记密码")->show();
                $user->password = sha1($new_password);
                $_SESSION["user"] = $user;
            } else {
                $alert->set_message("服务器在打盹...")->show();
            }
        }
    }

    $smarty->assign("alert", $alert);
    $smarty->assign("user", $_SESSION["user"]);
    $smarty->assign("page_title", "密码设置");
    $smarty->display("user/edit_password.tpl");

    isset($user_model) and $user_model->release();
