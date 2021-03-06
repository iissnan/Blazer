<?php
    session_start();
    header("Content-Type: text/html; charset=utf-8");
    require_once("../require.global.php");
    redirect_unless_login("/login.php");

    require_once(MODEL_DIR . "/book.class.php");

    $smarty->assign("page_title", "删除书籍");
    $smarty->assign("user", $_SESSION["user"]);

    if (isset($_GET["id"]) && $_GET["id"] != "") {
        $item_id = $_GET["id"];
        $book_model = new BookModel();
        $result = (int)$book_model->remove()->where("id='$item_id'")->execute();
        $result and $book_model->update_category($item_id, "");

        echo "<script>location.href = 'result.php?action=delete&code=" . $result . "'</script>";
    } else {
        $smarty->display("book/delete.tpl");
    }

    isset($book_model) and $book_model->release();

