<?php
/**
 * Created by PhpStorm.
 * User: zhangbin
 * Date: 2016/10/13
 * Time: 13:58
 */
require dirname(__FILE__) . '/../../../view/common/serviceHead.php';
require $_SERVER['DOCUMENT_ROOT'] . '/service/base/baseQuery.php';

/**
 * 校验必填字段
 * @param $str
 * @return bool
 */
function doValidate($str)
{
    if (!isset($str) || $str == null || $str == "") {
        return false;
    } else {
        return true;
    }
}

/**
 * 校验授权
 * @param $loginno
 * @param $password
 * @return string
 */
function doValidateAuth($loginno, $password)
{
    $authuserid = '';
    if (isset($loginno) && isset($password) && $loginno != '' && $password != '') {
        $authuserid = \service\user\UserManagerClass::validateUserLoginNoAndPwd($loginno, $password);
        if ($authuserid != '') {
            if (!\service\user\UserManagerClass::validatePermissions($GLOBALS['application']->getId(), $authuserid, 'cust_account_power')) {
                $authuserid = '';
            }
        }
    }
    return $authuserid;
}

/**
 * 生成虚拟账户编码
 * @param $custid
 * @param $accountType
 * @return string
 */
function generateSubaccountCode($custid, $accountType)
{
    $result = $custid;
    $result = $result . $accountType;
    $result = $result . str_pad(mt_rand(0, 999), 3, '0', STR_PAD_LEFT);
    return $result;
}

/**
 * 获取绑定信息列表
 */
function doSearchBindList()
{
    $commonTools = new \service\tools\ToolsClass();
    $custid = $_REQUEST['accountid'];
    $result = $commonTools->getDatasBySQL("select bb.id,bb.custid,bb.type,bb.account,case bb.isdefault when 1 then '默认' else '' end as isdefault,case bb.status when 1 then '激活' else '禁用' end as status,case bb.isdel when 1 then '已删除' else '正常' end as isdel,bb.createdate from acc_cust_bindinfo bb where bb.custid='" . $custid . "' order by bb.isdefault desc,bb.type asc");
    echo json_encode($result);
}

/**
 * 保存B户基础信息
 * @param $status
 */
function doUpdateBasic($status)
{
    $authuserid = doValidateAuth($_POST['authloginno'], $_POST['authpassword']);
    if ($authuserid == '') {
        $message = "操作授权失败！";
        \service\tools\logger\LoggerClass::error($message);
        $result = \service\tools\ToolsClass::buildJSONError($message);
        echo json_encode($result);
        die();
    }
    $sysTools = new \service\tools\ToolsClass(0);
    $sysConn = $sysTools->getDBConnection();
    $commonTools = new \service\tools\ToolsClass();
    $connection = $commonTools->getDBConnection();
    $result = array();
    $connection->beginTransaction();
    $sysConn->beginTransaction();
    $custid = $_POST['custid'];
    $userid = $connection->doQuery("select userid from acc_cust_account where custid='" . $custid . "' for update")->fetchAll()[0]['userid'];
    $sql = "update acc_cust_account set nickname=?,name=?,certtype=?,certno=?,status=?,telephone=?,edituserid=?,authuserid=? where custid=?";
    $params = array();
    $params[0] = $_POST['nickname'];
    $params[1] = $_POST['name'];
    $params[2] = $_POST['certtype'];
    if (doValidate($_POST['certno'])) {
        $preg = $commonTools->getDatasBySQL("select remark from acc_dic_certtype where code='" . $_POST['certtype'] . "'")[0]['remark'];
        if (doValidate($preg)) {
            if (!preg_match($preg, $_POST['certno'])) {
                $result = \service\tools\ToolsClass::buildJSONError("请输入有效的证件号码");
                echo json_encode($result);
                die();
            }
        }
    }
    $params[3] = $_POST['certno'];
    $params[4] = $status;
    if (!doValidate($_POST['telephone'])) {
        $connection->rollBack();
        $sysConn->rollBack();
        $result = \service\tools\ToolsClass::buildJSONError("请输入电话号码");
        echo json_encode($result);
        die();
    } else {
        $searchResult = $sysConn->doQuery("select id from t_user where loginno='" . $_POST['telephone'] . "' and id<>'" . $userid . "' for update")->fetchAll();
        if (count($searchResult) > 0) {
            $connection->rollBack();
            $sysConn->rollBack();
            $result = \service\tools\ToolsClass::buildJSONError("电话号码已被注册！");
            echo json_encode($result);
            die();
        }
    }
    $params[5] = $_POST['telephone'];
    $params[6] = \portal\service\tools\ToolsClass::getUser()->getId();
    $params[7] = $authuserid;
    $params[8] = $custid;
    if ($connection->doExcuteByPre($sql, $params) && $sysConn->doExcute("update t_user set loginno='" . $_POST['telephone'] . "' where id='" . $userid . "'")) {
        $connection->commit();
        $sysConn->commit();
        $result["custid"] = $custid;
        $result["result"] = "保存基础信息成功！";
    } else {
        $connection->rollBack();
        $sysConn->commit();
        $message = "C户保存失败！";
        \service\tools\logger\LoggerClass::error($message . "sql=" . $sql);
        $result = \service\tools\ToolsClass::buildJSONError($message);
    }
    echo json_encode($result);
    die();
}

