<?php

$parentDirectoryPath = dirname(__FILE__);

// Smarty Configuration
require_once($parentDirectoryPath . "/../../vendor/smarty/Smarty.class.php");
$smarty = new Smarty();
$smarty->setTemplateDir($parentDirectoryPath . "/../../templates");
$smarty->setCompileDir($parentDirectoryPath . "/../../templates_c");
$smarty->setCacheDir($parentDirectoryPath . "/../../cache");
$smarty->setConfigDir($parentDirectoryPath . "/../../config");

is_login() and $smarty->assign("is_login", true);
