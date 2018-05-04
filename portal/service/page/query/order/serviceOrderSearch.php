<?php
/**
 * Created by PhpStorm.
 * User: zhangbin
 * Date: 2016/10/14
 * Time: 17:11
 */
require dirname(__FILE__) . '/../../../../view/common/serviceHead.php';
require $_SERVER['DOCUMENT_ROOT'] . '/service/base/baseQuery.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $commonTools = new \service\tools\ToolsClass();
    $search_orderno = $_POST['search_orderno'];
    $search_channel = $_POST['search_channel'];
    $search_status = isset($_POST['search_status']) ? $_POST['search_status'] : "";
    $search_custid = $_POST['search_custid'];
    $search_businesstradeno = $_POST['search_businesstradeno'];
    $search_type = $_POST['search_type'];
    $search_start = $_POST['search_start'];
    $search_end = $_POST['search_end'];
    $sqlArray = array();
    if (isset($_POST['searchType'])) {
        switch ($_POST['searchType']) {
            case "all":
                $sqlArray[0] = "*";
                $sqlArray[1] = "acc_order_base";
                $sqlArray[2] = "where 1=1 ";
                break;
            case "refund":
                $sqlArray[0] = "*";
                $sqlArray[1] = "acc_order_base";
                $sqlArray[2] = "where (ordertype=102 or ordertype=202 or ordertype=302 or ordertype=402) ";
                break;
            case "balance":
                $sqlArray[0] = "*";
                $sqlArray[1] = "acc_order_base";
                $sqlArray[2] = "where (ordertype=101 or ordertype=102 or ordertype=103 or ordertype=104 or ordertype=105) ";
                break;
            case "nonBalance":
                $sqlArray[0] = "*";
                $sqlArray[1] = "acc_order_base";
                $sqlArray[2] = "where (ordertype=201 or ordertype=202 or ordertype=204) ";
                break;
            case "integral":
                $sqlArray[0] = "*";
                $sqlArray[1] = "acc_order_base";
                $sqlArray[2] = "where (ordertype=301 or ordertype=302 or ordertype=303) ";
                break;
            case "currency":
                $sqlArray[0] = "*";
                $sqlArray[1] = "acc_order_base";
                $sqlArray[2] = "where (ordertype=401 or ordertype=402 or ordertype=403) ";
                break;
            case "adjust":
                $sqlArray[0] = "*";
                $sqlArray[1] = "acc_order_base";
                $sqlArray[2] = "where status=33 ";
                break;
            default:
                die();
        }
    }
    if ($search_orderno != '') {
        $sqlArray[2] = $sqlArray[2] . "and orderno='$search_orderno' ";
    }
    if ($search_channel != '') {
        $sqlArray[2] = $sqlArray[2] . "and channel='$search_channel' ";
    }
    if ($search_status != '') {
        $sqlArray[2] = $sqlArray[2] . "and status=$search_status ";
    }
    if ($search_custid != '') {
        $sqlArray[2] = $sqlArray[2] . "and custid='$search_custid' ";
    }
    if ($search_businesstradeno != '') {
        $sqlArray[2] = $sqlArray[2] . "and businesstradeno='$search_businesstradeno' ";
    }
    if ($search_type != '') {
        $sqlArray[2] = $sqlArray[2] . "and ordertype=$search_type ";
    }
    if ($search_start != '') {
        $sqlArray[2] = $sqlArray[2] . "and createdate>='" . ($search_start . ' 00:00:00') . "' ";
    }
    if ($search_end != '') {
        $sqlArray[2] = $sqlArray[2] . "and createdate<='" . ($search_end . ' 23:59:59') . "' ";
    }
    $result = doQuery($sqlArray, -1, "orderno");
    for ($i = 0; $i < count($result['rows']); $i++) {
        $ordertype = $result['rows'][$i]['cell']['ordertype'];
        $typename = $commonTools->getDatasBySQL("select name from acc_dic_ordertype where code='" . $ordertype . "'");
        if (count($typename) > 0) {
            $result['rows'][$i]['cell']['typename'] = $typename[0]['name'];
        }
        $status = $result['rows'][$i]['cell']['status'];
        $statusname = $commonTools->getDatasBySQL("select name from acc_dic_orderstatus where code='" . $status . "'");
        if (count($statusname) > 0) {
            $result['rows'][$i]['cell']['statusname'] = $statusname[0]['name'];
        }
    }
    echo json_encode($result);
    die();
}