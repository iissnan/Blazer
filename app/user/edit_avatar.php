<?php
    session_start();
    require_once("../include/auth.php");
    redirect_unless_login("../login.php");

    // 更改头像
