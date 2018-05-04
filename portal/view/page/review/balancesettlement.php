<?php
/**
 * Created by PhpStorm.
 * User: zhangbin
 * Date: 2017/5/12
 * Time: 10:25
 */
require dirname(__FILE__) . '/../../common/pageHead.php';
?>
<html <?php echo $GLOBALS['html_attr'] ?>>
<head>
    <title>C户余额提现订单管理</title>
    <?php require $_SERVER['DOCUMENT_ROOT'] . $GLOBALS['webroot'] . '/view/common/head.php'; ?>
</head>
<body class="<?php echo $GLOBALS['body_class']; ?>">
<div class="page-content no-padding-top">
    <div class="row">
        <div class="col-xs-12">
            <div
                    class="form-horizontal col-xs-12 well no-margin-bottom no-padding-bottom">
                <form id="balanceSettlementReview_conditionform">
                    <div class="form-group">
                        <label class="col-sm-1 control-label no-padding-right" style="width:100px"
                               for="balanceSettlementReview_query_orderno">结算订单号：</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control"
                                   id="balanceSettlementReview_query_orderno"
                                   maxlength="24"/>
                        </div>
                        <label class="col-sm-1 control-label no-padding-right" style="width:100px"
                               for="balanceSettlementReview_query_businessid">B户客户号：</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control"
                                   id="balanceSettlementReview_query_businessid"
                                   maxlength="27"/>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-xs-12 well no-margin-bottom" style="padding: 5px;">
                <div class="div-grid-button-area-b">
                    <button type="button" class="btn btn-xs btn-primary"
                            id="balanceSettlementReview_reset_btn">重置查询条件
                    </button>
                    <button type="button" class="btn btn-xs btn-primary"
                            id="balanceSettlementReview_query_btn">
                        <i class="ace-icon fa fa-search bigger-120"></i> 查询
                    </button>
                </div>
            </div>
            <div class="col-xs-12 no-padding">
                <table id="balanceSettlementReview_grid_table"></table>
                <div id="balanceSettlementReview_grid_pager"></div>
            </div>
        </div>
    </div>
</div>
<?php require $_SERVER['DOCUMENT_ROOT'] . $GLOBALS['webroot'] . '/view/common/foot.php'; ?>
<script type="text/javascript" defer async="async"
        charset="<?php echo $GLOBALS['charset']; ?>"
        src="<?php echo $GLOBALS['webroot'] . '/script/page/review/balancesettlement.js?v=1.0.0'; ?>"></script>
</body>
</html>