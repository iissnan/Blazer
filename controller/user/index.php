<?php
    session_start();
    require_once("../require.global.php");
    redirect_unless_login("../login.php");
    require_once(MODEL_DIR . "/user.class.php");
    require_once(MODEL_DIR . "/book.class.php");


    $alert_mode = "alert-error";
    $alert_message = "";
    $error = false;

    $view_user = false;
    $view_user_id = !empty($_GET["id"]) ? $_GET["id"] : 0;
    if ($view_user_id !== 0) {
        $user_model = new UserModel();
        $user_result = $user_model->get_item("id", $view_user_id);
        if ($user_result && $user_result->num_rows > 0) {
            $view_user = $user_result->fetch_object();

            isset($_SESSION["user"]) and $user = $_SESSION["user"];
            if (isset($_SESSION["user"]) && $view_user->id == $_SESSION["user"]->id) {
                $is_self = true;
            }
        } else {
            $error = true;
            $alert_mode = "alert-warning";
            $alert_message = "未找到所请求的用户";
        }
    } else {
        $user = $_SESSION["user"];
        $user === false and redirect_unless_login("/login.php");
        $view_user = $user;

        // 标识“这就是你”
        $is_self = true;
    }

    if ($view_user) {

       // 获取由此用户创建的书籍信息
        $book_model = new BookModel();
        $book_result = $book_model->select("*")
                                    ->where("creator='$view_user->id'")
                                    ->execute();
        if ($book_result && $book_result->num_rows > 0) {
            $smarty->assign("books", $book_result);
        }
        $smarty->assign("user", $user);
        $smarty->assign("page_title", htmlspecialchars($user->username));
    } else {
        $smarty->assign("page_title", "未找到用户");
    }

    $smarty->assign("error", $error);
    $smarty->assign("alert_mode", $alert_mode);
    $smarty->assign("alert_message", $alert_message);
    $smarty->assign("is_self", $is_self);
    $smarty->assign("view_user", $view_user);
    $smarty->assign("user", $user);
    $smarty->display("user/index.tpl");

    isset($book_model) and $book_model->release();