function doResetPassword()
{
    $authuserid = doValidateAuth($_POST['authloginno'], $_POST['authpassword']);
    if ($authuserid == '') {
        $message = "操作授权失败！";
        \service\tools\logger\LoggerClass::error($message);
        $result = \service\tools\ToolsClass::buildJSONError($message);
        echo json_encode($result);
        die();
    }
    $sysTools = new \service\tools\ToolsClass(0);
    $commonTools = new \service\tools\ToolsClass();
    $portalconfig = \portal\config\PortalConfig::getInstance();
    $accountinfo = $commonTools->getDatasBySQL("select * from acc_cust_account where custid='" . $_POST['custid'] . "'")[0];
    $userid = $accountinfo['userid'];
    $loginno = $accountinfo['telephone'];
    if (!$sysTools->doExecuteSQL("update t_user set loginno='$loginno' where id='$userid'")) {
        $message = "C户【" . $loginno . "】重置登录密码失败！";
        \service\tools\logger\LoggerClass::error($message);
        $result = \service\tools\ToolsClass::buildJSONError($message);
        echo json_encode($result);
        die();
    }
    $userinfo = $sysTools->getDatasBySQL("select u.id,u.loginno from T_user u where u.id='" . $userid . "'");
    if (count($userinfo) > 0) {
        $userinfo = $userinfo[0];
        if (\service\user\UserManagerClass::resetPassword($userinfo['id'], $userinfo['loginno'], $portalconfig['defaultPassword'])) {
            $commonTools->doExecuteSQL("update acc_cust_account set edituserid='" . \portal\service\tools\ToolsClass::getUser()->getId() . "',authuserid='" . $authuserid . "'");
            $message = "C户【" . $userinfo['loginno'] . "】重置登录密码成功！";
            \service\tools\logger\LoggerClass::info($message);
            $result['result'] = $message;
        } else {
            $message = "C户【" . $userinfo['loginno'] . "】重置登录密码失败！";
            \service\tools\logger\LoggerClass::error($message);
            $result = \service\tools\ToolsClass::buildJSONError($message);
        }
    } else {
        $message = "C户【" . $userinfo['loginno'] . "】重置登录密码失败：没有找到对应的登录账户";
        \service\tools\logger\LoggerClass::error($message);
        $result = \service\tools\ToolsClass::buildJSONError($message);
    }
    echo json_encode($result);
    die();
}

/**
 * 新增虚拟账户
 */
function doAddSubAccount()
{
    $authuserid = doValidateAuth($_POST['authloginno'], $_POST['authpassword']);
    if ($authuserid == '') {
        $message = "操作授权失败！";
        \service\tools\logger\LoggerClass::error($message);
        echo $message;
        die();
    }
    $commonTools = new \service\tools\ToolsClass();
    $accountType = $_POST['type'];
    $custid = $_REQUEST['accountid'];
    $type_validate = $commonTools->getDatasBySQL("select * from acc_dic_account_type where type='" . $accountType . "' and status=1");
    if (count($type_validate) == 0) {
        $message = "新增虚拟账户失败：账户类型不合法！";
        \service\tools\logger\LoggerClass::error($message);
        echo $message;
        die();
    }
    $accountCode = $type_validate[0]['code'];
    $type_validate = $commonTools->getDatasBySQL("select * from acc_cust_subaccount where type='" . $accountType . "' and custid='" . $custid . "'");
    if (count($type_validate) > 0) {
        $message = "新增虚拟账户失败：该账户类型已存在！";
        \service\tools\logger\LoggerClass::error($message);
        echo $message;
        die();
    }
    $code = generateSubaccountCode($custid, $accountCode);
    $status = $_POST['statusname'] == '启用' ? 1 : 0;
    $sql = "insert into acc_cust_subaccount(id,custid,type,code,balance,createdate,status,edituserid,authuserid) values('" . \service\tools\common\UUIDClass::getUUID() . "','" . $custid . "','" . $accountType . "','" . $code . "',0,'" . \service\tools\ToolsClass::getNowTime() . "'," . $status . ",'" . \portal\service\tools\ToolsClass::getUser()->getId() . "','" . $authuserid . "')";
    if ($commonTools->doExecuteSQL($sql)) {
        echo 'true';
    } else {
        $message = "新增虚拟账户失败：数据库操作异常！";
        \service\tools\logger\LoggerClass::error($message);
        echo $message;
    }
    die();
}

