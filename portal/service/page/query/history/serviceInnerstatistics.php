<?php
/**
 * Created by PhpStorm.
 * User: zhangbin
 * Date: 2017/5/15
 * Time: 10:20
 */
require dirname(__FILE__) . '/../../../../view/common/serviceHead.php';
require $_SERVER['DOCUMENT_ROOT'] . '/service/base/baseQuery.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $search_businessid = $_POST['search_businessid'];
    $search_innerid = $_POST['search_innerid'];
    $search_accountdate = $_POST['search_accountdate'];

    $year = substr($search_accountdate, 0, 4);
    $commonTools = new \service\tools\ToolsClass(2);
    $table = '';
    $tablenames = $commonTools->getDatasBySQL("select code from acc_batch_histables where parentid='acc_inner_statistics' and code >= 'acc_inner_statistics_$year' order by code desc");
    foreach ($tablenames as $tablename) {
        if ($table != '') {
            $table = $table . " union all ";
        }
        $tableyear = substr($tablename['code'], -4);
        $table = $table . "select * from " . $tablename['code'] . " where 1=1 ";
        if ($search_accountdate != '') {
            $table = $table . "and accountdate='$search_accountdate' ";
        }
    }
    $table = '(' . $table . ')t';

    $sqlArray = array();
    $sqlArray[0] = "*";
    $sqlArray[1] = $table;
    $sqlArray[2] = "where 1=1 ";
    if ($search_businessid != '') {
        $sqlArray[2] = $sqlArray[2] . "and businessid='$search_businessid' ";
    }
    if ($search_innerid != '') {
        $sqlArray[2] = $sqlArray[2] . "and innerid='$search_innerid' ";
    }
    $result = doQuery($sqlArray, 2);
    echo json_encode($result);
    die();
}