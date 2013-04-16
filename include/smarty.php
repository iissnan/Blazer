<?php


// Smarty Configuration
require_once(__DIR__ . "/../vendor/smarty/Smarty.class.php");
$smarty = new Smarty();
$smarty->setTemplateDir(__DIR__ . "/../templates");
$smarty->setCompileDir(__DIR__ . "/../templates_c");
$smarty->setCacheDir(__DIR__ . "/../cache");
$smarty->setConfigDir(__DIR__ . "/../config");

is_login() and $smarty->assign("is_login", true);
