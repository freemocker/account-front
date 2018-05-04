<?php
/**
 * Created by PhpStorm.
 * User: zhangbin
 * Date: 2016/10/14
 * Time: 13:55
 */
require dirname(__FILE__) . '/../../../view/common/serviceHead.php';
require $_SERVER['DOCUMENT_ROOT'] . '/service/base/baseQuery.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $search_orderno = $_POST['search_orderno'];
    $search_result = $_POST['search_result'];
    $search_start = $_POST['search_start'];
    $search_end = $_POST['search_end'];
    $sqlArray = array();
    $sqlArray[0] = "*";
    $sqlArray[1] = "acc_order_reviewrecord";
    $sqlArray[2] = "where 1=1 ";
    if ($search_orderno != '') {
        $sqlArray[2] = $sqlArray[2] . "and orderno='$search_orderno' ";
    }
    if ($search_result != '') {
        $sqlArray[2] = $sqlArray[2] . "and result='$search_result' ";
    }
    if ($search_start != '') {
        $sqlArray[2] = $sqlArray[2] . "and reviewdate>='" . ($search_start . ' 00:00:00') . "' ";
    }
    if ($search_end != '') {
        $sqlArray[2] = $sqlArray[2] . "and reviewdate<='" . ($search_end . ' 23:59:59') . "' ";
    }
    $result = doQuery($sqlArray);
    echo json_encode($result);
    die();
}