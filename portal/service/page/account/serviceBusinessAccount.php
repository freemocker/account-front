<?php
/**
 * Created by PhpStorm.
 * User: zhang
 * Date: 2016/8/17
 * Time: 22:12
 */
use portal\service\tools\ToolsClass;

require dirname(__FILE__) . '/../../../view/common/serviceHead.php';
require $_SERVER['DOCUMENT_ROOT'] . '/service/base/baseQuery.php';

/**
 * 生成B账户客户号
 * @param $regioncode
 * @return string
 */
function generateBusinessid($regioncode)
{
    $result = "";
    $commonTools = new \service\tools\ToolsClass();
    $region = $commonTools->getDatasBySQL("select * from acc_dic_region where code='" . $regioncode . "' and status=1");
    if (count($region) > 0) {
        $connection = $commonTools->getDBConnection();
        $connection->beginTransaction();
        $userid = \portal\service\tools\ToolsClass::getUser()->getId();
        $nowstr = \service\tools\ToolsClass::getNowTime();
        $timestamp = date('YmdHis') . str_pad(floor(explode(" ", microtime())[0] * 1000), 3, '0', STR_PAD_LEFT);
        $searchResult = $connection->doQuery("select number from acc_customerid_serial where regioncode='" . $regioncode . "' and custtype=1 and `timestamp`='" . $timestamp . "' for update")->fetchAll();
        $number = 1;
        if (count($searchResult) > 0) {
            $number = intval($searchResult[0]['number']);
            $sql = "update acc_customerid_serial set number=" . ($number + 1) . " where regioncode='" . $regioncode . "' and custtype=1 and `timestamp`='" . $timestamp . "'";
        } else {
            $sql = "insert into acc_customerid_serial(id,regioncode,custtype,`timestamp`,number,createdate,modifydate,userid) 
                values('" . \service\tools\common\UUIDClass::getUUID() . "','" . $regioncode . "',1,'" . $timestamp . "',2,'" . $nowstr . "','" . $nowstr . "','" . $userid . "')";
        }
        if ($number > 999) {
            $connection->rollBack();
        } else {
            if ($connection->doExcute($sql)) {
                $connection->commit();
                $result = $regioncode . "1" . $timestamp . str_pad($number . '', 3, '0', STR_PAD_LEFT);
            } else {
                $connection->rollBack();
            }
        }
    }
    return $result;
}

/**
 * 生成B账户渠道号
 * @param $regioncode
 * @param $industrycode
 * @return string
 */
function generateBusinessChannel($regioncode, $industrycode)
{
    $result = "";
    $commonTools = new \service\tools\ToolsClass();
    $region = $commonTools->getDatasBySQL("select * from acc_dic_region where code='" . $regioncode . "' and status=1");
    $industry = $commonTools->getDatasBySQL("select * from acc_dic_industry where code='" . $industrycode . "' and status=1");
    if (count($region) > 0 && count($industry) > 0) {
        $connection = $commonTools->getDBConnection();
        $connection->beginTransaction();
        $userid = \portal\service\tools\ToolsClass::getUser()->getId();
        $nowstr = \service\tools\ToolsClass::getNowTime();
        $searchResult = $connection->doQuery("select number from acc_business_channel where regioncode='" . $regioncode . "' and industrycode='" . $industrycode . "' for update")->fetchAll();
        $number = 1;
        if (count($searchResult) > 0) {
            $number = intval($searchResult[0]['number']);
            $sql = "update acc_business_channel set number=" . ($number + 1) . " where regioncode='" . $regioncode . "' and industrycode='" . $industrycode . "'";
        } else {
            $sql = "insert into acc_business_channel(id,regioncode,industrycode,number,createdate,modifydate,userid) 
                values('" . \service\tools\common\UUIDClass::getUUID() . "','" . $regioncode . "','" . $industrycode . "',2,'" . $nowstr . "','" . $nowstr . "','" . $userid . "')";
        }
        if ($number > 9999) {
            $connection->rollBack();
        } else {
            if ($connection->doExcute($sql)) {
                $connection->commit();
                $result = $regioncode . $industrycode . str_pad($number . '', 4, '0', STR_PAD_LEFT);
            } else {
                $connection->rollBack();
            }
        }
    }
    return $result;
}

/**
 * 生成虚拟账户编码
 * @param $businessid
 * @param $accountType
 * @return string
 */
function generateSubaccountCode($businessid, $accountType)
{
    $result = $businessid;
    $result = $result . $accountType;
    $result = $result . str_pad(mt_rand(0, 999), 3, '0', STR_PAD_LEFT);
    return $result;
}

/**
 * 获取树形选择节点
 */
function getSelectTree()
{
    $commonTools = new \service\tools\ToolsClass();
    $dic_tablename = $_POST['tablename'];
    $selectall = $_POST['selectall'];
    if ($selectall == "true") {
        $nodes = $commonTools->getDatasBySQL("select t.id,t.name,t.code,t.parentid as pId,'false' as nocheck from " . $dic_tablename . " t order by t.code asc");
    } else {
        $nodes = $commonTools->getDatasBySQL("select t.id,t.name,t.code,t.parentid as pId,case when t.id in (select tp.parentid from " . $dic_tablename . " tp) then 'true' else 'false' end as nocheck from " . $dic_tablename . " t order by t.code asc");
    }
    if (count($nodes) > 0) {
        $result = array();
        foreach ($nodes as $node) {
            $obj['id'] = $node['id'];
            $obj['name'] = $node['name'] . '(' . $node['code'] . ')';
            $obj['pId'] = $node['pid'];
            $obj['nocheck'] = $node['nocheck'];
            array_push($result, $obj);
        }
        echo json_encode($result);
    } else {
        echo \service\tools\ToolsClass::buildJSONErrorStr("没有节点");
    }
    die();
}

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
            if (!\service\user\UserManagerClass::validatePermissions($GLOBALS['application']->getId(), $authuserid, 'business_account_power')) {
                $authuserid = '';
            }
        }
    }
    return $authuserid;
}

