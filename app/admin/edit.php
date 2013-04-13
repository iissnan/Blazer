<?php
    session_start();
    header("Content-Type: text/html; charset=utf-8");
    require_once("../include/auth.php");
    !isLogin() and header("location: ../login.php");

    require_once("../include/smarty.php");
    require_once("../class/book.class.php");
    $book_model = new BookModel();

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
            "update_at" => date("Y-m-d H:i:s")
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

            $Author = new Model("authors");
            $Book_Author = new Model("books_authors");
            $book_model->startTransaction();


            echo "<p>START 更新分类: </p>";
            // 更新分类
            foreach($categories as $category) {
                $book_model->updateCategory($id, $category);
            }
            echo "<p>END 更新分类 </p>";
            die("aa");

            // 更新作者信息
            foreach($authors as $author) {
                $author = trim($author);
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
            $result = $book_model->update("id=" . $id, $book);
            $result and $book_model->commit() or $book_model->rollback();
            //echo "<script>location.href='result.php?action=edit&code=" . $result . "';</script>";
        }
    } else {
        // 获取数据
        if (isset($_GET["id"])) {
            $id = (int)$_GET["id"];
            $book = $book_model->getItem("id", $id);
            if ($book->num_rows > 0) {
                $book = $book->fetch_object();

                // 获取作者
                $author_model = new Model("authors");
                $authors = "";
                $author_result = $author_model->getJoinItems(
                    array("books_authors"),
                    "books_authors.book_id=$book->id AND authors.id=books_authors.author_id"
                );
                if ($author_result) {
                    $author_numbers = $author_result->num_rows;
                    for ($i = 0; $i < $author_numbers; $i++) {
                        $author = $author_result->fetch_object();
                        $authors = $i == 0 ?
                            $author->name :
                            $authors . ", $author->name";
                    }
                }
                $book->author = $authors;

                // 获取分类
                $category_model = new Model("categories");
                $categories = "";
                $category_result = $category_model->getJoinItems(
                    array("books_categories"),
                    "books_categories.book_id=$book->id AND categories.id=books_categories.category_id"
                );
                if ($category_result) {
                    $category_numbers = $category_result->num_rows;
                    echo $category_numbers;
                    for ($i = 0; $i < $category_numbers; $i++) {
                        $category = $category_result->fetch_object();
                        $categories = $i == 0 ?
                            $category->name :
                            $categories . ", $category->name";
                    }
                }
                $book->category = $categories;

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
