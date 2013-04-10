<?php
    session_start();
    header("Content-Type: text/html; charset=utf-8");
    require_once("auth.php");

    require_once("smarty.php");
    require_once("../class/book.class.php");

    if (isset($_POST["submitted"]) && $_POST["submitted"] == "yes") {
        $title = trim($_POST["title"]);
        $author = trim($_POST["author"]);
        $isbn = trim($_POST["isbn"]);
        $category = trim($_POST["category"]);
        $douban_link = trim($_POST["douban_link"]);
        $cover = $_FILES["cover"];

        // title为必需值
        if ($title == "") {
            $error = "<div class='error' id='error'><ul><li>请输入标题</li></ul></div>";
            $smarty->assign("error", $error);
            $smarty->assign(array(
                "title" => $title,
                "author" => $author,
                "isbn" => $isbn,
                "douban_link" => $douban_link,
                "category" => $category
            ));
            $smarty->display("admin/add.tpl");
        } else {
            $Book = new Book();
            $result = $Book->add($title, $author, $isbn, $cover, $category, $douban_link);
            echo "<script>location.href = 'result.php?action=add&code=" . $result . "';</script>";
        }
    } else {
        $smarty->display("admin/add.tpl");
    }