/**
 * 删除B户信息
 */
function doDeleteAccount()
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
    $objlist = json_decode($_POST['objs'], true);
    foreach ($objlist as $obj) {
        /* 判断是否存在关联的C户 */
        $cusAccount = $commonTools->getDatasBySQL("select ca.custid from acc_cust_account ca inner join acc_business_account ba on ca.channel=ba.channel where ba.id='" . $obj['id'] . "'");
        if (count($cusAccount) > 0) {
            $message = "删除失败：客户号【" . $obj['businessid'] . "】下存在C类账户！";
            \service\tools\logger\LoggerClass::error($message);
            $result = \service\tools\ToolsClass::buildJSONError($message);
            echo json_encode($result);
            die();
        }
        $subAccount = $commonTools->getDatasBySQL("select * from acc_business_subaccount where businessid='" . $obj['businessid'] . "' and balance>0.00");
        if (count($subAccount) > 0) {
            $message = "删除失败：客户号【" . $obj['businessid'] . "】虚拟账户余额不为零！";
            \service\tools\logger\LoggerClass::error($message);
            $result = \service\tools\ToolsClass::buildJSONError($message);
            echo json_encode($result);
            die();
        }
        /* 删除B账户信息 */
        $connection->addBatch("delete from acc_business_bindinfo where businessid='" . $obj['businessid'] . "'");
        $connection->addBatch("delete from acc_business_subaccount where businessid='" . $obj['businessid'] . "'");
        $connection->addBatch("delete from acc_business_account where id='" . $obj['id'] . "'");
        /* 删除系统用户信息 */
        $sysConn->addBatch("delete from T_user_department_set where userid='" . $obj['userid'] . "'");
        $sysConn->addBatch("delete from T_user_role_set where userid='" . $obj['userid'] . "'");
        $sysConn->addBatch("delete from T_user_info where userid='" . $obj['userid'] . "'");
        $sysConn->addBatch("delete from T_user_LoginRecord where userid='" . $obj['userid'] . "'");
        $sysConn->addBatch("delete from T_user_Configuration where userid='" . $obj['userid'] . "'");
        $sysConn->addBatch("delete from T_user where id='" . $obj['userid'] . "'");
    }
    $connection->beginTransaction();
    $sysConn->beginTransaction();
    if ($connection->doExecBatch() && $sysConn->doExecBatch()) {
        $connection->commit();
        $sysConn->commit();
        $config = \portal\config\PortalConfig::getInstance();
        $systemConfig = \config\SystemConfig::getInstance();
        $charset = $systemConfig['charset'];
        $oscharset = $systemConfig['os_charset'];
        foreach ($objlist as $obj) {
            $filepath = $_SERVER['DOCUMENT_ROOT'] . $config["img"]["uploadBacountUrl"] . $obj['regioncode'] . '/' . $obj['industrycode'] . '/' . $obj['id'];
            $filepath = str_replace("/", DIRECTORY_SEPARATOR, $filepath);
            $filepath = str_replace("\\", DIRECTORY_SEPARATOR, $filepath);
            $filename = iconv($charset, $oscharset, $filepath);
            \service\tools\ToolsClass::deleteDirOrFile($filename);
        }
        $result = array("result" => "删除成功！");
    } else {
        $connection->rollBack();
        $sysConn->rollBack();
        \service\tools\logger\LoggerClass::error("删除B户失败：数据库异常");
        $result = \service\tools\ToolsClass::buildJSONError("删除B户失败！");
    }
    echo json_encode($result);
    die();
}

/**
 * 重置B户登录账号密码
 */
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
    $accountinfo = $commonTools->getDatasBySQL("select * from acc_business_account where id='" . $_POST['id'] . "'")[0];
    $userid = $accountinfo['userid'];
    $loginno = $accountinfo['email'];
    if (!$sysTools->doExecuteSQL("update t_user set loginno='$loginno' where id='$userid'")) {
        $message = "B户【" . $loginno . "】重置登录密码失败！";
        \service\tools\logger\LoggerClass::error($message);
        $result = \service\tools\ToolsClass::buildJSONError($message);
        echo json_encode($result);
        die();
    }
    $userinfo = $sysTools->getDatasBySQL("select u.id,u.loginno from T_user u where u.id='" . $userid . "'");
    if (count($userinfo) > 0) {
        $userinfo = $userinfo[0];
        if (\service\user\UserManagerClass::resetPassword($userinfo['id'], $userinfo['loginno'], $portalconfig['defaultPassword'])) {
            $commonTools->doExecuteSQL("update acc_business_account set edituserid='" . \portal\service\tools\ToolsClass::getUser()->getId() . "',authuserid='" . $authuserid . "'");
            $message = "B户【" . $userinfo['loginno'] . "】重置登录密码成功！";
            \service\tools\logger\LoggerClass::info($message);
            $result['result'] = $message;
        } else {
            $message = "B户【" . $userinfo['loginno'] . "】重置登录密码失败！";
            \service\tools\logger\LoggerClass::error($message);
            $result = \service\tools\ToolsClass::buildJSONError($message);
        }
    } else {
        $message = "B户【" . $userinfo['loginno'] . "】重置登录密码失败：没有找到对应的登录账户";
        \service\tools\logger\LoggerClass::error($message);
        $result = \service\tools\ToolsClass::buildJSONError($message);
    }
    echo json_encode($result);
    die();
}

