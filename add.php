<?php
    header("Content-Type: text/html; charset=utf-8");
    require_once("dbc.class.php");

    $title = trim($_POST["title"]);
    $author = trim($_POST["author"]);
    $isbn = trim($_POST["isbn"]);

    if ($title == "") {
        echo "请输入标题";
        exit();
    }

    $dbc = new DatabaseConnection("localhost", "root", "123456", "bookshelf");
    $result = $dbc->insert("books", array("title", "author"), array($title, $author));
    if ($result) {
        echo "添加成功!";
        echo "<script>window.location ='add.html';</script>";
    }
