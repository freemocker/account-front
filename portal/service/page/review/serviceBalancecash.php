<?php
/**
 * Created by PhpStorm.
 * User: zhangbin
 * Date: 2016/10/9
 * Time: 14:27
 */
require dirname(__FILE__) . '/../../../view/common/serviceHead.php';
require $_SERVER['DOCUMENT_ROOT'] . '/service/base/baseQuery.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $search_orderno = $_POST['search_orderno'];
    $search_businesstradeno = $_POST['search_businesstradeno'];
    $search_channel = $_POST['search_channel'];
    $search_custid = $_POST['search_custid'];
    $sqlArray = array();
    $sqlArray[0] = "*";
    $sqlArray[1] = "acc_order_base";
    $sqlArray[2] = "where status=12 and ordertype=105 ";
    if ($search_orderno != '') {
        $sqlArray[2] = $sqlArray[2] . "and orderno='$search_orderno' ";
    }
    if ($search_businesstradeno != '') {
        $sqlArray[2] = $sqlArray[2] . "and businesstradeno='$search_businesstradeno' ";
    }
    if ($search_channel != '') {
        $sqlArray[2] = $sqlArray[2] . "and channel='$search_channel' ";
    }
    if ($search_custid != '') {
        $sqlArray[2] = $sqlArray[2] . "and custid='$search_custid' ";
    }
    $result = doQuery($sqlArray, -1, "orderno");
    echo json_encode($result);
    die();
}