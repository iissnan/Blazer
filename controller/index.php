<?php
    session_start();
    header("Content-Type: text/html; charset=utf-8");
    require_once("require.global.php");
    require_once(FUNCTION_DIR . "/paginator.class.php");
    require_once(MODEL_DIR . "/book.class.php");
    require_once(VENDOR_DIR . "/recaptchalib.php");

    $book_model = new BookModel();
    $books_total = $book_model->get_total();  // +1 DB Query

    // 分页参数
    $page = !isset($_GET["page"]) ? 1 : $_GET["page"];
    $page_size = 10;
    $paginator = new Paginator($books_total, $page, $page_size);

    // 获取过滤后的$page
    $page = $paginator->getPage();
    $page_total = $paginator->getTotal();

    // 获取多本书籍
    $books_rs = $book_model->get_items($page_size, $page);  // +1 DB Query
    if ($books_rs and $books_rs->num_rows > 0) {
        $smarty->assign("books", $books_rs);
    }

    if ($paginator->hasPagination()) {
        $smarty->assign(array(
            "pagination" => true,
            "page_current" => $page,
            "page_total" => $page_total
        ));
    }

    isset($_SESSION["user"]) and $smarty->assign("user", $_SESSION["user"]);

    // 若尝试次数大于3次，显示验证码
    if ($_SESSION["login_try_count"] > 3) {
        $smarty->assign("recaptcha", recaptcha_get_html(RECAPTCHA_PUBLIC));
    }

    $smarty->assign("total", $books_total);
    $smarty->assign("page_title", "书籍一览");
    $smarty->display("index.tpl");

    $book_model->release();
