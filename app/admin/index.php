<?php
    session_start();
    require_once("../include/auth.php");
    !isLogin() and header("location: ../login.php");

    require_once("../class/book.class.php");
    $Book = new Book();
    $books = $Book->all();

    require_once("../include/smarty.php");
    $smarty->assign("books", $books);
    $smarty->assign("books_size", $books->num_rows);
    $smarty->display("admin/list.tpl");