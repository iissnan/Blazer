<?php
    session_start();
    header("Content-Type: text/html; charset=utf-8");
    require_once("../include/auth.php");
    !isLogin() and header("location: ../login.php");

    require_once("../include/smarty.php");
    require_once("../class/book.class.php");
    $Book = new Book();

    // 提交数据
    if (isset($_POST["submitted"]) && $_POST["submitted"] == "yes") {
        $title = $_POST["title"];
        $id = $_POST["id"];
        $author = $_POST["author"];
        $category = $_POST["category"];
        $isbn = $_POST["isbn"];
        if ($_FILES["cover"]["name"] != "") {
            $cover = $_FILES["cover"];
        } else {
            $cover = $_POST["current-cover"];
        }
        $douban_link = $_POST["douban_link"];

        $book = (object)array(
            "id" => $id,
            "title" => $title,
            "author" => $author,
            "isbn" => $isbn,
            "category" => $category,
            "cover" => $cover,
            "douban_link" => $douban_link
        );

        if ($title == "") {
            $alert = "<div class='alert alert-error' id='alert'>标题不能为空</div>";
            $smarty->assign("alert", $alert);
            $smarty->assign("book", $book);
            $smarty->display("admin/edit.tpl");
        } else {
            $result = $Book->update($id, $title, $author, $isbn, $category, $cover, $douban_link);
            echo "<script>location.href='result.php?action=edit&code=" . $result . "';</script>";
        }
    } else {
        // 获取数据
        if (isset($_GET["id"])) {
            $id = (int)$_GET["id"];
            $book = $Book->getItem($id);
            if ($book->num_rows > 0) {
                $book = $book->fetch_object();
                $smarty->assign("book", $book);
                $smarty->display("admin/edit.tpl");
            } else {
                $alert = "<div class='alert alert-error' id='alert'>书籍未找到</div>";
                $smarty->assign("error", true);
                $smarty->assign("alert", $alert);
                $smarty->display("admin/edit.tpl");
            }
        } else {
            $alert = "<div class='alert alert-error' id='alert'>id参数丢失</div>";
            $smarty->assign("error", true);
            $smarty->assign("alert", $alert);
            $smarty->display("admin/edit.tpl");
        }
    }
