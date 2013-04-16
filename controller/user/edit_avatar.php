<?php
    session_start();
    require_once("../../include/auth.php");
    redirect_unless_login("/login.php");

    require_once("../../model/user.class.php");
    require_once("../../include/smarty.php");

    $user = $_SESSION["user"];

    // 获取Gravatar.com头像
    function getGravatar($email, $size=80, $default="mm") {
        $email = md5(strtolower(trim($email)));
        $url = "http://www.gravatar.com/avatar/" .
            $email .
            "?size=" . $size .
            "&default=" . $default;

        return $url;
    }


    $smarty->assign("page_title", "头像设置");

    if (isset($_POST["submit"]) && $_POST["submit"] == "yes") {
        if (isset($_FILES["avatar"])) {
            $upload_avatar = $_FILES["avatar"];
            define("AVATAR_DIR", __DIR__ . "/../assets/avatar/");
            define("MAX_SIZE", 2000000); //2M
            if (!is_dir(AVATAR_DIR)) {
                mkdir(AVATAR_DIR);
            }
            $allow_mimes = array("image/jpeg", "image/gif", "image/png");

            $alert_type = "alert-error";
            $alert_message = "";

            // 文件大小校验
            if ($upload_avatar["size"] == 0) {
                $alert_message = "请选择需要更新的头像图片";
            } else if ($upload_avatar["size"] > MAX_SIZE) {
                $alert_message = "图片大小超过2M";
            } else if (!in_array($upload_avatar["type"], $allow_mimes)) {
                // 文件格式校验
                $alert_message = "允许的图片格式为：JPG, GIF, PNG";
            } else {
                // 执行上传
                $filename = md5($upload_avatar["name"]);
                $upload_result = move_uploaded_file(
                    $upload_avatar["tmp_name"],
                    AVATAR_DIR . "/" . $filename
                );

                if (!$upload_result) {
                    $alert = "<div class='alert alert-error'>程序处理上传失败</div>";
                } else {
                    // 更新数据库
                    $user_model = new UserModel();
                    $result = $user_model->update(
                        $_SESSION["user"]->email,
                        array("avatar" => $filename)
                    );
                    !$result and $alert_message = "更新用户数据时出错";
                }
            }

            if ($alert_message == "") {
                $alert_type = "alert-success";
                $alert_message = "更新成功";
                $user->avatar = $filename;
                $_SESSION["user"] = $user;
                $current_avatar = "../assets/avatar/" . $filename;
            }

            $alert = "<div class='alert $alert_type'>" . $alert_message . "</div>";

            $smarty->assign("alert", $alert);
            $smarty->assign("current_avatar", $current_avatar);
            $smarty->assign("user", $_SESSION["user"]);
            $smarty->display("user/edit_avatar.tpl");
        }
    } else {
        $current_avatar = "/assets/avatar/" . (isset($_SESSION["user"]->avatar) ?
            $_SESSION["user"]->avatar :
            "default.png");
        $smarty->assign("current_avatar", $current_avatar);
        $smarty->assign("user", $_SESSION["user"]);
        $smarty->display("user/edit_avatar.tpl");
    }