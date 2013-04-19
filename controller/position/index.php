<?php
    session_start();
    require_once("../../include/auth.php");
    redirect_unless_login("/login.php");
    require_once("../../include/smarty.php");
    require_once("../../model/user.class.php");
    require_once("../../model/book.class.php");
    require_once("../../include/paginator.class.php");

    $user = $_SESSION["user"];
    $position_model = new DatabaseManipulate("positions");

    // 分页
    $position_total = $position_model->get_total("`user_id`='$user->id'");
    $page = isset($_GET["page"]) ? $_GET["page"] : 1;
    $pagination = new Paginator($position_total, $page);
    if ($pagination->hasPagination()) {
        $smarty->assign(
            array(
                "pagination" => true,
                "current_page" => $pagination->getPage(),
                "page_total" => $pagination->getTotal()
            )
        );
    }

    // 获取进度数据
    $position_result = $position_model->select("*", "books, positions")
                                        ->where("`user_id`='$user->id'")
                                        ->where("books.id=positions.book_id")
                                        ->order_by("positions.id")
                                        ->limit(10)
                                        ->execute();
    if ($position_result && $position_result->num_rows > 0) {
        $smarty->assign("positions", $position_result);
    }

    $smarty->assign("total", $position_total);
    $smarty->assign("user", $_SESSION["user"]);
    $smarty->display("position/index.tpl");