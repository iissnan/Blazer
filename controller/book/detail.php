<?php
    session_start();
    header("Content-type: text/html; charset=utf-8");
    require_once("../../include/auth.php");

    require_once("../../include/smarty.php");
    require_once("../../model/book.class.php");
    require_once("../../model/user.class.php");

    // 变量初始化
    $page_title = "未找到书籍";
    $alert_mode = "alert-error";
    $alert_message = "";
    $error = false;

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
                $authors_raw = $author_query_result->fetch_all();
                foreach ($authors_raw as $author) {
                    array_push($authors, $author[0]);
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
                $categories_raw = $category_query_result->fetch_all();
                foreach ($categories_raw as $category) {
                    array_push($categories, $category[0]);
                }
            }
            $categories = join(", ", $categories);
            $book->category = $categories;

            $smarty->assign("book", $book);
        } else {
            $alert_message = "未能找到相关书籍";
            $error = true;
        }
    }

    $alert = "<div class='alert $alert_mode'>$alert_message</div>";
    $error and $smarty->assign("alert", $alert);
    $smarty->assign("error", $error);
    $smarty->assign("user", $_SESSION["user"]);
    $smarty->assign("page_title", $page_title);
    $smarty->display("book/detail.tpl");


    isset($book_model) and $book_model->release();