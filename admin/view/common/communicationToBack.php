<?php
require dirname(__FILE__) . '/serviceHead.php';
$adminConfig = admin\config\AdminConfig::getInstance();
$_REQUEST[$adminConfig["backService"]["httpAppId"]] = $GLOBALS['application']->getId();
$_REQUEST[$adminConfig['backService']['httpDbnoName']] = $GLOBALS['app_dbno'];
$_REQUEST[$adminConfig['backService']['httpOperatorIdName']] = $GLOBALS['curr_user']->getId();
require $_SERVER['DOCUMENT_ROOT'] . '/view/common/communicationToBack.php';