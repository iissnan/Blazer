<?php
    session_start();
    header("Content-Type: text/html; charset=utf-8");
    require_once("../../include/auth.php");
    redirect_unless_login("../login.php");

    require_once("../../include/smarty.php");
    require_once("../../model/invitation.class.php");
    require_once("../../include/paginator.class.php");

    $invitation_model = new InvitationModel();
    $page = !isset($_GET["page"]) ? 1 : $_GET["page"];
    $page_size = 10;
    $inv_total = $invitation_model->get_total();
    $paginator = new Paginator($inv_total, $page, $page_size);
    $page = $paginator->getPage();
    $page_total = $paginator->getTotal();
    $invitations = $invitation_model->select("*")
                                    ->where("number > 0")
                                    ->where("user_id=" . $_SESSION["user"]->id)
                                    ->order_by("id")
                                    ->limit($page_size, $page)
                                    ->execute();

    // 若数据库中无此用户的邀请码记录，则重新生成一个
    // 适用于注册时添加邀请码失败的场景
    if ($invitations->num_rows == 0) {
        $new_invitation = array("value" => uniqid(), "user_id" => $_SESSION["user"]->id);
        $invitation_add_result = $invitation_model->insert($new_invitation)->execute();
        if ($invitation_add_result) {
            $invitations = $invitation_model->select("*")
                                    ->where("number > 0")
                                    ->where("user_id=" . $_SESSION["user"]->id)
                                    ->order_by("id")
                                    ->limit($page_size, $page)
                                    ->execute();
        }
    }

    $smarty->assign("user", $_SESSION["user"]);
    $smarty->assign("invitations_size", $inv_total);
    $smarty->assign("invitations", $invitations);

    if ($paginator->hasPagination()) {
        $smarty->assign("pagination", true);
        $smarty->assign("page_current", $page);
        $smarty->assign("page_total", $page_total);
    }
    $smarty->assign("page_title", "我的邀请码");
    $smarty->display("invitation/index.tpl");

