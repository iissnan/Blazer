<?php
    session_start();
    header("Content-Type: text/html; charset=utf-8");
    require_once("auth.php");

    require_once("smarty.php");
    require_once("../class/book.class.php");

    if (isset($_GET["id"]) && $_GET["id"] != "") {
        $item_id = $_GET["id"];
        $Book = new Book();
        $result = (int)$Book->remove($item_id);

        echo "<script>location.href = 'result.php?action=delete&code=" . $result . "'</script>";
    } else {
        $smarty->display("admin/delete.tpl");
    }

