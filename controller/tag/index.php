<?php
    session_start();
    require("../require.global.php");
    require(MODEL_DIR . "/tag.class.php");

    isset($_SESSION["user"]) and $user = $_SESSION["user"];

    $alert_mode = "alert-error";
    $alert_message = "";
    $error = false;
    $show_alert = false;

    // 获取所有有效的标签
    $tag_model = new TagModel();
    $tag_result = $tag_model->select("DISTINCT categories.*", "categories, books_categories")
                            ->where("categories.id=books_categories.category_id")
                            ->order_by("categories.id")
                            ->execute();

    if ($tag_result && $tag_result->num_rows > 0) {
        $smarty->assign("tags", $tag_result);
    } else {
        $alert_mode = "alert-info";
        $error = true;
        $alert_message = "暂无标签";
    }

    $smarty->assign("error", $error);
    $smarty->assign("alert_mode", $alert_mode);
    $smarty->assign("alert_message", $alert_message);
    $smarty->assign("user", $user);
    $smarty->assign("page_title", "所有的图书标签");
    $smarty->display("tag/index.tpl");

    isset($tag_model) and $tag_model->release();
