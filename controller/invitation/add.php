<?php
    session_start();
    header("Content-Type: text/html; charset=utf-8");
    require_once("../../include/auth.php");
    redirect_unless_login("../login.php");

    require_once("../../include/smarty.php");
    require_once("../../model/invitation.class.php");

    if ($_SESSION["user"]->group == "admin") {
        $inv = new Invitation();
        $inv_value = uniqid();

        $smarty->assign("user", $_SESSION["user"]);
        if ($inv->add(array("value" => $inv_value, "number" => 5, "user_id" => $_SESSION["user"]->id))) {
            $smarty->assign("alert_mode", "success");
            $smarty->assign("result", "成功");
            $smarty->assign("invitation", $inv_value);
        } else {
            $smarty->assign("alert_mode", "error");
            $smarty->assign("result", "失败");
        }
    } else {
        header("location: /invitation/index.php");
    }

    $smarty->assign("page_title", "添加邀请码");
    $smarty->display("invitation/add.tpl");