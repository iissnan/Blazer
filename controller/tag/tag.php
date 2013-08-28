<?php
    session_start();
    require("../require.global.php");
    require(MODEL_DIR . "/book.class.php");

    isset($_SESSION["user"]) and $user = $_SESSION["user"];

    $tag_name = isset($_GET["tagname"]) ? $_GET["tagname"] : "";

    if (!empty($tag_name)) {

        // 获取类别信息
        $book_model = new BookModel();
        $book_query = $book_model->select("books.*", "books, categories, books_categories")
                                    ->where("books.id = books_categories.book_id")
                                    ->where("categories.id = books_categories.category_id")
                                    ->where("categories.name='" . $book_model->escape($tag_name). "'")
                                    ->order_by("books.id")
                                    ->limit(10)
                                    ->execute();

        if ($book_query && $book_query->num_rows > 0) {
            $smarty->assign("books", $book_query);
        } else{
            $alert->set_mode("info")
                ->set_message("未找到与 {<strong>" . htmlspecialchars($tag_name). "</strong>} 相关的书籍")
                ->show();
        }

    } else {
        $alert->set_message("标签参数无效");
    }

    $smarty->assign("alert", $alert);
    $smarty->assign("tag_name", $tag_name);
    $smarty->assign("user", $user);
    $smarty->assign("page_title", "图书标签:" . htmlspecialchars($tag_name));
    $smarty->display("tag/tag.tpl");

    isset($book_model) and $book_model->release();
