<?php
/**
 * Created by PhpStorm.
 * User: zhangbin
 * Date: 2016/10/14
 * Time: 13:55
 */
require dirname(__FILE__) . '/../../../common/pageHead.php';
?>
<html <?php echo $GLOBALS['html_attr'] ?>>
<head>
    <title>订单审核记录</title>
    <?php require $_SERVER['DOCUMENT_ROOT'] . $GLOBALS['webroot'] . '/view/common/head.php'; ?>
</head>
<body class="<?php echo $GLOBALS['body_class']; ?>">
<div class="page-content no-padding-top">
    <div class="row">
        <div class="col-xs-12">
            <div class="form-horizontal col-xs-12 well no-margin-bottom no-padding-bottom">
                <form id="his_orderReviewRecord_conditionform">
                    <div class="form-group">
                        <label class="col-sm-1 control-label no-padding-right" style="width:100px"
                               for="his_orderReviewRecord_query_orderno">订单号：</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control"
                                   id="his_orderReviewRecord_query_orderno"
                                   maxlength="24"/>
                        </div>
                        <label class="col-sm-1 control-label no-padding-right" style="width:100px"
                               for="his_orderReviewRecord_query_result">审核结果：</label>
                        <div class="col-sm-3">
                            <select class="form-control" id="his_orderReviewRecord_query_result">
                                <option value=""></option>
                                <option value="1">通过</option>
                                <option value="0">不通过</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-1 control-label no-padding-right" style="width:100px"
                               for="his_orderReviewRecord_query_date_start">审核时间：</label>
                        <div class="col-sm-9">
                            <div class="input-daterange input-group">
                                <input type="text" class="form-control" id="his_orderReviewRecord_query_date_start"
                                       value="<?php echo \service\tools\ToolsClass::getNowDay(); ?>"/>
                                <span class="input-group-addon"><i class="fa fa-exchange"></i></span>
                                <input type="text" class="form-control" id="his_orderReviewRecord_query_date_end"
                                       value="<?php echo \service\tools\ToolsClass::getNowDay(); ?>"/>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-xs-12 well no-margin-bottom" style="padding: 5px;">
                <div class="div-grid-button-area-b">
                    <button type="button" class="btn btn-xs btn-primary"
                            id="his_orderReviewRecord_reset_btn">重置查询条件
                    </button>
                    <button type="button" class="btn btn-xs btn-primary"
                            id="his_orderReviewRecord_query_btn">
                        <i class="ace-icon fa fa-search bigger-120"></i> 查询
                    </button>
                </div>
            </div>
            <div class="col-xs-12 no-padding">
                <table id="his_orderReviewRecord_grid_table"></table>
                <div id="his_orderReviewRecord_grid_pager"></div>
            </div>
        </div>
    </div>
</div>
<?php require $_SERVER['DOCUMENT_ROOT'] . $GLOBALS['webroot'] . '/view/common/foot.php'; ?>
<script type="text/javascript" defer async="async"
        charset="<?php echo $GLOBALS['charset']; ?>"
        src="<?php echo $GLOBALS['webroot'] . '/script/page/query/history/reviewRecord.js?v=1.0.0'; ?>"></script>
</body>
</html>