function doRebuildKey()
{
    $authuserid = doValidateAuth($_POST['authloginno'], $_POST['authpassword']);
    if ($authuserid == '') {
        $message = "操作授权失败！";
        \service\tools\logger\LoggerClass::error($message);
        $result = \service\tools\ToolsClass::buildJSONError($message);
        echo json_encode($result);
        die();
    }
    $commonTools = new \service\tools\ToolsClass();
    $sql = "update acc_business_account set businesskey=?,edituserid=?,authuserid=? where id=?";
    $params = array();
    $key = \service\tools\common\UUIDClass::getUUID();
    $params[0] = $key;
    $params[1] = ToolsClass::getUser()->getId();
    $params[2] = $authuserid;
    $params[3] = $_POST['id'];
    if ($commonTools->doExecuteSQLByPre($sql, $params)) {
        $result = array('result' => '生成成功！', 'key' => $key);
    } else {
        $message = "重新生成安全校验key失败！";
        \service\tools\logger\LoggerClass::error($message . " sql=" . $sql);
        $result = \service\tools\ToolsClass::buildJSONError($message);
    }
    echo json_encode($result);
    die();
}

/**
 * 保存B户基础信息
 * @param $status
 */
function doSaveBasic($status)
{
    $sysTools = new \service\tools\ToolsClass(0);
    $commonTools = new \service\tools\ToolsClass();
    $id = $_POST['id'];
    if ($id == null || $id == "") {
        $id = \service\tools\common\UUIDClass::getUUID();
        $currUser = portal\service\tools\ToolsClass::getUser();
        $sql = "insert into acc_business_account(businessname,regionname,regioncode,industryname,industrycode,isdefault,name,
certtype,certno,telephone,bankaccount,accountname,bank,status,settlementtype,email,id,businessid,userid,businesslicense,certpicture,
createdate,creator,channel) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,'','','','','" . \service\tools\ToolsClass::getNowTime() . "','" . $currUser->getId() . "','')";
    } else {
        $sql = "update acc_business_account set businessname=?,regionname=?,regioncode=?,industryname=?,industrycode=?,isdefault=?,name=?,certtype=?,certno=?,telephone=?,bankaccount=?,accountname=?,bank=?,status=?,settlementtype=?,email=? where id=?";
    }
    $params = array();
    if (!doValidate($_POST['businessname'])) {
        $result = \service\tools\ToolsClass::buildJSONError("请填写B户名称");
        echo json_encode($result);
        die();
    }
    $params[0] = $_POST['businessname'];
    $params[1] = $_POST['regionname'];
    if (!doValidate($_POST['regioncode'])) {
        $result = \service\tools\ToolsClass::buildJSONError("请选择行政区域");
        echo json_encode($result);
        die();
    }
    $params[2] = $_POST['regioncode'];
    $params[3] = $_POST['industryname'];
    if (!doValidate($_POST['industrycode'])) {
        $result = \service\tools\ToolsClass::buildJSONError("请选择行业分类");
        echo json_encode($result);
        die();
    }
    $params[4] = $_POST['industrycode'];
    if ($_POST['isdefault'] == '1') {
        $tmpval1 = $commonTools->getDatasBySQL("select * from acc_business_account where isdefault='" . $_POST['isdefault'] . "' and id<>'" . $id . "'");
        if (count($tmpval1) > 0) {
            $result = \service\tools\ToolsClass::buildJSONError("账务平台B户已存在");
            echo json_encode($result);
            die();
        }
    }
    $params[5] = $_POST['isdefault'];
    if (!doValidate($_POST['name'])) {
        $result = \service\tools\ToolsClass::buildJSONError("请填写法人名称");
        echo json_encode($result);
        die();
    }
    $params[6] = $_POST['name'];
    $params[7] = $_POST['certtype'];
    if (!doValidate($_POST['certno'])) {
        $result = \service\tools\ToolsClass::buildJSONError("请输入法人证件号码");
        echo json_encode($result);
        die();
    } else {
        $preg = $commonTools->getDatasBySQL("select remark from acc_dic_certtype where code='" . $_POST['certtype'] . "'")[0]['remark'];
        if (doValidate($preg)) {
            if (!preg_match($preg, $_POST['certno'])) {
                $result = \service\tools\ToolsClass::buildJSONError("请输入有效的法人证件号码");
                echo json_encode($result);
                die();
            }
        }
    }
    $params[8] = $_POST['certno'];
    if (!doValidate($_POST['telephone'])) {
        $result = \service\tools\ToolsClass::buildJSONError("请输入预留电话号码");
        echo json_encode($result);
        die();
    }
    $params[9] = $_POST['telephone'];
    $params[10] = $_POST['bankaccount'];
    $params[11] = $_POST['accountname'];
    $params[12] = $_POST['bank'];
    $params[13] = $status;
    $params[14] = $_POST['settlementtype'];
    if (!doValidate($_POST['email'])) {
        $result = \service\tools\ToolsClass::buildJSONError("请输入邮箱");
        echo json_encode($result);
        die();
    } else {
        $tmpval1 = $commonTools->getDatasBySQL("select * from acc_business_account where email='" . $_POST['email'] . "' and id<>'" . $id . "'");
        $tmpval2 = $sysTools->getDatasBySQL("select * from t_user where loginno='" . $_POST['email'] . "'");
        if (count($tmpval1) > 0 || count($tmpval2) > 0) {
            $result = \service\tools\ToolsClass::buildJSONError("邮箱已被注册");
            echo json_encode($result);
            die();
        }
    }
    $params[15] = $_POST['email'];
    $params[16] = $id;
    if ($commonTools->doExecuteSQLByPre($sql, $params)) {
        $result = array();
        $result["id"] = $id;
        $result["result"] = "保存基础信息成功！";
    } else {
        $message = "B户【" . $_POST['businessname'] . "】保存失败！";
        \service\tools\logger\LoggerClass::error($message . "sql=" . $sql);
        $result = \service\tools\ToolsClass::buildJSONError($message);
    }
    echo json_encode($result);
    die();
}

