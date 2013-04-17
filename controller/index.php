<?php
    session_start();
    header("Content-Type: text/html; charset=utf-8");
    require_once("../include/auth.php");
    require_once("../include/smarty.php");
    require_once("../include/paginator.class.php");
    require_once("../model/book.class.php");
    require_once("../vendor/recaptchalib.php");

    $book_model = new BookModel();
    $books_total = $book_model->get_total();

    // 分页参数
    $page = !isset($_GET["page"]) ? 1 : $_GET["page"];
    $page_size = 10;
    $paginator = new Paginator($books_total, $page, $page_size);

    // 获取过滤后的$page
    $page = $paginator->getPage();
    $page_total = $paginator->getTotal();


    // 获取多本书籍
    $books_rs = $book_model->get_items($page_size, $page);
    if ($books_rs) {
        $category_model = new TagModel();
        $author_model = new AuthorModel();
        $books = array();
        for($i = 0; $i < $books_rs->num_rows; $i++) {
            $book = $books_rs->fetch_array();

            // 获取作者信息
            $category_result = $category_model->select("*", "categories, books_categories")
                                              ->where("books_categories.book_id=" . $book["id"])
                                              ->where("books_categories.category_id=categories.id")
                                              ->execute();
            if ($category_result) {
                $categories = array();
                for ($j = 0; $j < $category_result->num_rows; $j++) {
                    array_push($categories, $category_result->fetch_object()->name);
                }
                $book["category"] = join(",", $categories);
            }

            // 获取分类信息
            $author_result = $author_model->select("*", "authors, books_authors")
                                          ->where("books_authors.book_id=" . $book["id"])
                                          ->where("books_authors.author_id=authors.id")
                                          ->execute();
            if ($author_result) {
                $authors = array();
                for ($k = 0; $k < $author_result->num_rows; $k++) {
                    array_push($authors, $author_result->fetch_object()->name);
                    $book["author"] = join(",", $authors);
                }
            }
            array_push($books, $book);
        }
    }

    if ($paginator->hasPagination()) {
        $smarty->assign(array(
            "pagination" => true,
            "page_current" => $page,
            "page_total" => $page_total
        ));
    }

    // 获取用户信息
    if (isset($_SESSION["user"])) {
        $smarty->assign("user", $_SESSION["user"]);
    }

    // 若尝试次数大于3次，显示验证码
    if ($_SESSION["login_try_count"] > 3) {
        $public_recaptcha_key = "6LfbAeASAAAAAKGOX1J5uXfYX_QBBGOkoze4WA6H";
        $smarty->assign("recaptcha", recaptcha_get_html($public_recaptcha_key));
    }

    $smarty->assign("total", $books_total);
    $smarty->assign("books", $books);
    $smarty->assign("page_title", "书架");
    $smarty->display("index.tpl");

    $book_model->release();
