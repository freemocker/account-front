<?php
namespace portal\config;

use config\base\IBaseConfig;

class PortalConfig implements IBaseConfig
{

    private static $instance = null;

    public static function getInstance()
    {
        if (self::$instance == null) {
            $instance = self::generateConfigInfo();
            self::$instance = $instance;
        }
        return self::$instance;
    }

    private static function generateConfigInfo()
    {
        $config = array();

        /**
         * web应用根路径名
         */
        $config["webroot"] = "portal";

        /**
         * 系统页面地址
         */
        $config["page-url"]["login"] = "/" . $config["webroot"] . "/view/login/login"; // 登录页面
        $config["page-url"]["logout"] = "/" . $config["webroot"] . "/view/login/login?cmd=loginout"; // 注销页面
        $config["page-url"]["timeout"] = "/" . $config["webroot"] . "/view/timeout"; // 超时页面
        $config["page-url"]["main"] = "/" . $config["webroot"] . "/view/main"; // 系统主框架页面
        $config["page-url"]["home"] = "/" . $config["webroot"] . "/view/home/home"; // 系统默认首页

        /**
         * 是否启用单点登录
         */
        $config["singlePoint"] = true;

        /**
         * 默认密码
         */
        $config["defaultPassword"] = "000000";

        /**
         * 后台服务：http请求地址:端口，内部PHP转发时使用
         */
        $config["backService"]["httphostIn"] = "http://127.0.0.1:8080/Accounts/ctrl/doAccount";
        /**
         * 后台服务：http请求超时时间，单位：毫秒
         */
        $config["backService"]["httptimeout"] = 30000;
        /**
         * 后台服务：应用编号参数名
         */
        $config["backService"]["httpAppId"] = "appid";
        /**
         * 后台服务：数据源编号参数名
         */
        $config["backService"]["httpDbnoName"] = "app_dbno";
        /**
         * 后台服务：调用的操作者ID参数名
         */
        $config["backService"]["httpOperatorIdName"] = "operatorId";
        /**
         * 后台服务：http请求字符编码
         */
        $config["backService"]["charset"] = "utf-8";

        /**
         * 后台服务：http请求地址:端口，内部PHP转发时使用
         */
        $config["backService2"]["httphostIn"] = "http://127.0.0.1:8080/AccountsMng/ctrl/manageAccount";
        /**
         * 后台服务：http请求超时时间，单位：毫秒
         */
        $config["backService2"]["httptimeout"] = 30000;
        /**
         * 后台服务：应用编号参数名
         */
        $config["backService2"]["httpAppId"] = "appid";
        /**
         * 后台服务：数据源编号参数名
         */
        $config["backService2"]["httpDbnoName"] = "app_dbno";
        /**
         * 后台服务：调用的操作者ID参数名
         */
        $config["backService2"]["httpOperatorIdName"] = "operatorId";
        /**
         * 后台服务：http请求字符编码
         */
        $config["backService2"]["charset"] = "utf-8";

        /**
         * B户注册上传图片的根路径，相对于webroot
         */
        $config["img"]["uploadBacountUrl"] = "/" . $config["webroot"] . "/files/upload/accountB/";

        return $config;
    }
}

?>