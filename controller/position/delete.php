<?php
    session_start();
    require_once("../require.global.php");
    redirect_unless_login("/login.php");
    require_once(MODEL_DIR . "/dbm.class.php");

    $alert_mode = "alert-error";
    $alert_message = "";
    $error = false;
    $show_alert = false;

    $position_id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;
    if (empty($position_id)) {
        $error = true;
        $alert_message = "无效的进度ID";
    } else {
        $position_model = new DatabaseManipulate("positions");
        $position_result = $position_model->remove()->where("`id`='$position_id'")->execute();
        if ($position_result) {
            header("location: /position/index.php?source=remove&code=1");
        } else {
            $error = true;
            $alert_message = "移除请求的进度信息失败，请稍后再试";
        }
    }

    $smarty->assign("error", $error);
    $smarty->assign("show_alert", $show_alert);
    $smarty->assign("alert_mode", $alert_mode);
    $smarty->assign("alert_message", $alert_message);
    $smarty->display("position/delete.tpl");

