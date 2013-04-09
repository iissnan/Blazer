<?php
    session_start();
    header("Content-Type: text/html; charset=utf-8");
    require_once("verify.php");

    require_once("config.php");
    require_once("../class/book.class.php");

    if (isset($_GET["id"]) && $_GET["id"] != "") {
        $item_id = $_GET["id"];
        $book_instance = new Book();
        $result = (int)$book_instance->remove($item_id);

        echo "<script>location.href = 'result.php?action=delete&code=" . $result . "'</script>";
    } else {
        $smarty->display("admin/delete.tpl");
    }

