<?php


/** Smarty Configuration */

// SMARTY_DIR
require_once(__DIR__ . "/../vendor/smarty/Smarty.class.php");

// Smarty 实例
$smarty = new Smarty();

// 设置smarty目录
$smarty->setTemplateDir(__DIR__ . "/../templates");
$smarty->setCompileDir(__DIR__ . "/../templates_c");
$smarty->setCacheDir(__DIR__ . "/../cache");
$smarty->setConfigDir(__DIR__ . "/../config");

is_login() and $smarty->assign("is_login", true);
