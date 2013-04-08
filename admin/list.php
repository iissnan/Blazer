<?php
    session_start();
    !isset($_SESSION["user"]) and header("Location: ../login.php");
    require_once("../class/book.class.php");
    require_once("./config.php");

    $book_instance = new Book();
    $books = $book_instance->all();

    $smarty->assign("books", $books);
    $smarty->assign("books_size", $books->num_rows);
    $smarty->display("admin/list.tpl");