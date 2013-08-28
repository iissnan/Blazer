<?php
    session_start();
    require("../require.global.php");
    require(MODEL_DIR . "/tag.class.php");

    isset($_SESSION["user"]) and $user = $_SESSION["user"];

    // 获取所有有效的标签
    $tag_model = new TagModel();
    $tag_result = $tag_model->select("DISTINCT categories.*", "categories, books_categories")
                            ->where("categories.id=books_categories.category_id")
                            ->order_by("categories.id")
                            ->execute();

    if ($tag_result && $tag_result->num_rows > 0) {
        $smarty->assign("tags", $tag_result);
    } else {
        $alert->set_mode("info")->set_message("暂无标签")->show();
    }

    $smarty->assign("user", $user);
    $smarty->assign("page_title", "所有的图书标签");
    $smarty->assign("alert", $alert);
    $smarty->display("tag/index.tpl");

    isset($tag_model) and $tag_model->release();
