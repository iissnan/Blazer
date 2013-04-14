<?php
    session_start();
    header("Content-Type: text/html; charset=utf-8");
    require_once("../include/auth.php");
    redirect_unless_login("../login.php");

    require_once("../class/invitation.class.php");
    $inv = new Invitation();
    $inv_value = uniqid();

    require_once("../include/smarty.php");
    if ($inv->add(array("value" => $inv_value, "number" => 5))) {
        $smarty->assign("alert_type", "success");
        $smarty->assign("result", "成功");
        $smarty->assign("invitation", $inv_value);
    } else {
        $smarty->assign("alert_type", "error");
        $smarty->assign("result", "失败");
    }
    $smarty->display("admin/invitation_add.tpl");