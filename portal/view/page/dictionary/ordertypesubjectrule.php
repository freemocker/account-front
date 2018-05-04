<?php
/**
 * Created by PhpStorm.
 * User: zhangbin
 * Date: 2016/10/25
 * Time: 13:12
 */
require dirname(__FILE__) . '/../../common/pageHead.php';
$commonTools = new \service\tools\ToolsClass();
?>
<html <?php echo $GLOBALS['html_attr'] ?>>
<head>
    <title>订单会计分录规则</title>
    <?php require $_SERVER['DOCUMENT_ROOT'] . $GLOBALS['webroot'] . '/view/common/head.php'; ?>
</head>
<body class="<?php echo $GLOBALS['body_class']; ?>">
<input type="hidden" id="dic_ordertype_subjectrule_typeid" value="<?php echo $_GET['typeid']; ?>"/>
<input type="hidden" id="dic_ordertype_subjectrule_typecode" value="<?php echo $_GET['typecode']; ?>"/>
<?php
$statuses = $commonTools->getDatasBySQL("select code,name from acc_dic_orderstatus order by code asc");
$statusstr = ':';
foreach ($statuses as $status) {
    $statusstr .= ';' . $status['code'] . ':' . $status['name'];
}
$businesses = $commonTools->getDatasBySQL("select businessid,businessname from acc_business_account where status in(0,1) order by createdate asc");
$businessesstr = ':';
foreach ($businesses as $business) {
    $businessesstr .= ';' . $business['businessid'] . ':' . $business['businessname'];
}
$amontdetails = $commonTools->getDatasBySQL("select id,name from acc_dic_ordertype_amontdetailrule where ordertypeid='" . $_GET['typeid'] . "' order by sort asc");
$amontdetailstr = ':';
foreach ($amontdetails as $amontdetail) {
    $amontdetailstr .= ';' . $amontdetail['id'] . ':' . $amontdetail['name'];
}
$paytypes = $commonTools->getDatasBySQL("select name,code from acc_dic_paytype order by code asc");
$paytypestr = ':';
foreach ($paytypes as $paytype) {
    $paytypestr .= ';' . $paytype['code'] . ':' . $paytype['name'];
}
$accountsubitems = $commonTools->getDatasBySQL("select id,name,code from acc_dic_account_item where field5='4' order by code asc");
$accountsubitemstr = ':';
foreach ($accountsubitems as $accountsubitem) {
    $accountsubitemstr .= ';' . $accountsubitem['id'] . ':' . $accountsubitem['name'] . '(' . $accountsubitem['code'] . ')';
}
?>
<input type="hidden" id="dic_ordertype_subjectrule_statusstr" value="<?php echo $statusstr; ?>"/>
<input type="hidden" id="dic_ordertype_balancerule_businessesstr" value="<?php echo $businessesstr; ?>"/>
<input type="hidden" id="dic_ordertype_subjectrule_paytypestr" value="<?php echo $paytypestr; ?>"/>
<input type="hidden" id="dic_ordertype_subjectrule_accountsubitemstr" value="<?php echo $accountsubitemstr; ?>"/>
<input type="hidden" id="dic_ordertype_subjectrule_amontdetailstr" value="<?php echo $amontdetailstr; ?>"/>
<div class="page-content no-padding-top">
    <div class="form-group">
        <div class="bigger-120 red"><?php echo $_REQUEST['typename'] . '——' . $_REQUEST['typecode']; ?></div>
    </div>
    <div class="row">
        <table id="dic_ordertype_subjectrule_grid_table"></table>
        <div id="dic_ordertype_subjectrule_grid_pager"></div>
    </div>
</div>
<?php require $_SERVER['DOCUMENT_ROOT'] . $GLOBALS['webroot'] . '/view/common/foot.php'; ?>
<script type="text/javascript" defer async="async"
        charset="<?php echo $GLOBALS['charset']; ?>"
        src="<?php echo $GLOBALS['webroot'] . '/script/page/dictionary/ordertypesubjectrule.js?v=1.0.0'; ?>"></script>
</body>
</html>