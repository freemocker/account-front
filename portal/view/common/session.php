<?php
require $_SERVER['DOCUMENT_ROOT'] . '/view/common/session.php';
$GLOBALS['session_timeout'] = false;
if ($_SERVER['REQUEST_URI'] != $GLOBALS['webroot'] && $_SERVER['REQUEST_URI'] != $GLOBALS['webroot'] . "/index" && $_SERVER['REQUEST_URI'] != $GLOBALS['loginpage_url'] && $_SERVER['REQUEST_URI'] != $GLOBALS['logoutpage_url'] && $_SERVER['REQUEST_URI'] != $GLOBALS['timeoutpage_url']) {
    if (empty($_SESSION) || ! isset($_SESSION[portal\service\tools\ToolsClass::$LOGIN_USER_STR])) {
        $GLOBALS['session_timeout'] = true;
    } else {
        $ip = \service\tools\common\IPClass::getRemoteIP();
        $userid = \portal\service\tools\ToolsClass::getUser()->getId();
        $onlineusers = \service\user\UserManagerClass::getOnlineUsers($GLOBALS['application']->getId(), $userid, $ip);
        if (count($onlineusers) > 0) {
            $singlePoint = \portal\config\PortalConfig::getInstance()['singlePoint'];
            \service\user\UserManagerClass::updateOnlineUser($GLOBALS['application']->getId(), $userid, $ip, $singlePoint);
        } else {
            $GLOBALS['session_timeout'] = true;
        }
    }
}