/**
 * 修改B户基本信息
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
    $commonTools = new \service\tools\ToolsClass();
    $id = $_POST['id'];
    $sql = "update acc_business_account set businessname=?,regionname=?,regioncode=?,industryname=?,industrycode=?,telephone=?,bankaccount=?,accountname=?,bank=?,status=?,settlementtype=?,edituserid=?,authuserid=?,name=?,certtype=?,certno=?,email=? where id=?";
    $params = array();
    if (!doValidate($_POST['businessname'])) {
        $result = \service\tools\ToolsClass::buildJSONError("请填写B户名称");
        echo json_encode($result);
        die();
    }
    $params[0] = $_POST['businessname'];
    $params[1] = $_POST['regionname'];
    if (!doValidate($_POST['regioncode'])) {
        $result = \service\tools\ToolsClass::buildJSONError("请选择行政区域");
        echo json_encode($result);
        die();
    }
    $params[2] = $_POST['regioncode'];
    $params[3] = $_POST['industryname'];
    if (!doValidate($_POST['industrycode'])) {
        $result = \service\tools\ToolsClass::buildJSONError("请选择行业分类");
        echo json_encode($result);
        die();
    }
    $params[4] = $_POST['industrycode'];
    if (!doValidate($_POST['telephone'])) {
        $result = \service\tools\ToolsClass::buildJSONError("请输入预留电话号码");
        echo json_encode($result);
        die();
    }
    $params[5] = $_POST['telephone'];
    $params[6] = $_POST['bankaccount'];
    $params[7] = $_POST['accountname'];
    $params[8] = $_POST['bank'];
    $params[9] = $status;
    $params[10] = $_POST['settlementtype'];
    $params[11] = ToolsClass::getUser()->getId();
    $params[12] = $authuserid;
    if (!doValidate($_POST['name'])) {
        $result = \service\tools\ToolsClass::buildJSONError("请输入法人姓名");
        echo json_encode($result);
        die();
    }
    $params[13] = $_POST['name'];
    $params[14] = $_POST['certtype'];
    if (!doValidate($_POST['certno'])) {
        $result = \service\tools\ToolsClass::buildJSONError("请输入证件号码");
        echo json_encode($result);
        die();
    }
    $params[15] = $_POST['certno'];
    if (!doValidate($_POST['email'])) {
        $result = \service\tools\ToolsClass::buildJSONError("请输入邮箱");
        echo json_encode($result);
        die();
    }
    $params[16] = $_POST['email'];
    $params[17] = $id;
    if ($commonTools->doExecuteSQLByPre($sql, $params)) {
        $result = array();
        $result["id"] = $id;
        $result["result"] = "保存基础信息成功！";
    } else {
        $message = "B户【" . $_POST['businessname'] . "】保存失败！";
        \service\tools\logger\LoggerClass::error($message . "sql=" . $sql);
        $result = \service\tools\ToolsClass::buildJSONError($message);
    }
    echo json_encode($result);
    die();
}

/**
 * 保存上传的图片信息
 */
function doSaveImage()
{
    $commonTools = new \service\tools\ToolsClass();
    $currUser = portal\service\tools\ToolsClass::getUser();
    $fieldname = $_POST['fieldname'];
    $sql = "update acc_business_account set " . $fieldname . "=? where id=?";
    $params = array();
    if ($_POST['urls'] != "") {
        $urls = explode(";", $_POST['urls']);
        $imgs = array();
        foreach ($urls as $url) {
            $img = array();
            $img['description'] = "";
            $img['id'] = "";
            $img['linkurl'] = $url;
            $img['type'] = 0;
            $img['uploaddate'] = \service\tools\ToolsClass::getNowTime();
            $img['uploaduser'] = $currUser->getId();
            array_push($imgs, $img);
        }
        $params[0] = json_encode($imgs);
    } else {
        $params[0] = "";
    }
    $params[1] = $_POST['id'];
    if ($commonTools->doExecuteSQLByPre($sql, $params)) {
        $result = array();
        $result["result"] = "保存成功";
    } else {
        $message = "保存图片失败！";
        \service\tools\logger\LoggerClass::error($message . "sql=" . $sql);
        $result = \service\tools\ToolsClass::buildJSONError($message);
    }
    echo json_encode($result);
    die();
}

/**
 * 注册B类账户
 */
