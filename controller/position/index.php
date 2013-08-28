<?php
    session_start();
    require_once("../require.global.php");
    redirect_unless_login("/login.php");
    require_once(MODEL_DIR . "/user.class.php");
    require_once(MODEL_DIR . "/book.class.php");
    require_once(FUNCTION_DIR . "/paginator.class.php");

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

    // 删除成功后的跳转
    if (isset($_GET["code"]) && $_GET["code"] == "1") {
        if (isset($_GET["source"])) {
            switch ($_GET["source"]) {
                case "remove":
                    $alert->set_mode("pass")
                            ->set_message("成功移除进度信息")
                            ->show();
                    $smarty->assign("alert", $alert);
                    break;
            }
        }
    }

    $smarty->assign("total", $position_total);
    $smarty->assign("user", $_SESSION["user"]);
    $smarty->assign("page_title", $_SESSION["user"]->username . "的阅读记录");
    $smarty->display("position/index.tpl");