<?php
    session_start();
    require_once("../include/auth.php");
    !isLogin() and header("location: ../login.php");

    require_once("../class/book.class.php");
    $Book = new Book();
    $books_total = $Book->total();
    $page = isset($_GET["page"]) ? $_GET["page"] : 1;
    $page_size = 10;

    $books = $Book->getItems("", $page_size, $page);

    require_once("../include/smarty.php");
    if ($books_total > $page_size) {
        $smarty->assign(array(
            "pagination" => true,
            "page_current" => $page,
            "page_total" => ceil($books_total / $page_size)
        ));
    }
    $smarty->assign("total", $books_total);
    $smarty->assign("books", $books);
    $smarty->display("admin/list.tpl");