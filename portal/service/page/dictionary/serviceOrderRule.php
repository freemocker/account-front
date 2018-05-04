<?php
/**
 * Created by PhpStorm.
 * User: zhangbin
 * Date: 2016/10/21
 * Time: 13:03
 */
require dirname(__FILE__) . '/../../../view/common/serviceHead.php';
require $_SERVER['DOCUMENT_ROOT'] . '/service/base/baseQuery.php';
$result = array();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $commonTools = new \service\tools\ToolsClass();
    $currUser = portal\service\tools\ToolsClass::getUser();
    if (isset($_REQUEST['oper'])) {
        $oper = $_REQUEST['oper'];
        switch ($oper) {
            case "edit":
                if (!\service\user\UserManagerClass::validatePermissions($GLOBALS['application']->getId(), $currUser->getId(), 'dictionary_edit')) {
                    echo "没有编辑权限";
                    break;
                }
                $authuserid = '';
                if (isset($_POST['authloginno']) && isset($_POST['authpassword']) && $_POST['authloginno'] != '' && $_POST['authpassword'] != '') {
                    $authuserid = \service\user\UserManagerClass::validateUserLoginNoAndPwd($_POST['authloginno'], $_POST['authpassword']);
                    if ($authuserid == '') {
                        echo "编辑授权失败";
                        break;
                    }
                    if (!\service\user\UserManagerClass::validatePermissions($GLOBALS['application']->getId(), $authuserid, 'acc_dic_ordertype_power')) {
                        echo "编辑授权失败";
                        break;
                    }
                } else {
                    echo "编辑需要授权";
                    break;
                }
                $update = "";
                $param = array();
                switch ($_REQUEST['cmd']) {
                    case "balancerule":
                        if (!isset($_REQUEST['oldstatus']) || $_REQUEST['oldstatus'] == '') {
                            echo '修改失败：订单原状态必填';
                            die();
                        }
                        if (!isset($_REQUEST['newstatus']) || $_REQUEST['newstatus'] == '') {
                            echo '修改失败：订单目标状态必填';
                            die();
                        }
                        if (!isset($_REQUEST['type']) || $_REQUEST['type'] == '') {
                            echo '修改失败：变更账户类型必填';
                            die();
                        }
                        if (!isset($_REQUEST['balancedirect']) || $_REQUEST['balancedirect'] == '') {
                            echo '修改失败：余额变动方向必填';
                            die();
                        }
                        if (!isset($_REQUEST['amontruleid']) || $_REQUEST['amontruleid'] == '') {
                            echo '修改失败：发生额规则必填';
                            die();
                        }
                        if (!isset($_REQUEST['accounttype']) || $_REQUEST['accounttype'] == '') {
                            echo '修改失败：虚拟账户类型编码必填';
                            die();
                        }
                        $update = "update acc_dic_ordertype_balancerule set oldstatus=?,newstatus=?,type=?,businessid=?,accounttype=?,amontruleid=?,balancedirect=?,modifydate=? where id=?";
                        $param[0] = $_REQUEST['oldstatus'];
                        $param[1] = $_REQUEST['newstatus'];
                        $param[2] = $_REQUEST['type'];
                        $param[3] = $_REQUEST['businessid'];
                        $param[4] = $_REQUEST['accounttype'];
                        $param[5] = $_REQUEST['amontruleid'];
                        $param[6] = $_REQUEST['balancedirect'];
                        $param[7] = \service\tools\ToolsClass::getNowTime();
                        $param[8] = $_REQUEST['id'];
                        break;
                    case "subjectrule":
                        if (!isset($_REQUEST['oldstatus']) || $_REQUEST['oldstatus'] == '') {
                            echo '修改失败：订单原状态必填';
                            die();
                        }
                        if (!isset($_REQUEST['newstatus']) || $_REQUEST['newstatus'] == '') {
                            echo '修改失败：订单目标状态必填';
                            die();
                        }
                        if (!isset($_REQUEST['type']) || $_REQUEST['type'] == '') {
                            echo '修改失败：变更账户类型必填';
                            die();
                        }
                        if (!isset($_REQUEST['businessid']) || $_REQUEST['businessid'] == '') {
                            echo '修改失败：B户必填';
                            die();
                        }
                        if (!isset($_REQUEST['amontruleid']) || $_REQUEST['amontruleid'] == '') {
                            echo '修改失败：发生额分解规则必填';
                            die();
                        }
                        if (!isset($_REQUEST['accountsubitemid']) || $_REQUEST['accountsubitemid'] == '') {
                            echo '修改失败：会计科目必填';
                            die();
                        }
                        if (!isset($_REQUEST['balancedirect']) || $_REQUEST['balancedirect'] == '') {
                            echo '修改失败：余额变动方向必填';
                            die();
                        }
                        $update = "update acc_dic_ordertype_subjectrule set oldstatus=?,newstatus=?,type=?,businessid=?,amontruleid=?,paytypecode=?,accountsubitemid=?,balancedirect=?,modifydate=? where id=?";
                        $param[0] = $_REQUEST['oldstatus'];
                        $param[1] = $_REQUEST['newstatus'];
                        $param[2] = $_REQUEST['type'];
                        $param[3] = $_REQUEST['businessid'];
                        $param[4] = $_REQUEST['amontruleid'];
                        $param[5] = $_REQUEST['paytypecode'];
                        $param[6] = $_REQUEST['accountsubitemid'];
                        $param[7] = $_REQUEST['balancedirect'];
                        $param[8] = \service\tools\ToolsClass::getNowTime();
                        $param[9] = $_REQUEST['id'];
                        break;
                    case "amontrule":
                        if (!isset($_REQUEST['name']) || $_REQUEST['name'] == '') {
                            echo '修改失败：名称必填';
                            die();
                        }
                        if (!isset($_REQUEST['ruletype']) || $_REQUEST['ruletype'] == '') {
                            echo '修改失败：类型必填';
                            die();
                        }
                        if (!isset($_REQUEST['calculatetype']) || $_REQUEST['calculatetype'] == '') {
                            echo '修改失败：计算方式必填';
                            die();
                        }
                        if (!isset($_REQUEST['calculatemode']) || $_REQUEST['calculatemode'] == '') {
                            echo '修改失败：计算模式必填';
                            die();
                        }
                        if (!isset($_REQUEST['basictype']) || $_REQUEST['basictype'] == '') {
                            echo '修改失败：基数类型必填';
                            die();
                        }
                        if (!isset($_REQUEST['param']) || $_REQUEST['param'] == '') {
                            echo '修改失败：计算参数必填';
                            die();
                        }
                        if (!isset($_REQUEST['min']) || $_REQUEST['min'] == '') {
                            echo '修改失败：最小值必填';
                            die();
                        }
                        if (!isset($_REQUEST['max']) || $_REQUEST['max'] == '') {
                            echo '修改失败：最大值必填';
                            die();
                        }
                        if (!isset($_REQUEST['decomposetype']) || $_REQUEST['decomposetype'] == '') {
                            echo '修改失败：分解类型必填';
                            die();
                        }
                        if (!isset($_REQUEST['decimalprocess']) || $_REQUEST['decimalprocess'] == '') {
                            echo '修改失败：小数处理必填';
                            die();
                        }
                        if (!isset($_REQUEST['sort']) || $_REQUEST['sort'] == '') {
                            echo '修改失败：序号必填';
                            die();
                        }
                        $update = "update acc_dic_ordertype_amontdetailrule set name=?,ruletype=?,calculatetype=?,calculatemode=?,basictype=?,param=?,`min`=?,`max`=?,decomposetype=?,decimalprocess=?,sort=?,modifydate=? where id=?";
                        $param[0] = $_REQUEST['name'];
                        $param[1] = $_REQUEST['ruletype'];
                        $param[2] = $_REQUEST['calculatetype'];
                        $param[3] = $_REQUEST['calculatemode'];
                        $param[4] = $_REQUEST['basictype'];
                        $param[5] = $_REQUEST['param'];
                        $param[6] = $_REQUEST['min'];
                        $param[7] = $_REQUEST['max'];
                        $param[8] = $_REQUEST['decomposetype'];
                        $param[9] = $_REQUEST['decimalprocess'];
                        $param[10] = $_REQUEST['sort'];
                        $param[11] = \service\tools\ToolsClass::getNowTime();
                        $param[12] = $_REQUEST['id'];
                        break;
                    case "steprule":
                        if (!isset($_REQUEST['beginamont']) || $_REQUEST['beginamont'] == '') {
                            echo '修改失败：开始额必填';
                            die();
                        }
                        if (!isset($_REQUEST['calculatetype']) || $_REQUEST['calculatetype'] == '') {
                            echo '修改失败：计算方式必填';
                            die();
                        }
                        if (!isset($_REQUEST['param']) || $_REQUEST['param'] == '') {
                            echo '修改失败：计算参数必填';
                            die();
                        }
                        $update = "update acc_dic_ordertype_amontdetailrule_steprule set beginamont=?,endamont=?,calculatetype=?,param=?,modifydate=? where id=?";
                        $param[0] = $_REQUEST['beginamont'];
                        $param[1] = $_REQUEST['endamont'];
                        $param[2] = $_REQUEST['calculatetype'];
                        $param[3] = $_REQUEST['param'];
                        $param[4] = \service\tools\ToolsClass::getNowTime();
                        $param[5] = $_REQUEST['id'];
                        break;
                }
                if (!$commonTools->doExecuteSQLByPre($update, $param)) {
                    echo '修改失败';
                    break;
                }
                echo 'true';
                break;
            case "add":
                if (!\service\user\UserManagerClass::validatePermissions($GLOBALS['application']->getId(), $currUser->getId(), 'dictionary_edit')) {
                    echo "没有编辑权限";
                    break;
                }
                $authuserid = '';
                if (isset($_POST['authloginno']) && isset($_POST['authpassword']) && $_POST['authloginno'] != '' && $_POST['authpassword'] != '') {
                    $authuserid = \service\user\UserManagerClass::validateUserLoginNoAndPwd($_POST['authloginno'], $_POST['authpassword']);
                    if ($authuserid == '') {
                        echo "编辑授权失败";
                        break;
                    }
                    if (!\service\user\UserManagerClass::validatePermissions($GLOBALS['application']->getId(), $authuserid, 'acc_dic_ordertype_power')) {
                        echo "编辑授权失败";
                        break;
                    }
                } else {
                    echo "编辑需要授权";
                    break;
                }
                $insert = "";
                $param = array();
                $connection = $commonTools->getDBConnection();
                $connection->beginTransaction();
                switch ($_REQUEST['cmd']) {
                    case "balancerule":
                        if (!isset($_REQUEST['oldstatus']) || $_REQUEST['oldstatus'] == '') {
                            $connection->rollBack();
                            echo '添加失败：订单原状态必填';
                            die();
                        }
                        if (!isset($_REQUEST['newstatus']) || $_REQUEST['newstatus'] == '') {
                            $connection->rollBack();
                            echo '添加失败：订单目标状态必填';
                            die();
                        }
                        if (!isset($_REQUEST['type']) || $_REQUEST['type'] == '') {
                            $connection->rollBack();
                            echo '添加失败：变更账户类型必填';
                            die();
                        }
                        if (!isset($_REQUEST['balancedirect']) || $_REQUEST['balancedirect'] == '') {
                            $connection->rollBack();
                            echo '添加失败：余额变动方向必填';
                            die();
                        }
                        if (!isset($_REQUEST['amontruleid']) || $_REQUEST['amontruleid'] == '') {
                            $connection->rollBack();
                            echo '添加失败：发生额规则必填';
                            die();
                        }
                        if (!isset($_REQUEST['accounttype']) || $_REQUEST['accounttype'] == '') {
                            $connection->rollBack();
                            echo '添加失败：虚拟账户类型编码必填';
                            die();
                        }
                        $insert = "insert into acc_dic_ordertype_balancerule(id,ordertypeid,oldstatus,newstatus,type,businessid,accounttype,amontruleid,balancedirect,createdate,modifydate,userid) 
                                  values(?,?,?,?,?,?,?,?,?,?,?,?)";
                        $param[0] = \service\tools\common\UUIDClass::getUUID();
                        $param[1] = $_REQUEST['typeid'];
                        $param[2] = $_REQUEST['oldstatus'];
                        $param[3] = $_REQUEST['newstatus'];
                        $param[4] = $_REQUEST['type'];
                        $param[5] = $_REQUEST['businessid'];
                        $param[6] = $_REQUEST['accounttype'];
                        $param[7] = $_REQUEST['amontruleid'];
                        $param[8] = $_REQUEST['balancedirect'];
                        $param[9] = \service\tools\ToolsClass::getNowTime();
                        $param[10] = \service\tools\ToolsClass::getNowTime();
                        $param[11] = $currUser->getId();
                        if (!$connection->doExcute("update acc_dic_ordertype set field3='1' where id='" . $_REQUEST['typeid'] . "'")) {
                            $connection->rollBack();
                            echo '添加失败';
                            die();
                        }
                        break;
                    case "subjectrule":
                        if (!isset($_REQUEST['oldstatus']) || $_REQUEST['oldstatus'] == '') {
                            $connection->rollBack();
                            echo '添加失败：订单原状态必填';
                            die();
                        }
                        if (!isset($_REQUEST['newstatus']) || $_REQUEST['newstatus'] == '') {
                            $connection->rollBack();
                            echo '添加失败：订单目标状态必填';
                            die();
                        }
                        if (!isset($_REQUEST['type']) || $_REQUEST['type'] == '') {
                            $connection->rollBack();
                            echo '添加失败：变更账户类型必填';
                            die();
                        }
                        if (!isset($_REQUEST['businessid']) || $_REQUEST['businessid'] == '') {
                            $connection->rollBack();
                            echo '添加失败：B户必填';
                            die();
                        }
                        if (!isset($_REQUEST['amontruleid']) || $_REQUEST['amontruleid'] == '') {
                            $connection->rollBack();
                            echo '添加失败：发生额分解规则必填';
                            die();
                        }
                        if (!isset($_REQUEST['accountsubitemid']) || $_REQUEST['accountsubitemid'] == '') {
                            $connection->rollBack();
                            echo '添加失败：会计科目必填';
                            die();
                        }
                        if (!isset($_REQUEST['balancedirect']) || $_REQUEST['balancedirect'] == '') {
                            $connection->rollBack();
                            echo '添加失败：余额变动方向必填';
                            die();
                        }
                        $insert = "insert into acc_dic_ordertype_subjectrule(id,ordertypeid,oldstatus,newstatus,type,businessid,amontruleid,paytypecode,accountsubitemid,balancedirect,createdate,modifydate,userid) 
                                  values(?,?,?,?,?,?,?,?,?,?,?,?,?)";
                        $param[0] = \service\tools\common\UUIDClass::getUUID();
                        $param[1] = $_REQUEST['typeid'];
                        $param[2] = $_REQUEST['oldstatus'];
                        $param[3] = $_REQUEST['newstatus'];
                        $param[4] = $_REQUEST['type'];
                        $param[5] = $_REQUEST['businessid'];
                        $param[6] = $_REQUEST['amontruleid'];
                        $param[7] = $_REQUEST['paytypecode'];
                        $param[8] = $_REQUEST['accountsubitemid'];
                        $param[9] = $_REQUEST['balancedirect'];
                        $param[10] = \service\tools\ToolsClass::getNowTime();
                        $param[11] = \service\tools\ToolsClass::getNowTime();
                        $param[12] = $currUser->getId();
                        if (!$connection->doExcute("update acc_dic_ordertype set field4='1' where id='" . $_REQUEST['typeid'] . "'")) {
                            $connection->rollBack();
                            echo '添加失败';
                            die();
                        }
                        break;
                    case "amontrule":
                        if (!isset($_REQUEST['name']) || $_REQUEST['name'] == '') {
                            $connection->rollBack();
                            echo '添加失败：名称必填';
                            die();
                        }
                        if (!isset($_REQUEST['ruletype']) || $_REQUEST['ruletype'] == '') {
                            $connection->rollBack();
                            echo '添加失败：类型必填';
                            die();
                        }
                        if (!isset($_REQUEST['calculatetype']) || $_REQUEST['calculatetype'] == '') {
                            $connection->rollBack();
                            echo '添加失败：计算方式必填';
                            die();
                        }
                        if (!isset($_REQUEST['calculatemode']) || $_REQUEST['calculatemode'] == '') {
                            $connection->rollBack();
                            echo '添加失败：计算模式必填';
                            die();
                        }
                        if (!isset($_REQUEST['basictype']) || $_REQUEST['basictype'] == '') {
                            $connection->rollBack();
                            echo '添加失败：基数类型必填';
                            die();
                        }
                        if (!isset($_REQUEST['param']) || $_REQUEST['param'] == '') {
                            $connection->rollBack();
                            echo '添加失败：计算参数必填';
                            die();
                        }
                        if (!isset($_REQUEST['min']) || $_REQUEST['min'] == '') {
                            $connection->rollBack();
                            echo '添加失败：最小值必填';
                            die();
                        }
                        if (!isset($_REQUEST['max']) || $_REQUEST['max'] == '') {
                            $connection->rollBack();
                            echo '添加失败：最大值必填';
                            die();
                        }
                        if (!isset($_REQUEST['decomposetype']) || $_REQUEST['decomposetype'] == '') {
                            $connection->rollBack();
                            echo '添加失败：分解类型必填';
                            die();
                        }
                        if (!isset($_REQUEST['decimalprocess']) || $_REQUEST['decimalprocess'] == '') {
                            $connection->rollBack();
                            echo '添加失败：小数处理必填';
                            die();
                        }
                        if (!isset($_REQUEST['sort']) || $_REQUEST['sort'] == '') {
                            $connection->rollBack();
                            echo '添加失败：序号必填';
                            die();
                        }
                        $insert = "insert into acc_dic_ordertype_amontdetailrule(id,ordertypeid,name,ruletype,calculatetype,calculatemode,basictype,param,`min`,`max`,decomposetype,decimalprocess,sort,createdate,modifydate,userid) 
                                  values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                        $param[0] = \service\tools\common\UUIDClass::getUUID();
                        $param[1] = $_REQUEST['typeid'];
                        $param[2] = $_REQUEST['name'];
                        $param[3] = $_REQUEST['ruletype'];
                        $param[4] = $_REQUEST['calculatetype'];
                        $param[5] = $_REQUEST['calculatemode'];
                        $param[6] = $_REQUEST['basictype'];
                        $param[7] = $_REQUEST['param'];
                        $param[8] = $_REQUEST['min'];
                        $param[9] = $_REQUEST['max'];
                        $param[10] = $_REQUEST['decomposetype'];
                        $param[11] = $_REQUEST['decimalprocess'];
                        $param[12] = $_REQUEST['sort'];
                        $param[13] = \service\tools\ToolsClass::getNowTime();
                        $param[14] = \service\tools\ToolsClass::getNowTime();
                        $param[15] = $currUser->getId();
                        if (!$connection->doExcute("update acc_dic_ordertype set field5='1' where id='" . $_REQUEST['typeid'] . "'")) {
                            $connection->rollBack();
                            echo '添加失败';
                            die();
                        }
                        break;
                    case "steprule":
                        if (!isset($_REQUEST['beginamont']) || $_REQUEST['beginamont'] == '') {
                            $connection->rollBack();
                            echo '添加失败：开始额必填';
                            die();
                        }
                        if (!isset($_REQUEST['calculatetype']) || $_REQUEST['calculatetype'] == '') {
                            $connection->rollBack();
                            echo '添加失败：计算方式必填';
                            die();
                        }
                        if (!isset($_REQUEST['param']) || $_REQUEST['param'] == '') {
                            $connection->rollBack();
                            echo '添加失败：计算参数必填';
                            die();
                        }
                        $insert = "insert into acc_dic_ordertype_amontdetailrule_steprule(id,amontruleid,beginamont,endamont,calculatetype,param,createdate,modifydate,userid) 
                                  values(?,?,?,?,?,?,?,?,?)";
                        $param[0] = \service\tools\common\UUIDClass::getUUID();
                        $param[1] = $_REQUEST['amontruleid'];
                        $param[2] = $_REQUEST['beginamont'];
                        $param[3] = $_REQUEST['endamont'];
                        $param[4] = $_REQUEST['calculatetype'];
                        $param[5] = $_REQUEST['param'];
                        $param[6] = \service\tools\ToolsClass::getNowTime();
                        $param[7] = \service\tools\ToolsClass::getNowTime();
                        $param[8] = $currUser->getId();
                        break;
                }
                if (!$connection->doExcuteByPre($insert, $param)) {
                    $connection->rollBack();
                    echo '添加失败';
                    break;
                }
                $connection->commit();
                echo 'true';
                break;
            case "del":
                if (!\service\user\UserManagerClass::validatePermissions($GLOBALS['application']->getId(), $currUser->getId(), 'dictionary_edit')) {
                    echo "没有编辑权限";
                    break;
                }
                $authuserid = '';
                if (isset($_POST['authloginno']) && isset($_POST['authpassword']) && $_POST['authloginno'] != '' && $_POST['authpassword'] != '') {
                    $authuserid = \service\user\UserManagerClass::validateUserLoginNoAndPwd($_POST['authloginno'], $_POST['authpassword']);
                    if ($authuserid == '') {
                        echo "编辑授权失败";
                        break;
                    }
                    if (!\service\user\UserManagerClass::validatePermissions($GLOBALS['application']->getId(), $authuserid, 'acc_dic_ordertype_power')) {
                        echo "编辑授权失败";
                        break;
                    }
                } else {
                    echo "编辑需要授权";
                    break;
                }
                $id = '\'' . str_replace(',', '\',\'', $_POST['id']) . '\'';
                $delete = "";
                $connection = $commonTools->getDBConnection();
                $connection->beginTransaction();
                switch ($_REQUEST['cmd']) {
                    case "balancerule":
                        $delete = "delete from acc_dic_ordertype_balancerule where id in(" . $id . ")";
                        $update = "";
                        $search = $commonTools->getDatasBySQL("select * from acc_dic_ordertype_balancerule where id not in(" . $id . ") and ordertypeid='" . $_REQUEST['typeid'] . "'");
                        if (count($search) == 0) {
                            if (!$connection->doExcute("update acc_dic_ordertype set field3='0' where id='" . $_REQUEST['typeid'] . "'")) {
                                $connection->rollBack();
                                echo '删除失败';
                                die();
                            }
                        }
                        break;
                    case "subjectrule":
                        $delete = "delete from acc_dic_ordertype_subjectrule where id in(" . $id . ")";
                        $update = "";
                        $search = $commonTools->getDatasBySQL("select * from acc_dic_ordertype_subjectrule where id not in(" . $id . ") and ordertypeid='" . $_REQUEST['typeid'] . "'");
                        if (count($search) == 0) {
                            if (!$connection->doExcute("update acc_dic_ordertype set field4='0' where id='" . $_REQUEST['typeid'] . "'")) {
                                $connection->rollBack();
                                echo '删除失败';
                                die();
                            }
                        }
                        break;
                    case "amontrule":
                        $delete = "delete from acc_dic_ordertype_amontdetailrule where id in(" . $id . ")";
                        $update = "";
                        $search = $commonTools->getDatasBySQL("select * from acc_dic_ordertype_amontdetailrule where id not in(" . $id . ") and ordertypeid='" . $_REQUEST['typeid'] . "'");
                        if (count($search) == 0) {
                            if (!$connection->doExcute("update acc_dic_ordertype set field5='0' where id='" . $_REQUEST['typeid'] . "'")) {
                                $connection->rollBack();
                                echo '删除失败';
                                die();
                            }
                        }
                        if (!$connection->doExcute("delete from acc_dic_ordertype_amontdetailrule_steprule where amontruleid in(" . $id . ")")) {
                            $connection->rollBack();
                            echo '删除失败';
                            die();
                        }
                        $search = $commonTools->getDatasBySQL("select * from acc_dic_ordertype_subjectrule where amontruleid in(" . $id . ")");
                        if (count($search) > 0) {
                            $connection->rollBack();
                            echo '删除失败：会计科目规则已配置';
                            die();
                        }
                        break;
                    case "steprule":
                        $delete = "delete from acc_dic_ordertype_amontdetailrule_steprule where id in(" . $id . ")";
                        break;
                }
                if (!$connection->doExcute($delete)) {
                    $connection->rollBack();
                    echo '删除失败';
                    break;
                }
                $connection->commit();
                echo 'true';
                break;
        }
        die();
    } else {
        $sqlArray = array();
        switch ($_REQUEST['cmd']) {
            case "balancerule":
                $sqlArray[0] = "*";
                $sqlArray[1] = "acc_dic_ordertype_balancerule";
                $sqlArray[2] = "where ordertypeid='" . $_REQUEST['typeid'] . "'";
                break;
            case "subjectrule":
                $sqlArray[0] = "*";
                $sqlArray[1] = "acc_dic_ordertype_subjectrule";
                $sqlArray[2] = "where ordertypeid='" . $_REQUEST['typeid'] . "'";
                break;
            case "amontrule":
                $sqlArray[0] = "*";
                $sqlArray[1] = "(select ar.*,case when (select count(*) from acc_dic_ordertype_amontdetailrule_steprule arsr where arsr.amontruleid=ar.id)=0 then 0 else 1 end as steprule from acc_dic_ordertype_amontdetailrule ar)t";
                $sqlArray[2] = "where ordertypeid='" . $_REQUEST['typeid'] . "'";
                break;
            case "steprule":
                $sqlArray[0] = "*";
                $sqlArray[1] = "acc_dic_ordertype_amontdetailrule_steprule";
                $sqlArray[2] = "where amontruleid='" . $_REQUEST['amontruleid'] . "'";
                break;
        }
        $result = doQuery($sqlArray);
        echo json_encode($result);
        die();
    }
}