<?php
    session_start();
    header("Content-Type: text/html; charset=utf-8");
    require_once("verify.php");

    // TODO: Show Invitation when user belongs to "Admin" group
    require_once("../class/invitation.class.php");
    $Invitation = new Invitation();
    $invitations = $Invitation->get();
    $invitations_size = $invitations->num_rows;

    require_once("config.php");
    $smarty->assign("invitations_size", $invitations_size);
    $smarty->assign("invitations", $invitations);
    $smarty->display("admin/invitation.tpl");

