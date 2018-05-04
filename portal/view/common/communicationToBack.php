<?php
require dirname(__FILE__) . '/serviceHead.php';
$portalConfig = portal\config\PortalConfig::getInstance();
$_REQUEST[$portalConfig["backService"]["httpAppId"]] = $GLOBALS['application']->getId();
$_REQUEST[$portalConfig['backService']['httpDbnoName']] = $GLOBALS['app_dbno'];
$_REQUEST[$portalConfig['backService']['httpOperatorIdName']] = $GLOBALS['curr_user']->getId();
require $_SERVER['DOCUMENT_ROOT'] . '/view/common/communicationToBack.php';