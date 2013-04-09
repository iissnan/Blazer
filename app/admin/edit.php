<?php
    session_start();
    header("Content-Type: text/html; charset=utf-8");
    require_once("verify.php");

    require_once("./config.php");
    require_once("../class/book.class.php");
    $book_instance = new Book();

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
            $error = "<div class='error' id='error'><ul><li>标题不能为空</li></ul></div>";
            $smarty->assign("error", $error);
            $smarty->assign("book", $book);
            $smarty->display("admin/edit.tpl");
        } else {
            $result = $book_instance->update($id, $title, $author, $isbn, $category, $cover, $douban_link);
            echo "<script>location.href='result.php?action=edit&code=" . $result . "';</script>";
        }
    } else {
        // 获取数据
        if (isset($_GET["id"])) {
            $id = (int)$_GET["id"];
            $book = $book_instance->get($id);
            if ($book->num_rows > 0) {
                $book = $book->fetch_object();
                $smarty->assign("book", $book);
                $smarty->display("admin/edit.tpl");
            } else {
                echo "<p>书籍未找到</p>";
                echo "<p><a href='list.php'>返回列表</a></p>";
            } // $book->num_rows
        } else {
            echo "<p>id参数丢失</p>";
        } // isset $_GET["id"]
    }
