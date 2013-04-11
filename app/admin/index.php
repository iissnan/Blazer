<?php
    session_start();
    require_once("../include/auth.php");
    !isLogin() and header("location: ../login.php");

    require_once("../class/book.class.php");
    require_once("../class/paginator.class.php");
    $Book = new Book();
    $books_total = $Book->total();
    $page = !isset($_GET["page"]) ? 1 : $_GET["page"];
    $page_size = 10;
    $paginator = new Paginator($books_total, $page, $page_size);

    // 获取过滤后的$page
    $page = $paginator->getPage();
    $page_total = $paginator->getTotal();

    // 获取多本书籍
    $books = $Book->getItems("", $page_size, $page);

    require_once("../include/smarty.php");
    if ($paginator->hasPagination()) {
        $smarty->assign(array(
            "pagination" => true,
            "page_current" => $page,
            "page_total" => $page_total
        ));
    }
    $smarty->assign("total", $books_total);
    $smarty->assign("books", $books);
    $smarty->display("admin/list.tpl");