/**
 * 更新虚拟账户
 */
function doEditSubAccount()
{
    $authuserid = doValidateAuth($_POST['authloginno'], $_POST['authpassword']);
    if ($authuserid == '') {
        $message = "操作授权失败！";
        \service\tools\logger\LoggerClass::error($message);
        echo $message;
        die();
    }
    $commonTools = new \service\tools\ToolsClass();
    $accountType = $_POST['type'];
    $custid = $_REQUEST['accountid'];
    $type_validate = $commonTools->getDatasBySQL("select * from acc_dic_account_type where type='" . $accountType . "' and status=1");
    if (count($type_validate) == 0) {
        $message = "修改虚拟账户失败：账户类型不合法！";
        \service\tools\logger\LoggerClass::error($message);
        echo $message;
        die();
    }
    $type_validate = $commonTools->getDatasBySQL("select * from acc_cust_subaccount where type='" . $accountType . "' and custid='" . $custid . "' and id<>'" . $_POST['id'] . "'");
    if (count($type_validate) > 0) {
        $message = "修改虚拟账户失败：该账户类型已存在！";
        \service\tools\logger\LoggerClass::error($message);
        echo $message;
        die();
    }
    $type_validate = $commonTools->getDatasBySQL("select * from acc_cust_subaccount where id='" . $_POST['id'] . "'")[0];
    if ($type_validate['type'] != $accountType) {
        $message = "修改虚拟账户失败：不能修改账户类型！";
        \service\tools\logger\LoggerClass::error($message);
        echo $message;
        die();
    }
    $status = $_POST['statusname'] == '启用' ? 1 : 0;
    $sql = "update acc_cust_subaccount set status=" . $status . ",edituserid='" . \portal\service\tools\ToolsClass::getUser()->getId() . "',authuserid='" . $authuserid . "' where id='" . $_POST['id'] . "'";
    if ($commonTools->doExecuteSQL($sql)) {
        echo 'true';
    } else {
        $message = "修改虚拟账户失败：数据库操作异常！";
        \service\tools\logger\LoggerClass::error($message);
        echo $message;
    }
    die();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['oper'])) {
        /* 普通请求指令 */
        switch ($_POST['oper']) {
            case "updateBasic":
                doUpdateBasic(intval($_POST['status']));
                break;
            case "rpw":
                doResetPassword();
                break;
            case "add":
                doAddSubAccount();
                break;
            case "edit":
                doEditSubAccount();
                break;
            case "del":
                echo "不允许删除虚拟账户";
                break;
            case "getBindList":
                doSearchBindList();
                break;
        }
    } else {
        /* jqgrid 查询指令 */
        switch ($_POST['cmd']) {
            case "subaccount":
                $sqlArray = array();
                $sqlArray[0] = "*";
                $sqlArray[1] = "(select id,custid,type,code,balance,money,createdate,case status when 1 then '启用' else '禁用' end as statusname from acc_cust_subaccount where custid='" . $_POST['accountid'] . "')t";
                $result = doQuery($sqlArray);
                break;
            default:
                $search_custid = $_POST['search_custid'];
                $search_telephone = $_POST['search_telephone'];
                $search_channel = $_POST['search_channel'];
                $search_status = $_POST['search_status'];
                $sqlArray = array();
                $sqlArray[0] = "*";
                $sqlArray[1] = "acc_cust_account";
                $sqlArray[2] = "where 1=1 ";
                if ($search_custid != '') {
                    $sqlArray[2] = $sqlArray[2] . "and custid='$search_custid' ";
                }
                if ($search_channel != '') {
                    $sqlArray[2] = $sqlArray[2] . "and channel='$search_channel' ";
                }
                if ($search_telephone != '') {
                    $sqlArray[2] = $sqlArray[2] . "and telephone='$search_telephone' ";
                }
                if ($search_status != '') {
                    $sqlArray[2] = $sqlArray[2] . "and status=$search_status ";
                }
                $result = doQuery($sqlArray, -1, 'custid');
        }
        echo json_encode($result);
        die();
    }
}