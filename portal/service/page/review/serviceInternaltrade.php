<?php
/**
 * Created by PhpStorm.
 * User: zhangbin
 * Date: 2017/5/12
 * Time: 12:01
 */
require dirname(__FILE__) . '/../../../view/common/serviceHead.php';
require $_SERVER['DOCUMENT_ROOT'] . '/service/base/baseQuery.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $search_orderno = $_POST['search_orderno'];
    $search_tradetype = $_POST['search_tradetype'];
    $search_businessid = $_POST['search_businessid'];
    $search_custid = $_POST['search_custid'];
    $sqlArray = array();
    $sqlArray[0] = "*";
    $sqlArray[1] = "(select o.orderno,o.businessid,o.custid,oi.tradetype,oi.tradetypename,o.createdate,o.status,o.amont from acc_order_base o inner join acc_order_internaltrade oi on o.orderno=oi.orderno)t";
    $sqlArray[2] = "where status=12 ";
    if ($search_orderno != '') {
        $sqlArray[2] = $sqlArray[2] . "and orderno='$search_orderno' ";
    }
    if ($search_tradetype != '') {
        $sqlArray[2] = $sqlArray[2] . "and tradetype=$search_tradetype ";
    }
    if ($search_businessid != '') {
        $sqlArray[2] = $sqlArray[2] . "and businessid='$search_businessid' ";
    }
    if ($search_custid != '') {
        $sqlArray[2] = $sqlArray[2] . "and custid='$search_custid' ";
    }
    $result = doQuery($sqlArray, -1, "orderno");
    echo json_encode($result);
    die();
}