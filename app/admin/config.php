<?php

// Smarty configurations
require_once("../../vendor/smarty/Smarty.class.php");
$smarty = new Smarty();
$smarty->setTemplateDir("../../templates");
$smarty->setCompileDir("../../templates_c");
$smarty->setCacheDir("../../cache");
