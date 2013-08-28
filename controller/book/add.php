<?php
    session_start();
    header("Content-Type: text/html; charset=utf-8");
    require_once("../require.global.php");
    redirect_unless_login("/login.php");
    require_once(MODEL_DIR . "/book.class.php");

    $smarty->assign("page_title", "添加书籍");
    $smarty->assign("user", $_SESSION["user"]);

    if (isset($_POST["submitted"]) && $_POST["submitted"] == "yes") {
        $title = trim($_POST["title"]);
        $pages = trim($_POST["pages"]);
        $author = trim($_POST["author"]);
        $isbn = trim($_POST["isbn"]);
        $intro = trim($_POST["intro"]);
        $category = trim($_POST["category"]);
        $douban_link = trim($_POST["douban_link"]);
        $cover = $_FILES["cover"];

        // title为必需值
        if ($title == "" || empty($pages)) {
            $title == "" and $alert->set_message("请输入书籍标题");
            empty($pages) and $alert->set_message("请输入书籍总页数");
            $alert->show();
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
                "intro" => $intro,
                "pages" => intval($pages),
                "douban_link" => $douban_link,
                "create_at" => date("Y-m-d H:i:s"),
                "update_at" => date("Y-m-d H:i:s"),
                "creator" => $_SESSION["user"]->id
            );

            !empty($cover["size"]) and $book_data["cover"] = $cover;

            $result = $book_model->add($book_data);
            if ($result) {
                $book_id = $book_model->get_last_id();
                $isProcessWell = true;

                // 分类处理
                $isProcessWell = $book_model->add_category($book_id, $category);

                // 作者处理
                $isProcessWell = $book_model->add_author($book_id, $author);

                if ($isProcessWell) {
                    header("location: /book/detail.php?id=$book_id&source=add&code=1");
                } else {
                    $alert->set_message($book_model->get_last_error())->show();
                    $smarty->assign("alert", $alert);
                    $smarty->display("book/add.tpl");
                }
            } else {
                if ($book_model->get_last_error_no() == 1062) {
                    $alert->set_message("相同标题的书籍已存在");
                } else {
                    $alert->set_message($book_model->get_last_error());
                }
                $alert->show();

                $smarty->assign("alert", $alert);
                $smarty->display("book/add.tpl");
            }
        }
    } else {
        $smarty->display("book/add.tpl");
    }

    isset($book_model) and $book_model->release();