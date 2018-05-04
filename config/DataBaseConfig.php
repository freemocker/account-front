<?php
namespace config;

class DataBaseConfig implements base\IBaseConfig
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
        $resource = array();

        /**
         * 系统默认数据源 MySQL
         */
        $resource[0] = array(
            /**
             * 数据源名称
             */
            "name" => "系统默认数据源",
            /**
             * 链接字符串
             */
//            "url" => "mysql:host=192.168.50.12:3306;dbname=zt_kernel;charset=utf8",
            "url" => "mysql:host=127.0.0.1:3306;dbname=zt_kernel;charset=utf8",
            /**
             * 数据库类型，针对不同类型数据库进行优化，目前支持：mysql，mssql，oracle
             */
            "dbtype" => "mysql",
            /**
             * 链接字符集
             */
            "charset" => "utf8",
            /**
             * 数据库用户名
             */
            "username" => "root",
            /**
             * 数据库密码
             */
//            "password" => "mysql",
            "password" => "test",
            /**
             * 错误报告：ERRMODE_SILENT（仅设置错误代码），ERRMODE_WARNING，ERRMODE_EXCEPTION
             */
            "ATTR_ERRMODE" => "ERRMODE_EXCEPTION",
            /**
             * 转换 NULL 和空字符串：NULL_NATURAL，NULL_EMPTY_STRING，NULL_TO_STRING
             */
            "ATTR_ORACLE_NULLS" => "NULL_TO_STRING"
        );

        /**
         * 账务系统数据源 MySQL
         */
        $resource[1] = array(
            /**
             * 数据源名称
             */
            "name" => "账务系统交易库数据源",
            /**
             * 链接字符串
             */
//            "url" => "mysql:host=192.168.50.12:3306;dbname=zt_accounts;charset=utf8",
            "url" => "mysql:host=127.0.0.1:3306;dbname=zt_accounts;charset=utf8",
            /**
             * 数据库类型，针对不同类型数据库进行优化，目前支持：mysql，mssql，oracle
             */
            "dbtype" => "mysql",
            /**
             * 链接字符集
             */
            "charset" => "utf8",
            /**
             * 数据库用户名
             */
            "username" => "root",
            /**
             * 数据库密码
             */
//            "password" => "mysql",
            "password" => "test",
            /**
             * 错误报告：ERRMODE_SILENT（仅设置错误代码），ERRMODE_WARNING，ERRMODE_EXCEPTION
             */
            "ATTR_ERRMODE" => "ERRMODE_EXCEPTION",
            /**
             * 转换 NULL 和空字符串：NULL_NATURAL，NULL_EMPTY_STRING，NULL_TO_STRING
             */
            "ATTR_ORACLE_NULLS" => "NULL_TO_STRING"
        );

        /**
         * 账务系统管理库数据源 MySQL
         */
        $resource[2] = array(
            /**
             * 数据源名称
             */
            "name" => "账务系统管理库数据源",
            /**
             * 链接字符串
             */
//            "url" => "mysql:host=192.168.50.12:3306;dbname=zt_manage;charset=utf8",
            "url" => "mysql:host=127.0.0.1:3306;dbname=zt_manage;charset=utf8",
            /**
             * 数据库类型，针对不同类型数据库进行优化，目前支持：mysql，mssql，oracle
             */
            "dbtype" => "mysql",
            /**
             * 链接字符集
             */
            "charset" => "utf8",
            /**
             * 数据库用户名
             */
            "username" => "root",
            /**
             * 数据库密码
             */
//            "password" => "mysql",
            "password" => "test",
            /**
             * 错误报告：ERRMODE_SILENT（仅设置错误代码），ERRMODE_WARNING，ERRMODE_EXCEPTION
             */
            "ATTR_ERRMODE" => "ERRMODE_EXCEPTION",
            /**
             * 转换 NULL 和空字符串：NULL_NATURAL，NULL_EMPTY_STRING，NULL_TO_STRING
             */
            "ATTR_ORACLE_NULLS" => "NULL_TO_STRING"
        );

        return $resource;
    }
}

?>