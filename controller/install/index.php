<?php
    session_start();
    header("Content-Type: text/html; charset=utf-8");

    require_once("../../include/app.config.php");
    require_once("../../include/auth.php");
    require_once("../../include/smarty.php");
    require_once("../../model/dbc.class.php");

    $good_to_go = true;
    $result_string = "";

    // 确认数据库链接
    @$dbc = new DatabaseConnection(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
    $result_string .= "<ul><li>" .
        "<span class='label test-item'>数据库连接测试成功</span> &nbsp;&nbsp;" .
        "<span class='label label-success'><i class='icon-ok icon-white'></i></span>" .
        "</li></ul>";

    // 确认目录的可读写：templates_c、cache、assets/avatar、assets/cover
    $result_string .= "<p>正在确认目录可读写性...</p>";
    $writable_result = "<ul>";
    $dir_array = array(
        "templates_c" => __DIR__ . "/../../templates_c",
        "cache" => __DIR__ . "/../../cache",
        "avatar" => __DIR__ . "/../assets/avatar",
        "cover" => __DIR__ . "/../assets/cover"
    );

    $string_writable = "<span class='label label-success'><i class='icon-ok icon-white'></i></span>";
    $string_non_writable = "<span class='label label-important'><i class='icon-remove icon-white'></i></span>";
    foreach ($dir_array as $dir_name=>$dir) {
        $writable_result = $writable_result . "<li><span class='label test-item'>$dir_name</span> &nbsp;&nbsp;" .
            (check_writable($dir) ? $string_writable : $string_non_writable) . "</li>";
        !check_writable($dir) and $good_to_go = false;
    }
    $writable_result .= "</ul>";
    function check_writable($dir) {
        $is_writable = true;
        !is_dir($dir) and $is_writable = false;

        $test_file = @fopen($dir . "/test.txt", "w");
        if (!$test_file) {
            $is_writable = false;
        }
        @fclose($test_file);
        @unlink($dir . "/test.txt");
        return $is_writable;
    }

    $result_string .= $writable_result;

    // 指示注册是否为第一个用户，当注册成功后销毁
    $good_to_go and $_SESSION["first_user"] = true;

    $smarty->assign("ok", $good_to_go);
    $smarty->assign("result_string", $result_string);
    $smarty->display("install.tpl");
