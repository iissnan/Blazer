<?php
    session_start();
    require_once("../../include/auth.php");
    redirect_unless_login("../login.php");
    require_once("../../model/book.class.php");
    require_once("../../include/smarty.php");

    $book_model = new BookModel();
    $book_result = $book_model->select("*")
                                ->where("creator='" . $_SESSION["user"]->id . "'")
                                ->execute();
    if ($book_result && $book_result->num_rows > 0) {
        $smarty->assign("books", $book_result);
    }
    $current_avatar = "/assets/avatar/" . (isset($_SESSION["user"]->avatar) ?
            $_SESSION["user"]->avatar :
            "default.png");
    $smarty->assign("current_avatar", $current_avatar);
    $smarty->assign("page_title", "我的信息");
    $smarty->assign("user", $_SESSION["user"]);
    $smarty->display("user/index.tpl");

    $book_model->release();