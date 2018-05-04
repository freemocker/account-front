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
    $search_accountdate = $_POST['search_accountdate'];
    $sqlArray = array();
    $sqlArray[0] = "*";
    $sqlArray[1] = "acc_inner_summary";
    $sqlArray[2] = "where 1=1 ";
    if ($search_businessid != '') {
        $sqlArray[2] = $sqlArray[2] . "and businessid='$search_businessid' ";
    }
    if ($search_accountdate != '') {
        $sqlArray[2] = $sqlArray[2] . "and accountdate='$search_accountdate' ";
    }
    $result = doQuery($sqlArray, 2);
    echo json_encode($result);
    die();
}