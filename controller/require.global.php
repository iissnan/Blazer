<?php
    // 全站级别require文件
    require_once(__DIR__ . "/app.config.php");
    require_once(FUNCTION_DIR . "/utils/alert.class.php");
    require_once(FUNCTION_DIR . "/auth.php");
    require_once(FUNCTION_DIR . "/smarty.php");

    // 新建alert实例
    use minamo\utils\Alert as Alert;
    $alert = new Alert();