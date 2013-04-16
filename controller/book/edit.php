<?php
    session_start();
    header("Content-Type: text/html; charset=utf-8");
    require_once("../../include/auth.php");
    redirect_unless_login("../login.php");

    require_once("../../include/smarty.php");
    require_once("../../model/book.class.php");
    $book_model = new BookModel();

    $smarty->assign("page_title", "编辑书籍");
    $smarty->assign("user", $_SESSION["user"]);

    // 提交数据
    if (isset($_POST["submitted"]) && $_POST["submitted"] == "yes") {
        $title = $_POST["title"];
        $id = $_POST["id"];
        $author = $_POST["author"];
        $intro = $_POST["intro"];
        $pages = $_POST["pages"];
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
            "intro" => $intro,
            "pages" => $pages,
            "douban_link" => $douban_link,
            "update_at" => date("Y-m-d H:i:s")
        );

        if ($title == "") {
            $book["id"] = $id;
            $book = (object)$book;
            $alert = "<div class='alert alert-error' id='alert'>标题不能为空</div>";
            $smarty->assign("alert", $alert);
            $smarty->assign("book", $book);
            $smarty->display("book/edit.tpl");
        } else {
            $result = $book_model->update("id=" . $id, $book);

            if ($result) {
                $book_model->update_category($id, $category);
                $book_model->update_author($id, $author);
                echo "<script>location.href='result.php?action=edit&code=" . $result . "';</script>";
            } else {
                $alert = "<div class='alert alert-error' id='alert'>更新失败</div>";
                $smarty->assign("alert", $alert);
                $smarty->display("book/edit.tpl");
            }
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
                    for ($i = 0; $i < $category_numbers; $i++) {
                        $category = $category_result->fetch_object();
                        $categories = $i == 0 ?
                            $category->name :
                            $categories . ", $category->name";
                    }
                }
                $book->category = $categories;

                $smarty->assign("book", $book);
                $smarty->display("book/edit.tpl");
            } else {
                $alert = "<div class='alert alert-error' id='alert'>书籍未找到</div>";
                $smarty->assign("error", true);
                $smarty->assign("alert", $alert);
                $smarty->display("book/edit.tpl");
            }
        } else {
            $alert = "<div class='alert alert-error' id='alert'>id参数丢失</div>";
            $smarty->assign("error", true);
            $smarty->assign("alert", $alert);
            $smarty->display("book/edit.tpl");
        }
    }
