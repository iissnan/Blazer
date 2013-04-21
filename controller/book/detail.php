<?php
    session_start();
    header("Content-type: text/html; charset=utf-8");
    require_once("../require.global.php");

    require_once(MODEL_DIR . "/book.class.php");
    require_once(MODEL_DIR . "/user.class.php");

    // 变量初始化
    $page_title = "未找到书籍";
    $alert_mode = "alert-error";
    $alert_message = "";
    $error = false;
    $show_alert = false;

    // 获取书籍
    $book_id = isset($_GET["id"]) ? $_GET["id"] : false;
    if ($book_id === false) {
        $alert_message = "书籍 id 参数无效";
        $error = true;
    } else {
        $book_model = new BookModel();
        $book_query_result = $book_model->get_item("id", $book_id);
        if ($book_query_result && $book_query_result->num_rows > 0) {
            $book = $book_query_result->fetch_object();
            $page_title = $book->title;

            // 处理封面
            $cover = "/assets/cover/" . (!$book->cover ? "default.png" : $book->cover);
            $book->cover = $cover;

            // 获取作者信息
            $author_query_result = $book_model->select("authors.name", "books_authors, authors, books")
                                                ->where("books_authors.book_id=$book->id")
                                                ->where("books.id=books_authors.book_id")
                                                ->where("books_authors.author_id=authors.id")
                                                ->execute();
            $authors = array();
            if ($author_query_result && $author_query_result->num_rows > 0) {
                while($author = $author_query_result->fetch_object()) {
                    array_push($authors, $author->name);
                }
            }
            $authors = join(", ", $authors);
            $book->author = $authors;

            // 获取分类信息
            $category_query_result = $book_model->select("categories.name", "books, books_categories, categories")
                                                ->where("books_categories.book_id=$book->id")
                                                ->where("books_categories.book_id=books.id")
                                                ->where("books_categories.category_id=categories.id")
                                                ->execute();
            $categories = array();
            if ($category_query_result && $category_query_result->num_rows > 0) {
                while($category = $category_query_result->fetch_object()) {
                    array_push($categories, $category->name);
                }
            }
            //$categories = join(", ", $categories);
            $book->category = $categories;

            $smarty->assign("book", $book);

            if (isset($_GET["code"]) && $_GET["code"] == "1") {
                if (isset($_GET["source"])) {
                    switch ($_GET["source"]) {
                        case "add":
                            $alert_mode = "alert-success";
                            $alert_message = "添加成功";
                            $show_alert = true;
                    }

                }
            }

        } else {
            $alert_message = "未能找到相关书籍";
            $error = true;
        }
    }

    $smarty->assign("error", $error);
    $smarty->assign("show_alert", $show_alert);
    $smarty->assign("alert_mode", $alert_mode);
    $smarty->assign("alert_message", $alert_message);
    $smarty->assign("user", $_SESSION["user"]);
    $smarty->assign("page_title", $page_title);
    $smarty->display("book/detail.tpl");


    isset($book_model) and $book_model->release();