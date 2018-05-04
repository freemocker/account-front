<?php
/**
 * Created by PhpStorm.
 * User: zhangbin
 * Date: 2017/5/13
 * Time: 22:35
 */
require dirname(__FILE__) . '/../../../view/common/serviceHead.php';
require $_SERVER['DOCUMENT_ROOT'] . '/service/base/baseQuery.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $search_taskname = $_POST['search_taskname'];
    $search_taskclassname = $_POST['search_taskclassname'];
    $search_status = $_POST['search_status'];
    $search_account = $_POST['search_account'];
    $sqlArray = array();
    $sqlArray[0] = "*";
    $sqlArray[1] = "(select id,taskname,taskclassname,taskno,status,
    case status when 1 then '开始' when 2 then '处理中' when 3 then '忽略' when 4 then '成功' when -1 then '失败' end as statusname,accountdate,description from acc_batch_situation order by taskno asc)t";
    $sqlArray[2] = "where 1=1 ";
    if ($search_taskname != '') {
        $sqlArray[2] = $sqlArray[2] . "and taskname like '%$search_taskname%' ";
    }
    if ($search_taskclassname != '') {
        $sqlArray[2] = $sqlArray[2] . "and taskclassname='$search_taskclassname' ";
    }
    if ($search_status != '') {
        $sqlArray[2] = $sqlArray[2] . "and status=$search_status ";
    }
    if ($search_account != '') {
        $sqlArray[2] = $sqlArray[2] . "and accountdate='$search_account' ";
    }
    $result = doQuery($sqlArray, 2);
    echo json_encode($result);
    die();
}