<?php
    session_start();
    header("Content-Type: text/html; charset=utf-8");
    require_once("../include/auth.php");
    redirect_unless_login("../login.php");

    // TODO: Show Invitation when user belongs to "Admin" group
    require_once("../class/invitation.class.php");
    require_once("../class/paginator.class.php");
    $Invitation = new Invitation();
    $page = !isset($_GET["page"]) ? 1 : $_GET["page"];
    $page_size = 10;
    $inv_total = $Invitation->total();
    $paginator = new Paginator($inv_total, $page, $page_size);
    $page = $paginator->getPage();
    $page_total = $paginator->getTotal();
    $invitations = $Invitation->getItems($page_size, $page, "number > 0");

    require_once("../include/smarty.php");
    $smarty->assign("invitations_size", $inv_total);
    $smarty->assign("invitations", $invitations);

    if ($paginator->hasPagination()) {
        $smarty->assign("pagination", true);
        $smarty->assign("page_current", $page);
        $smarty->assign("page_total", $page_total);
    }
    $smarty->display("admin/invitation.tpl");

