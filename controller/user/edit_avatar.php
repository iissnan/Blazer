<?php
    session_start();
    require_once("../require.global.php");
    redirect_unless_login("/login.php");
    require_once(MODEL_DIR . "/user.class.php");

    $user = $_SESSION["user"];

    $current_avatar = "/assets/avatar/" . (isset($_SESSION["user"]->avatar) ?
        $_SESSION["user"]->avatar :
        "default.png");

    if (isset($_POST["submit"]) && $_POST["submit"] == "yes") {
        if (isset($_FILES["avatar"])) {
            $upload_avatar = $_FILES["avatar"];
            define("AVATAR_DIR", __DIR__ . "/../assets/avatar/");
            define("MAX_SIZE", 2000000); //2M
            !is_dir(AVATAR_DIR) && mkdir(AVATAR_DIR);
            $allow_mimes = array("image/jpeg", "image/gif", "image/png");

            if (!in_array($upload_avatar["type"], $allow_mimes)) {
                $alert->set_message("允许的图片格式为：JPG, GIF, PNG")->show();
            } else if ($upload_avatar["size"] == 0) {
                $alert->set_message("请选择需要更新的头像图片")->show();
            } else if ($upload_avatar["size"] > MAX_SIZE) {
                $alert->set_message("图片大小超过2M")->show();
            } else {
                // 执行上传
                $filename = md5($upload_avatar["name"]);
                $upload_result = move_uploaded_file(
                    $upload_avatar["tmp_name"],
                    AVATAR_DIR . "/" . $filename
                );

                if (!$upload_result) {
                    $alert->set_message("程序处理上传失败")->show();
                } else {
                    // 更新数据库
                    $user_model = new UserModel();

                    $result = $user_model->update(array("avatar" => $filename))
                                            ->where("email='" . $_SESSION["user"]->email . "'")
                                            ->execute();
                    !$result and $alert->set_message("更新用户数据时出错")->show();
                }
            }

            if ($alert->get_message() == "") {
                $alert->set_mode("pass")->set_message("更新成功")->show();
                $user->avatar = $filename;
                $_SESSION["user"] = $user;
                $current_avatar = "../assets/avatar/" . $filename;
            }
        }
    }

    $smarty->assign("alert", $alert);
    $smarty->assign("current_avatar", $current_avatar);
    $smarty->assign("page_title", "头像设置");
    $smarty->assign("user", $_SESSION["user"]);
    $smarty->display("user/edit_avatar.tpl");

    isset($user_model) and $user_model->release();


    /**
     * 获取Gravatar.com头像
     *
     * @param string $email
     * @param integer $size
     * @param string $default
     * @return string url
     */
    function get_gravatar($email, $size=80, $default="mm") {
        $email = md5(strtolower(trim($email)));
        $url = "http://www.gravatar.com/avatar/" .
            $email .
            "?size=" . $size .
            "&default=" . $default;

        return $url;
    }