function doRegister()
{
    $yzm = $_POST['yzm'];
    if ($yzm != $_SESSION[ToolsClass::$LOGIN_YZM_STR]) {
        $message = "注册B户失败：验证码输入错误！";
        \service\tools\logger\LoggerClass::error($message);
        $result = \service\tools\ToolsClass::buildJSONError($message);
        echo json_encode($result);
        die();
    }
    if (!\service\user\UserManagerClass::validatePermissions($GLOBALS['application']->getId(), ToolsClass::getUser()->getId(), 'business_register_review')) {
        $message = "注册B户失败：没有复核权限！";
        \service\tools\logger\LoggerClass::error($message);
        $result = \service\tools\ToolsClass::buildJSONError($message);
        echo json_encode($result);
        die();
    }
    $sysTools = new \service\tools\ToolsClass(0);
    $sysConn = $sysTools->getDBConnection();
    $commonTools = new \service\tools\ToolsClass();
    $connection = $commonTools->getDBConnection();

    $accountType = $commonTools->getDatasBySQL("select * from acc_dic_account_type");

    $connection->beginTransaction();
    $sysConn->beginTransaction();
    $id = $_POST['id'];
    $businessinfo = $connection->doQuery("select * from acc_business_account where id='" . $id . "' for update")->fetchAll();
    if (count($businessinfo) > 0) {
        $businessinfo = $businessinfo[0];
        $regioncode = $businessinfo['regioncode'];
        $industrycode = $businessinfo['industrycode'];
        $email = $businessinfo['email'];
        $vs = $sysConn->doQuery("select * from t_user where loginno='" . $email . "' for update")->fetchAll();
        if (count($vs) > 0) {
            $connection->rollBack();
            $sysConn->rollBack();
            $message = "注册B户失败：邮箱【" . $email . "】已有绑定用户！";
            \service\tools\logger\LoggerClass::error($message);
            $result = \service\tools\ToolsClass::buildJSONError($message);
            echo json_encode($result);
            die();
        }
        $businessid = generateBusinessid($regioncode);
        if ($businessid == "") {
            $connection->rollBack();
            $sysConn->rollBack();
            $message = "注册B户失败：生成客户号失败！";
            \service\tools\logger\LoggerClass::error($message);
            $result = \service\tools\ToolsClass::buildJSONError($message);
            echo json_encode($result);
            die();
        }
        $channel = generateBusinessChannel($regioncode, $industrycode);
        if ($channel == "") {
            $connection->rollBack();
            $sysConn->rollBack();
            $message = "注册B户失败：生成渠道号失败！";
            \service\tools\logger\LoggerClass::error($message);
            $result = \service\tools\ToolsClass::buildJSONError($message);
            echo json_encode($result);
            die();
        }
        $userid = \service\tools\common\UUIDClass::getUUID();
        $rolenames = array("B类客户管理员");
        $businesskey = str_replace("-", "", \service\tools\common\UUIDClass::getUUID());
        $config = \portal\config\PortalConfig::getInstance();
        $sysConn->addBatch("insert into T_User(id,name,loginno,password,levels,status,sort) values('" . $userid . "','" . $businessinfo['businessname'] . "','" . $email . "','" . strtolower(md5(strtolower(md5($config['defaultPassword'])) . $email)) . "',99,1,99)");
        foreach ($rolenames as $rolename) {
            $sysConn->addBatch("insert into T_User_Role_Set(id,userid,roleid) values('" . \service\tools\common\UUIDClass::getUUID() . "','" . $userid . "', (select r.id from t_role r where r.name='$rolename' and appid='" . $GLOBALS['application']->getId() . "'));");
        }
        $connection->addBatch("update acc_business_account set userid='" . $userid . "',businessid='" . $businessid . "',channel='" . $channel . "',businesskey='" . $businesskey . "',status=1 where id='" . $id . "'");
        $subaccounts = array();
        foreach ($accountType as $item) {
            $subaccount = array();
            $subaccount['type'] = $item['name'];
            $subaccount['code'] = generateSubaccountCode($businessid, $item['code']);
            $subaccount['createdate'] = \service\tools\ToolsClass::getNowTime();
            $connection->addBatch("insert into acc_business_subaccount(id,businessid,type,isdefault,code,balance,money,createdate,status) values('" . \service\tools\common\UUIDClass::getUUID() . "','" . $businessid . "','" . $item['type'] . "',0,'" . $subaccount['code'] . "',0.00,0.00,'" . $subaccount['createdate'] . "',1)");
            array_push($subaccounts, $subaccount);
        }
        if ($connection->doExecBatch() && $sysConn->doExecBatch()) {
            $connection->commit();
            $sysConn->commit();
            $result['businessname'] = $businessinfo['businessname'];
            $result['businessid'] = $businessid;
            $result['channel'] = $channel;
            $result['id'] = $id;
            $result['businesskey'] = $businesskey;
            $result['loginno'] = $email;
            $result['password'] = $config['defaultPassword'];
            $result['subaccount'] = $subaccounts;
        } else {
            $connection->rollBack();
            $sysConn->rollBack();
            \service\tools\logger\LoggerClass::error("注册B户失败：数据库异常");
            $result = \service\tools\ToolsClass::buildJSONError("注册B户失败！");
        }
    } else {
        $connection->rollBack();
        $sysConn->rollBack();
        $message = "B户注册失败：没有找到所填信息";
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
    $businessid = $commonTools->getDatasBySQL("select businessid from acc_business_account where id='" . $_REQUEST['accountid'] . "'")[0]['businessid'];
    $type_validate = $commonTools->getDatasBySQL("select * from acc_dic_account_type where type='" . $accountType . "' and status=1");
    if (count($type_validate) == 0) {
        $message = "新增虚拟账户失败：账户类型不合法！";
        \service\tools\logger\LoggerClass::error($message);
        echo $message;
        die();
    }
    $accountCode = $type_validate[0]['code'];
    $type_validate = $commonTools->getDatasBySQL("select * from acc_business_subaccount where type='" . $accountType . "' and businessid='" . $businessid . "'");
    if (count($type_validate) > 0) {
        $message = "新增虚拟账户失败：该账户类型已存在！";
        \service\tools\logger\LoggerClass::error($message);
        echo $message;
        die();
    }
    $isdefault = $_POST['isdefaultname'] == '是' ? 1 : 0;
    $code = generateSubaccountCode($businessid, $accountCode);
    $status = $_POST['statusname'] == '启用' ? 1 : 0;
    $sql = "insert into acc_business_subaccount(id,businessid,type,isdefault,code,balance,createdate,status,edituserid,authuserid) values('" . \service\tools\common\UUIDClass::getUUID() . "','" . $businessid . "','" . $accountType . "'," . $isdefault . ",'" . $code . "',0,'" . \service\tools\ToolsClass::getNowTime() . "'," . $status . ",'" . ToolsClass::getUser()->getId() . "','" . $authuserid . "')";
    $connection = $commonTools->getDBConnection();
    if ($isdefault === 1) {
        $connection->addBatch("update acc_business_subaccount set isdefault=0 where businessid='" . $businessid . "'");
    }
    $connection->addBatch($sql);
    if ($connection->doExecBatch()) {
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
    $businessid = $commonTools->getDatasBySQL("select businessid from acc_business_account where id='" . $_REQUEST['accountid'] . "'")[0]['businessid'];
    $type_validate = $commonTools->getDatasBySQL("select * from acc_dic_account_type where type='" . $accountType . "' and status=1");
    if (count($type_validate) == 0) {
        $message = "修改虚拟账户失败：账户类型不合法！";
        \service\tools\logger\LoggerClass::error($message);
        echo $message;
        die();
    }
    $type_validate = $commonTools->getDatasBySQL("select * from acc_business_subaccount where type='" . $accountType . "' and businessid='" . $businessid . "' and id<>'" . $_POST['id'] . "'");
    if (count($type_validate) > 0) {
        $message = "修改虚拟账户失败：该账户类型已存在！";
        \service\tools\logger\LoggerClass::error($message);
        echo $message;
        die();
    }
    $type_validate = $commonTools->getDatasBySQL("select * from acc_business_subaccount where id='" . $_POST['id'] . "'")[0];
    if ($type_validate['type'] != $accountType) {
        $message = "修改虚拟账户失败：不能修改账户类型！";
        \service\tools\logger\LoggerClass::error($message);
        echo $message;
        die();
    }
    $isdefault = $_POST['isdefaultname'] == '是' ? 1 : 0;
    $status = $_POST['statusname'] == '启用' ? 1 : 0;
    $sql = "update acc_business_subaccount set isdefault=" . $isdefault . ",status=" . $status . ",edituserid='" . ToolsClass::getUser()->getId() . "',authuserid='" . $authuserid . "' where id='" . $_POST['id'] . "'";
    $connection = $commonTools->getDBConnection();
    if ($isdefault === 1) {
        $connection->addBatch("update acc_business_subaccount set isdefault=0 where businessid='" . $businessid . "'");
    }
    $connection->addBatch($sql);
    if ($connection->doExecBatch()) {
        echo 'true';
    } else {
        $message = "修改虚拟账户失败：数据库操作异常！";
        \service\tools\logger\LoggerClass::error($message);
        echo $message;
    }
    die();
}

/**
 * 获取绑定信息列表
 */
function doSearchBindList()
{
    $commonTools = new \service\tools\ToolsClass();
    $businessid = $commonTools->getDatasBySQL("select businessid from acc_business_account where id='" . $_REQUEST['accountid'] . "'")[0]['businessid'];
    $result = $commonTools->getDatasBySQL("select bb.id,bb.businessid,bb.type,bb.account,bb.partner,bb.seller_email,(select db.remark from acc_dic_b_bindtype db where db.code=bb.type and db.status=1) as bindno,case bb.isdefault when 1 then '默认' else '' end as isdefault,case bb.status when 1 then '激活' else '禁用' end as status,bb.createdate from acc_business_bindinfo bb where bb.businessid='" . $businessid . "' order by bb.isdefault desc,bb.type asc");
    echo json_encode($result);
}

/**
 * 禁用绑定信息
 */
function doDisabledBindInfo()
{
    $authuserid = doValidateAuth($_POST['authloginno'], $_POST['authpassword']);
    if ($authuserid == '') {
        $message = "操作授权失败！";
        \service\tools\logger\LoggerClass::error($message);
        $result = \service\tools\ToolsClass::buildJSONError($message);
        echo json_encode($result);
        die();
    }
    $commonTools = new \service\tools\ToolsClass();
    $id = $_POST['id'];
    $isdefault = intval($commonTools->getDatasBySQL("select isdefault from acc_business_bindinfo where id='" . $id . "'")[0]['isdefault']);
    if ($isdefault == 1) {
        $message = '"默认"状态不能禁用！';
        \service\tools\logger\LoggerClass::error($message);
        $result = \service\tools\ToolsClass::buildJSONError($message);
        echo json_encode($result);
        die();
    }
    $sql = "update acc_business_bindinfo set status=0,edituserid='" . ToolsClass::getUser()->getId() . "',authuserid='" . $authuserid . "' where id='" . $id . "'";
    if ($commonTools->doExecuteSQL($sql)) {
        $result = array("result" => "禁用成功！");
    } else {
        $message = '禁用失败：数据库异常！';
        \service\tools\logger\LoggerClass::error($message . " sql=" . $sql);
        $result = \service\tools\ToolsClass::buildJSONError($message);
    }
    echo json_encode($result);
    die();
}

/**
 * 激活绑定信息
 */
function doEnabledBindInfo()
{
    $authuserid = doValidateAuth($_POST['authloginno'], $_POST['authpassword']);
    if ($authuserid == '') {
        $message = "操作授权失败！";
        \service\tools\logger\LoggerClass::error($message);
        $result = \service\tools\ToolsClass::buildJSONError($message);
        echo json_encode($result);
        die();
    }
    $commonTools = new \service\tools\ToolsClass();
    $id = $_POST['id'];
    $sql = "update acc_business_bindinfo set status=1,edituserid='" . ToolsClass::getUser()->getId() . "',authuserid='" . $authuserid . "' where id='" . $id . "'";
    if ($commonTools->doExecuteSQL($sql)) {
        $result = array("result" => "激活成功！");
    } else {
        $message = '激活失败：数据库异常！';
        \service\tools\logger\LoggerClass::error($message . " sql=" . $sql);
        $result = \service\tools\ToolsClass::buildJSONError($message);
    }
    echo json_encode($result);
    die();
}

function doDelBindInfo()
{
    $authuserid = doValidateAuth($_POST['authloginno'], $_POST['authpassword']);
    if ($authuserid == '') {
        $message = "操作授权失败！";
        \service\tools\logger\LoggerClass::error($message);
        $result = \service\tools\ToolsClass::buildJSONError($message);
        echo json_encode($result);
        die();
    }
    $commonTools = new \service\tools\ToolsClass();
    $id = $_POST['id'];
    $isdefault = intval($commonTools->getDatasBySQL("select isdefault from acc_business_bindinfo where id='" . $id . "'")[0]['isdefault']);
    if ($isdefault == 1) {
        $message = '"默认"状态不能删除！';
        \service\tools\logger\LoggerClass::error($message);
        $result = \service\tools\ToolsClass::buildJSONError($message);
        echo json_encode($result);
        die();
    }
    $sql = "delete from acc_business_bindinfo where id='" . $id . "'";
    if ($commonTools->doExecuteSQL($sql)) {
        $result = array("result" => "删除成功！");
    } else {
        $message = '删除失败：数据库异常！';
        \service\tools\logger\LoggerClass::error($message . " sql=" . $sql);
        $result = \service\tools\ToolsClass::buildJSONError($message);
    }
    echo json_encode($result);
    die();
}

function doSetDefaultBind()
{
    $authuserid = doValidateAuth($_POST['authloginno'], $_POST['authpassword']);
    if ($authuserid == '') {
        $message = "操作授权失败！";
        \service\tools\logger\LoggerClass::error($message);
        $result = \service\tools\ToolsClass::buildJSONError($message);
        echo json_encode($result);
        die();
    }
    $commonTools = new \service\tools\ToolsClass();
    $connection = $commonTools->getDBConnection();
    $id = $_POST['id'];
    $businessid = $_POST['businessid'];
    $type = $_POST['type'];
    $connection->addBatch("update acc_business_bindinfo set isdefault=0,edituserid='" . ToolsClass::getUser()->getId() . "',authuserid='" . $authuserid . "' where businessid='" . $businessid . "' and type='" . $type . "'");
    $connection->addBatch("update acc_business_bindinfo set isdefault=1,edituserid='" . ToolsClass::getUser()->getId() . "',authuserid='" . $authuserid . "' where id='" . $id . "'");
    if ($connection->doExecBatch()) {
        $result = array("result" => "设置成功！");
    } else {
        $message = '设置失败：数据库异常！';
        \service\tools\logger\LoggerClass::error($message);
        $result = \service\tools\ToolsClass::buildJSONError($message);
    }
    echo json_encode($result);
    die();
}

function doSaveBindInfo()
{
//    $authuserid = '';
    $authuserid = doValidateAuth($_POST['authloginno'], $_POST['authpassword']);
    if ($authuserid == '') {
        $message = "操作授权失败！";
        \service\tools\logger\LoggerClass::error($message);
        $result = \service\tools\ToolsClass::buildJSONError($message);
        echo json_encode($result);
        die();
    }
    $commonTools = new \service\tools\ToolsClass();
    $id = isset($_POST['id']) && $_POST['id'] != null ? $_POST['id'] : "";
    $businessid = $_POST['businessid'];
    $params = array();
    $bankname = $_POST['bankname'];
    $name = $_POST['name'];
    $telephone = $_POST['telephone'];
    $account = $_POST['account'];
    $certtype = $_POST['certtype'];
    $certno = $_POST['certno'];
    $partner = $_POST['partner'];
    $partnerkey = $_POST['partnerkey'];
    $appid = $_POST['appid'];
    $appsecret = $_POST['appsecret'];
    $appsingn = $_POST['appsingn'];
    $bundleid = $_POST['bundleid'];
    $package = $_POST['package'];
    $seller_email = $_POST['seller_email'];
    $seller_id = $_POST['seller_id'];
    $private_key = $_POST['private_key'];
    $type = $_POST['type'];
    if ($id == "") {
        $id = \service\tools\common\UUIDClass::getUUID();
        $createdate = \service\tools\ToolsClass::getNowTime();
        $sql = "insert into acc_business_bindinfo
                (bankname,name,telephone,account,certtype,certno,partner,partnerkey,appid,appsecret,appsingn,bundleid,package,seller_email,seller_id,private_key,type,edituserid,authuserid,id,businessid,isdefault,createdate,status) 
                values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,0,'" . $createdate . "',1)";
    } else {
        $createdate = "";
        $sql = "update acc_business_bindinfo set bankname=?,name=?,telephone=?,account=?,certtype=?,certno=?,partner=?,partnerkey=?,appid=?,appsecret=?,appsingn=?,bundleid=?,package=?,seller_email=?,seller_id=?,private_key=?,type=?,edituserid=?,authuserid=? where id=? and businessid=?";
    }
    $params[0] = $bankname;
    $params[1] = $name;
    $params[2] = $telephone;
    $params[3] = $account;
    $params[4] = $certtype;
    $params[5] = $certno;
    $params[6] = $partner;
    $params[7] = $partnerkey;
    $params[8] = $appid;
    $params[9] = $appsecret;
    $params[10] = $appsingn;
    $params[11] = $bundleid;
    $params[12] = $package;
    $params[13] = $seller_email;
    $params[14] = $seller_id;
    $params[15] = $private_key;
    $params[16] = $type;
    $params[17] = ToolsClass::getUser()->getId();
    $params[18] = $authuserid;
    $params[19] = $id;
    $params[20] = $businessid;
    if ($commonTools->doExecuteSQLByPre($sql, $params)) {
        $result = array();
        $result['id'] = $id;
        $result['businessid'] = $businessid;
        $result['type'] = $type;
        $result['account'] = $account;
        $result['partner'] = $partner;
        $result['seller_email'] = $seller_email;
        $result['isdefault'] = "";
        $result['status'] = "激活";
        $result['createdate'] = $createdate;
        $result['bindno'] = $commonTools->getDatasBySQL("select remark from acc_dic_b_bindtype where code='" . $type . "'")[0]['remark'];
        $result['result'] = "保存成功！";
    } else {
        $message = '保存失败：数据库异常！';
        \service\tools\logger\LoggerClass::error($message . " sql=" . $sql);
        $result = \service\tools\ToolsClass::buildJSONError($message);
    }
    echo json_encode($result);
    die();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['oper'])) {
        /* 普通请求指令 */
        switch ($_POST['oper']) {
            case "gettree":
                getSelectTree();
                break;
            case "deleteaccount":
                doDeleteAccount();
                break;
            case "rpw":
                doResetPassword();
                break;
            case "rkey":
                doRebuildKey();
                break;
            case "saveBasic":
                doSaveBasic(2);
                break;
            case "saveImage":
                doSaveImage();
                break;
            case "register":
                doRegister();
                break;
            case "updateBasic":
                doUpdateBasic(intval($_POST['status']));
                break;
            case "getBindList":
                doSearchBindList();
                break;
            case "add":
                doAddSubAccount();
                break;
            case "edit":
                switch ($_REQUEST['edittype']) {
                    case "subaccount":
                        doEditSubAccount();
                        break;
                }
                break;
            case "del":
                switch ($_REQUEST['edittype']) {
                    case "subaccount":
                        echo "不允许删除虚拟账户";
                        break;
                    case "bindinfo":
                        doDelBindInfo();
                        break;
                    case "accountitem":
                        echo "不允许删除内部科目账户";
                        break;
                }
                break;
            case "disabledBindInfo":
                doDisabledBindInfo();
                break;
            case "enabledBindInfo":
                doEnabledBindInfo();
                break;
            case "setDefaultBind":
                doSetDefaultBind();
                break;
            case "saveBindInfo":
                doSaveBindInfo();
                break;
        }
    } else {
        /* jqgrid 查询指令 */
        switch ($_POST['cmd']) {
            case "subaccount":
                $sqlArray = array();
                $sqlArray[0] = "*";
                $sqlArray[1] = "(select id,businessid,type,code,balance,money,createdate,case isdefault when 1 then '是' else '否' end as isdefaultname,
                                case status when 1 then '启用' else '禁用' end as statusname from acc_business_subaccount where businessid in 
                                (select businessid from acc_business_account where id='" . $_POST['accountid'] . "'))t";
                break;
            case "inneraccount":
                $sqlArray = array();
                $sqlArray[0] = "*";
                $sqlArray[1] = "acc_business_inneraccount";
                $sqlArray[2] = "where 1=1 and businessid='" . $_POST['accountid'] . "'";
                break;
            default:
                $search_businessid = $_POST['search_businessid'];
                $search_businessname = $_POST['search_businessname'];
                $search_channel = $_POST['search_channel'];
                $search_name = $_POST['search_name'];
                $search_status = $_POST['search_status'];
                $sqlArray = array();
                $sqlArray[0] = "*";
                $sqlArray[1] = "acc_business_account";
                $sqlArray[2] = "where 1=1 ";
                if ($search_businessid != '') {
                    $sqlArray[2] = $sqlArray[2] . "and businessid like '%$search_businessid%' ";
                }
                if ($search_businessname != '') {
                    $sqlArray[2] = $sqlArray[2] . "and businessname like '%$search_businessname%' ";
                }
                if ($search_channel != '') {
                    $sqlArray[2] = $sqlArray[2] . "and channel like '%$search_channel%' ";
                }
                if ($search_name != '') {
                    $sqlArray[2] = $sqlArray[2] . "and name like '%$search_name%' ";
                }
                if ($search_status != '') {
                    $sqlArray[2] = $sqlArray[2] . "and status=$search_status ";
                }
        }
        $result = doQuery($sqlArray);
        echo json_encode($result);
        die();
    }
}