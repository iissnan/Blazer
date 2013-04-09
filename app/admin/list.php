<?php
    session_start();
    require_once("verify.php");

    require_once("../class/book.class.php");
    $book_instance = new Book();
    $books = $book_instance->all();

    require_once("./config.php");
    $smarty->assign("books", $books);
    $smarty->assign("books_size", $books->num_rows);
    $smarty->display("admin/list.tpl");