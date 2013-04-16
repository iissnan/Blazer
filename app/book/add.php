<?php
    session_start();
    header("Content-Type: text/html; charset=utf-8");
    require_once("../include/auth.php");
    redirect_unless_login("../login.php");

    require_once("../include/smarty.php");
    require_once("../class/model.class.php");
    require_once("../class/book.class.php");

    // 避免与书籍的title冲突
    $smarty->assign("page_title", "添加书籍");
    $smarty->assign("user", $_SESSION["user"]);

    if (isset($_POST["submitted"]) && $_POST["submitted"] == "yes") {
        $title = trim($_POST["title"]);
        $author = trim($_POST["author"]);
        $isbn = trim($_POST["isbn"]);
        $intro = trim($_POST["intro"]);
        $pages = trim($_POST["pages"]);
        $category = trim($_POST["category"]);
        $douban_link = trim($_POST["douban_link"]);
        $cover = $_FILES["cover"];

        // title为必需值
        if ($title == "") {
            $alert = "<div class='alert alert-error' id='alert'>请输入书籍标题</div>";
            $smarty->assign("alert", $alert);
            $smarty->assign(array(
                "title" => $title,
                "author" => $author,
                "isbn" => $isbn,
                "intro" => $intro,
                "pages" => $page,
                "douban_link" => $douban_link,
                "category" => $category
            ));
            $smarty->display("book/add.tpl");
        } else {
            $book_model = new BookModel();
            $book_data = array(
                "title" => $title,
                "isbn" => $isbn,
                "cover" => $cover,
                "pages" => intval($pages),
                "douban_link" => $douban_link,
                "create_at" => date("Y-m-d H:i:s"),
                "update_at" => date("Y-m-d H:i:s"),
                "creator" => $_SESSION["user"]->id
            );

            $result = $book_model->add($book_data);
            if ($result) {
                $book_id = $book_model->dbc->db->insert_id;
                $isProcessWell = true;

                // 分类处理
                $isProcessWell = $book_model->add_category($book_id, $category);

                // 作者处理
                $isProcessWell = $book_model->add_author($book_id, $author);

                if ($isProcessWell) {
                    echo "<script>location.href = 'result.php?action=add&code=" . $result . "';</script>";
                } else {
                    $alert = "<div class='alert alert-error' id='alert'>" . $book_model->dbc->db->error . "</div>";
                    $smarty->assign("alert", $alert);
                    $smarty->display("book/add.tpl");
                }
            } else {
                $alert = "<div class='alert alert-error' id='alert'>" . $book_model->dbc->db->error . "</div>";
                $smarty->assign("alert", $alert);
                $smarty->display("book/add.tpl");
            }
        }
    } else {
        $smarty->display("book/add.tpl");
    }