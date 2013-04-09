<?php
    session_start();
    header("Content-Type: text/html; charset=utf-8");
    require_once("verify.php");

    require_once("config.php");

    $action = $_GET["action"];
    $code = $_GET["code"];

    if (!isset($action) || $action == "") {
        die("无效操作");
    }

    $title = "";
    switch($action) {
        case "add":
            $title = "添加";
            break;
        case "edit":
            $title = "更新";
            break;
        case "delete":
            $title = "删除";
            break;
    }
    if ($code == "1") {
        $alert_type = "success";
        $result = "成功";
    } else {
        $alert_type = "error";
        $result = "失败";
    }

    $smarty->assign("action", $title);
    $smarty->assign("alert_type", $alert_type);
    $smarty->assign("result", $result);
    $smarty->display("admin/result.tpl");


