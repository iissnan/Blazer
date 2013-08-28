<?php
    session_start();
    header("Content-Type: text/html; charset=utf-8");
    require_once("../require.global.php");
    redirect_unless_login("/login.php");
    require_once(MODEL_DIR . "/invitation.class.php");

    if ($_SESSION["user"]->group == "admin") {
        $inv = new InvitationModel();
        $inv_value = uniqid();

        $new_invitation = array("value" => $inv_value, "number" => 5, "user_id" => $_SESSION["user"]->id);
        if ($inv->insert($new_invitation)->execute()) {
            $alert->set_mode("pass")->set_message("添加成功")->show();
            $smarty->assign("invitation", $inv_value);
        } else {
            $alert->set_message("添加失败")->show();
        }
    } else {
        header("location: /invitation/index.php");
    }

    $smarty->assign("alert", $alert);
    $smarty->assign("user", $_SESSION["user"]);
    $smarty->assign("page_title", "添加邀请码");
    $smarty->display("invitation/add.tpl");

    isset($inv) and $inv->release();