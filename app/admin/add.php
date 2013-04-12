<?php
    session_start();
    header("Content-Type: text/html; charset=utf-8");
    require_once("../include/auth.php");
    !isLogin() and header("location: ../login.php");

    require_once("../include/smarty.php");
    require_once("../class/model.class.php");
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
            $alert = "<div class='alert alert-error' id='alert'>请输入标题</div>";
            $smarty->assign("alert", $alert);
            $smarty->assign(array(
                "title" => $title,
                "author" => $author,
                "isbn" => $isbn,
                "douban_link" => $douban_link,
                "category" => $category
            ));
            $smarty->display("admin/add.tpl");
        } else {
            $Book = new Book("books");
            $book_data = array(
                "title" => $title,
                "isbn" => $isbn,
                "cover" => $cover,
                "douban_link" => $douban_link,
                "created_at" => date("Y-m-d H:i:s")
            );

            $Book->startTransaction();
            $result = $Book->add($book_data);
            $book_id = $Book->dbc->db->insert_id;

            // 分类处理
            $categories = explode(",", $category);
            $Category = new Model("categories");
            $Book_Category = new Model("books_categories");
            foreach($categories as $category) {
                $result = $Category->add(array("name" => $category));
                $category_id = $Category->dbc->db->insert_id;
                $Book_Category->add(array("book_id" => $book_id, "category_id" => $category_id));
            }

            // 作者处理
            $authors = explode(",", $author);
            $Author = new Model("authors");
            $Book_Author = new Model("books_authors");
            foreach($authors as $author) {
                $result = $Author->add(array("name" => $author));
                $author_id = $Author->dbc->db->insert_id;
                $Book_Author->add(array("book_id" => $book_id, "author_id" => $author_id));
            }
            $result and $Book->commit() or $Book->rollback();
            echo "<script>location.href = 'result.php?action=add&code=" . $result . "';</script>";
        }
    } else {
        $smarty->display("admin/add.tpl");
    }