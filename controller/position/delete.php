<?php
    session_start();
    require_once("../require.global.php");
    redirect_unless_login("/login.php");
    require_once(MODEL_DIR . "/dbm.class.php");

    $position_id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;
    if (empty($position_id)) {
        $alert->set_message("无效的进度ID")->show();
    } else {
        $position_model = new DatabaseManipulate("positions");
        $position_result = $position_model->remove()->where("`id`='$position_id'")->execute();
        if ($position_result) {
            header("location: /position/index.php?source=remove&code=1");
        } else {
            $alert->set_message("移除请求的进度信息失败，请稍后再试")->show();
        }
    }

    $smarty->assign("alert", $alert);
    $smarty->display("position/delete.tpl");

