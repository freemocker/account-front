<?php
/**
 * Created by PhpStorm.
 * User: zhangbin
 * Date: 2017/5/12
 * Time: 10:43
 */
require dirname(__FILE__) . '/../../../view/common/serviceHead.php';
require $_SERVER['DOCUMENT_ROOT'] . '/service/base/baseQuery.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $search_orderno = $_POST['search_orderno'];
    $search_businessid = $_POST['search_businessid'];
    $sqlArray = array();
    $sqlArray[0] = "*";
    $sqlArray[1] = "acc_order_base";
    $sqlArray[2] = "where status=12 and ordertype=306 ";
    if ($search_orderno != '') {
        $sqlArray[2] = $sqlArray[2] . "and orderno='$search_orderno' ";
    }
    if ($search_businessid != '') {
        $sqlArray[2] = $sqlArray[2] . "and businessid='$search_businessid' ";
    }
    $result = doQuery($sqlArray, -1, "orderno");
    echo json_encode($result);
    die();
}