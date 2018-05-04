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
    $commonTools = new \service\tools\ToolsClass(2);
    $search_custid = $_POST['search_custid'];
    $search_custsubaccountcode = $_POST['search_custsubaccountcode'];
    $search_type = $_POST['search_type'];
    $search_start = $_POST['search_start'];
    $search_end = isset($_POST['search_end']) ? $_POST['search_end'] : "";
    $sqlArray = array();
    if (isset($_POST['searchType'])) {
        switch ($_POST['searchType']) {
            case "month":
                $year = substr($search_start, 0, 4);
                $table = '(select * from acc_cust_monthstatistics where 1=1 ';
                if ($search_start != '') {
                    $table = $table . "and yearmonth>='$search_start' ";
                }
                if ($search_end != '') {
                    $table = $table . "and yearmonth<='$search_end' ";
                }
                $tablenames = $commonTools->getDatasBySQL("select code from acc_batch_histables where parentid='acc_cust_monthstatistics' and code >= 'acc_cust_monthstatistics_$year' order by code desc");
                foreach ($tablenames as $tablename) {
                    $table = $table . " union all select * from " . $tablename['code'] . " where 1=1 ";
                    if ($search_start != '') {
                        $table = $table . "and yearmonth>='$search_start' ";
                    }
                    if ($search_end != '') {
                        $table = $table . "and yearmonth<='$search_end' ";
                    }
                }
                $table = $table . ')t';
                $sqlArray[0] = "*";
                $sqlArray[1] = $table;
                $sqlArray[2] = "where 1=1 ";
                break;
            case "year":
                $sqlArray[0] = "*";
                $sqlArray[1] = "acc_cust_yearstatistics_" . $search_start;
                $sqlArray[2] = "where 1=1 ";
                break;
            default:
                die();
        }
    }
    if ($search_custid != '') {
        $sqlArray[2] = $sqlArray[2] . "and custid='$search_custid' ";
    }
    if ($search_custsubaccountcode != '') {
        $sqlArray[2] = $sqlArray[2] . "and custsubaccountcode='$search_custsubaccountcode' ";
    }
    if ($search_type != '') {
        $sqlArray[2] = $sqlArray[2] . "and type='$search_type' ";
    }
    $result = doQuery($sqlArray, 2);
    $commonTools = new \service\tools\ToolsClass();
    for ($i = 0; $i < count($result['rows']); $i++) {
        $type = $result['rows'][$i]['cell']['type'];
        $typename = $commonTools->getDatasBySQL("select name from acc_dic_account_type where type='" . $type . "'");
        if (count($typename) > 0) {
            $result['rows'][$i]['cell']['typename'] = $typename[0]['name'];
        }
    }
    echo json_encode($result);
    die();
}