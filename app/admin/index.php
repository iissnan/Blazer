<?php
    session_start();
    require_once("auth.php");

    require_once("../class/book.class.php");
    $Book = new Book();
    $books = $Book->all();

    require_once("smarty.php");
    $smarty->assign("books", $books);
    $smarty->assign("books_size", $books->num_rows);
    $smarty->display("admin/list.tpl");