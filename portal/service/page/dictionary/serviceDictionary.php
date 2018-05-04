<?php
/**
 * Created by PhpStorm.
 * User: zhang
 * Date: 2016/8/9
 * Time: 15:10
 */
require dirname(__FILE__) . '/../../../view/common/serviceHead.php';
require $_SERVER['DOCUMENT_ROOT'] . '/service/base/baseQuery.php';
$dic_tablename = $_REQUEST['tablename'];
$result = array();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $commonTools = new \service\tools\ToolsClass();
    $currUser = portal\service\tools\ToolsClass::getUser();
    if (isset($_REQUEST['oper'])) {
        $oper = $_REQUEST['oper'];
        switch ($oper) {
            case "edit":
                if ($dic_tablename == 'acc_dic_account_item') {
                    echo "不允许修改";
                    break;
                }
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
                    if (!\service\user\UserManagerClass::validatePermissions($GLOBALS['application']->getId(), $authuserid, $dic_tablename . '_power')) {
                        echo "编辑授权失败";
                        break;
                    }
                } else {
                    echo "编辑需要授权";
                    break;
                }
                $update_sql = "update " . $dic_tablename . " set name=?,code=?,remark=?,type=?,status=?,parent=?,parentid=?,modifydate=?,userid=?,field1=?,field2=?,field3=?,field4=?,field5=?,field6=?,field7=?,field8=?,field9=?,field10=? where id='" . $_POST['id'] . "'";
                $params = array();
                $params[0] = isset($_POST['name']) ? $_POST['name'] : '';
                $params[1] = trim($_POST['code']);
                $params[2] = isset($_POST['remark']) ? $_POST['remark'] : '';
                $params[3] = isset($_POST['type']) ? $_POST['type'] : '';
                $params[4] = $_POST['statusname'] == '启用' ? 1 : 0;
                $params[5] = isset($_POST['parent']) ? $_POST['parent'] : '';
                $params[6] = isset($_POST['parentid']) ? $_POST['parentid'] : '';
                $params[7] = \service\tools\ToolsClass::getNowTime();
                $params[8] = $currUser->getId();
                $params[9] = isset($_POST['field1']) ? $_POST['field1'] : '';
                $params[10] = isset($_POST['field2']) ? $_POST['field2'] : '';
                $params[11] = isset($_POST['field3']) ? $_POST['field3'] : '';
                $params[12] = isset($_POST['field4']) ? $_POST['field4'] : '';
                $params[13] = isset($_POST['field5']) ? $_POST['field5'] : '';
                $params[14] = isset($_POST['field6']) ? $_POST['field6'] : '';
                $params[15] = isset($_POST['field7']) ? $_POST['field7'] : '';
                $params[16] = isset($_POST['field8']) ? $_POST['field8'] : '';
                $params[17] = isset($_POST['field9']) ? $_POST['field9'] : '';
                $params[18] = $authuserid;
                if ($dic_tablename == "acc_dic_ordertype") {
                    $update_sql = "update " . $dic_tablename . " set name=?,code=?,remark=?,type=?,status=?,parent=?,parentid=?,modifydate=?,userid=?,field1=?,field2=?,field6=?,field10=? where id='" . $_POST['id'] . "'";
                    unset($params[11]);
                    unset($params[12]);
                    unset($params[13]);
                    unset($params[14]);
                    unset($params[15]);
                    unset($params[16]);
                    unset($params[17]);
                    unset($params[18]);
                    $params[11] = isset($_POST['field6']) ? $_POST['field6'] : '';
                    $params[12] = $authuserid;
                }
                if ($dic_tablename == "acc_dic_sysparam" || $dic_tablename == "acc_dic_dateparam") {
                    $update_sql = "update " . $dic_tablename . " set code=?,remark=?,status=?,modifydate=?,userid=?,field10=? where id='" . $_POST['id'] . "'";
                    $params = array();
                    $params[0] = trim($_POST['code']);
                    $params[1] = isset($_POST['remark']) ? $_POST['remark'] : '';
                    $params[2] = $_POST['statusname'] == '启用' ? 1 : 0;
                    $params[3] = \service\tools\ToolsClass::getNowTime();
                    $params[4] = $currUser->getId();
                    $params[5] = $authuserid;
                }
                if ($commonTools->doExecuteSQLByPre($update_sql, $params)) {
                    echo 'true';
                } else {
                    echo '修改失败！';
                }
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
                    if (!\service\user\UserManagerClass::validatePermissions($GLOBALS['application']->getId(), $authuserid, $dic_tablename . '_power')) {
                        echo "编辑授权失败";
                        break;
                    }
                } else {
                    echo "编辑需要授权";
                    break;
                }
                $insert_sql = "insert into " . $dic_tablename . "(id,name,code,remark,type,status,parent,parentid,createdate,modifydate,userid,field1,field2,field3,field4,field5,field6,field7,field8,field9,field10) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                $params = array();
                $params[0] = \service\tools\common\UUIDClass::getUUID();
                $params[1] = $_POST['name'];
                $params[2] = trim($_POST['code']);
                $params[3] = isset($_POST['remark']) ? $_POST['remark'] : '';
                $params[4] = isset($_POST['type']) ? $_POST['type'] : '';
                $params[5] = isset($_POST['statusname']) ? ($_POST['statusname'] == '启用' ? 1 : 0) : 1;
                $params[6] = isset($_POST['parent']) ? $_POST['parent'] : '';
                $params[7] = isset($_POST['parentid']) ? $_POST['parentid'] : '';
                $params[8] = \service\tools\ToolsClass::getNowTime();
                $params[9] = \service\tools\ToolsClass::getNowTime();
                $params[10] = $currUser->getId();
                $params[11] = isset($_POST['field1']) ? $_POST['field1'] : '';
                $params[12] = isset($_POST['field2']) ? $_POST['field2'] : '';
                $params[13] = isset($_POST['field3']) ? $_POST['field3'] : '';
                $params[14] = isset($_POST['field4']) ? $_POST['field4'] : '';
                $params[15] = isset($_POST['field5']) ? $_POST['field5'] : '';
                $params[16] = isset($_POST['field6']) ? $_POST['field6'] : '';
                $params[17] = isset($_POST['field7']) ? $_POST['field7'] : '';
                $params[18] = isset($_POST['field8']) ? $_POST['field8'] : '';
                $params[19] = isset($_POST['field9']) ? $_POST['field9'] : '';
                $params[20] = $authuserid;
                $connection = $commonTools->getDBConnection();
                $connection->beginTransaction();
                if ($dic_tablename == 'acc_dic_account_item') {
                    $params[14] = 1;
                    if ($_POST['parentid'] == '') {
                        $params[15] = 1;
                    } else {
                        $level = intval($commonTools->getDatasBySQL("select field5 from " . $dic_tablename . " where id='" . $_POST['parentid'] . "'")[0]['field5']);
                        $level = $level + 1;
                        if ($level > 4) {
                            $connection->rollBack();
                            echo '添加失败：最多只能添加四级科目';
                            break;
                        }
                        $params[15] = $level;

                        $equel = $commonTools->getDatasBySQL("select * from " . $dic_tablename . " where parentid='" . $_POST['parentid'] . "' and code='" . $params[2] . "'");
                        if (count($equel) > 0) {
                            $connection->rollBack();
                            echo '添加失败：已存在相同编码的科目';
                            break;
                        }
                    }
                    if ($params[15] > 1 && $params[15] < 4) {
                        $accountitem = $connection->doQuery("select code,field1 from " . $dic_tablename . " where id='" . $params[7] . "'")->fetchAll()[0];
                        if ($accountitem['field1'] != $params[11]) {
                            $connection->rollBack();
                            echo '添加失败：方向必须和上级相同';
                            break;
                        }
                    } else if ($params[15] == 4) {
                        if (strlen($params[2]) != 2) {
                            $connection->rollBack();
                            echo '添加失败：第四级只允许两位编码';
                            break;
                        }
                        $accountitem = $connection->doQuery("select code,field1 from " . $dic_tablename . " where id='" . $params[7] . "'")->fetchAll()[0];
                        if ($accountitem['field1'] == '3') {
                            if ($params[11] == '3') {
                                $connection->rollBack();
                                echo '添加失败：第四级余额方向只允许“借”或“贷”';
                                break;
                            }
                        } else {
                            if ($accountitem['field1'] != $params[11]) {
                                $connection->rollBack();
                                echo '添加失败：第四级余额方向必须和第三级相同';
                                break;
                            }
                        }
                    }
                } else if ($dic_tablename == "acc_dic_ordertype") {
                    $params[13] = '0';
                    $params[14] = '0';
                    $params[15] = '0';
                } else if ($dic_tablename == "acc_dic_batch") {
                    $equel = $commonTools->getDatasBySQL("select * from " . $dic_tablename . " where code='" . $params[2] . "'");
                    if (count($equel) > 0) {
                        $connection->rollBack();
                        echo '添加失败：已存在相同类名的任务';
                        break;
                    }
                }
                if ($connection->doExcuteByPre($insert_sql, $params)) {
                    $connection->commit();
                    if ($dic_tablename == 'acc_dic_account_type') {
                        $businesses = $connection->doQuery("select * from acc_business_account")->fetchAll();
                        $connection->beginTransaction();
                        foreach ($businesses as $business) {
                            $subaccountcode = $business['businessid'] . $params[2] . str_pad(mt_rand(0, 999), 3, '0', STR_PAD_LEFT);
                            if (!$connection->doExcute("insert into acc_business_subaccount(id,businessid,type,isdefault,code,balance,createdate,status) 
                              values('" . \service\tools\common\UUIDClass::getUUID() . "','" . $business['businessid'] . "','" . $params[4] . "',0,'" . $subaccountcode . "',0,'" . \service\tools\ToolsClass::getNowTime() . "',1)")
                            ) {
                                $connection->rollBack();
                                echo '添加失败：创建B户虚拟账户失败';
                                die();
                            }
                        }
                        $custs = $connection->doQuery("select * from acc_cust_account")->fetchAll();
                        foreach ($custs as $cust) {
                            $subaccountcode = $cust['custid'] . $params[2] . str_pad(mt_rand(0, 999), 3, '0', STR_PAD_LEFT);
                            if (!$connection->doExcute("insert into acc_cust_subaccount(id,custid,code,type,balance,createdate,status) 
                              values('" . \service\tools\common\UUIDClass::getUUID() . "','" . $cust['custid'] . "','" . $subaccountcode . "','" . $params[4] . "',0,'" . \service\tools\ToolsClass::getNowTime() . "',1)")
                            ) {
                                $connection->rollBack();
                                echo '添加失败：创建C户虚拟账户失败';
                                die();
                            }
                        }
                        $connection->commit();
                    }
                    echo 'true';
                } else {
                    $connection->rollBack();
                    echo '添加失败！';
                }
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
                    if (!\service\user\UserManagerClass::validatePermissions($GLOBALS['application']->getId(), $authuserid, $dic_tablename . '_power')) {
                        echo "编辑授权失败";
                        break;
                    }
                } else {
                    echo "编辑需要授权";
                    break;
                }
                $id = '\'' . str_replace(',', '\',\'', $_POST['id']) . '\'';
                $search = $commonTools->getDatasBySQL("select * from " . $dic_tablename . " where parentid in(" . $id . ")");
                if (count($search) > 0) {
                    echo "存在下级，不允许删除";
                    break;
                }
                $connection = $commonTools->getDBConnection();
                $connection->beginTransaction();
                if ($dic_tablename == "acc_dic_account_type" || $dic_tablename == "acc_dic_ordertype" || $dic_tablename == "acc_dic_orderstatus" || $dic_tablename == "acc_dic_paytype" || $dic_tablename == "acc_dic_sysparam") {
                    $connection->rollBack();
                    echo "不允许删除";
                    break;
                } else if ($dic_tablename == 'acc_dic_account_item') {
                    $abid = substr($id, 1, strlen($id) - 2);
                    $num = $commonTools->getDatasBySQL("select * from " . $dic_tablename . " where id='" . $abid . "' and field4<>'1'");
                    if (count($num) > 0) {
                        $connection->rollBack();
                        echo "不允许删除该科目";
                        break;
                    }
                } else if ($dic_tablename == 'acc_dic_b_bindtype') {
                    $abid = substr($id, 1, strlen($id) - 2);
                    $code = $commonTools->getDatasBySQL("select code from " . $dic_tablename . " where id='" . $abid . "'")[0]['code'];
                    $num = $commonTools->getDatasBySQL("select * from acc_business_bindinfo where type='" . $code . "'");
                    if (count($num) > 0) {
                        $connection->rollBack();
                        echo "不允许删除该类型";
                        break;
                    }
                } else if ($dic_tablename == 'acc_dic_c_bindtype') {
                    $abid = substr($id, 1, strlen($id) - 2);
                    $code = $commonTools->getDatasBySQL("select code from " . $dic_tablename . " where id='" . $abid . "'")[0]['code'];
                    $num = $commonTools->getDatasBySQL("select * from acc_cust_bindinfo where type='" . $code . "'");
                    if (count($num) > 0) {
                        $connection->rollBack();
                        echo "不允许删除该类型";
                        break;
                    }
                }
                if ($connection->doExcute("delete from " . $dic_tablename . " where id in(" . $id . ")")) {
                    $connection->commit();
                    echo "true";
                } else {
                    $connection->rollBack();
                    echo "删除失败！";
                }
                break;
            case "gettree":
                $nodes = $commonTools->getDatasBySQL("select id,name,code,parentid as pId,case id when '" . $_POST['id'] . "' then 'true' else 'false' end as nocheck from " . $dic_tablename . " order by code asc");
                if (count($nodes) > 0) {
                    $result = array();
                    foreach ($nodes as $node) {
                        $node['pId'] = $node['pid'];
                        $node['name'] = $node['name'] . '(' . $node['code'] . ')';
                        array_push($result, $node);
                    }
                    echo json_encode($result);
                } else {
                    echo \service\tools\ToolsClass::buildJSONErrorStr("没有节点");
                }
                break;
        }
        die();
    } else {
        $sqlArray = array();
        $sqlArray[0] = "*";
        $sqlArray[1] = "(select id,name,code,remark,type,case status when 1 then '启用' else '禁用' end as statusname,parentid,parent,createdate,modifydate,userid,field1,field2,field3,field4,field5,field6,field7,field8,field9,field10 from " . $dic_tablename . " where 1=1 ";
        if (isset($_POST['search_name']) && $_POST['search_name'] != '') {
            $sqlArray[1] = $sqlArray[1] . "and name like '%" . $_POST['search_name'] . "%' ";
        }
        if (isset($_POST['search_code']) && $_POST['search_code'] != '') {
            $sqlArray[1] = $sqlArray[1] . "and code like '%" . $_POST['search_code'] . "%' ";
        }
        if (isset($_POST['search_status']) && $_POST['search_status'] != '') {
            $sqlArray[1] = $sqlArray[1] . "and status=" . $_POST['search_status'] . " ";
        }
        if (isset($_POST['search_type']) && $_POST['search_type'] != '') {
            $sqlArray[1] = $sqlArray[1] . "and type = '" . $_POST['search_type'] . "' ";
        }
        if (isset($_POST['search_parent']) && $_POST['search_parent'] != '') {
            $sqlArray[1] = $sqlArray[1] . "and parent like '%" . $_POST['search_parent'] . "%' ";
        }
        if (isset($_POST['search_parentid']) && $_POST['search_parentid'] != '') {
            $sqlArray[1] = $sqlArray[1] . "and parentid='" . $_POST['search_parentid'] . "' ";
        }
        if (isset($_POST['search_field1']) && $_POST['search_field1'] != '') {
            $sqlArray[1] = $sqlArray[1] . "and field1='" . $_POST['search_field1'] . "' ";
        }
        if (isset($_POST['search_field2']) && $_POST['search_field2'] != '') {
            $sqlArray[1] = $sqlArray[1] . "and field2='" . $_POST['search_field2'] . "' ";
        }
        if (isset($_POST['search_field3']) && $_POST['search_field3'] != '') {
            $sqlArray[1] = $sqlArray[1] . "and field3='" . $_POST['search_field3'] . "' ";
        }
        if (isset($_POST['search_field4']) && $_POST['search_field4'] != '') {
            $sqlArray[1] = $sqlArray[1] . "and field4='" . $_POST['search_field4'] . "' ";
        }
        if (isset($_POST['search_field5']) && $_POST['search_field5'] != '') {
            $sqlArray[1] = $sqlArray[1] . "and field5='" . $_POST['search_field5'] . "' ";
        }
        if (isset($_POST['search_field6']) && $_POST['search_field6'] != '') {
            $sqlArray[1] = $sqlArray[1] . "and field6='" . $_POST['search_field6'] . "' ";
        }
        if (isset($_POST['search_field7']) && $_POST['search_field7'] != '') {
            $sqlArray[1] = $sqlArray[1] . "and field7='" . $_POST['search_field7'] . "' ";
        }
        if (isset($_POST['search_field8']) && $_POST['search_field8'] != '') {
            $sqlArray[1] = $sqlArray[1] . "and field8='" . $_POST['search_field8'] . "' ";
        }
        if (isset($_POST['search_field9']) && $_POST['search_field9'] != '') {
            $sqlArray[1] = $sqlArray[1] . "and field9='" . $_POST['search_field9'] . "' ";
        }
        if (isset($_POST['search_field10']) && $_POST['search_field10'] != '') {
            $sqlArray[1] = $sqlArray[1] . "and field10='" . $_POST['search_field10'] . "' ";
        }
        $sqlArray[1] = $sqlArray[1] . ")t";
        if ($dic_tablename == 'acc_batch_histables') {
            $result = doQuery($sqlArray, 2);
        } else {
            $result = doQuery($sqlArray);
        }
        echo json_encode($result);
        die();
    }
}