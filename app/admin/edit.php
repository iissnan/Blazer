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

        $book = array(
            "title" => $title,
            "isbn" => $isbn,
            "cover" => $cover,
            "douban_link" => $douban_link,
            "updated_at" => date("Y-m-d H:i:s")
        );

        if ($title == "") {
            $book["id"] = $id;
            $book = (object)$book;
            $alert = "<div class='alert alert-error' id='alert'>标题不能为空</div>";
            $smarty->assign("alert", $alert);
            $smarty->assign("book", $book);
            $smarty->display("admin/edit.tpl");
        } else {
            $categories = explode(",", $category);
            $authors = explode(",", $author);
            $Category = new Model("categories");
            $Book_Category = new Model("books_categories");
            $Author = new Model("authors");
            $Book_Author = new Model("books_authors");
            $Book->startTransaction();

            // 更新分类
            foreach($categories as $category) {
                if ($category == "") {
                    $Book_Category->remove("book_id=$id");
                } else {
                     $Category->updateJoin(
                        array("books_categories"),
                        "books_categories.book_id=$id".
                            " AND books_categories.category_id=categories.id ",
                        array("categories.name" => $category)
                    );
                }
            }
            // 更新作者信息
            foreach($authors as $author) {
                if ($author == "") {
                    $Book_Author->remove("book_id=$id");
                } else {
                    $Author->updateJoin(
                        array("books_authors"),
                        "books_authors.book_id=$id" .
                            " AND books_authors.author_id=authors.id ",
                        array("authors.name" => $author)
                    );
                }

            }
            $result = $Book->update("id=" . $id, $book);
            $result and $Book->commit() or $Book->rollback();
            //echo "<script>location.href='result.php?action=edit&code=" . $result . "';</script>";
        }
    } else {
        // 获取数据
        if (isset($_GET["id"])) {
            $id = (int)$_GET["id"];
            $book = $Book->getItem("id", $id);
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
