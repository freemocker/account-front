<?php
/**
 * Created by PhpStorm.
 * User: zhangbin
 * Date: 2016/10/17
 * Time: 10:01
 */
require dirname(__FILE__) . '/../../../common/pageHead.php';
?>
<html <?php echo $GLOBALS['html_attr'] ?>>
<head>
    <title>非余额订单</title>
    <?php
    require $_SERVER['DOCUMENT_ROOT'] . $GLOBALS['webroot'] . '/view/common/head.php';
    $commonTools = new \service\tools\ToolsClass();
    ?>
    <style type="text/css">
        .conditionLable {
            width: 80px;
        }

        .conditionLable-small {
            width: 45px;
        }
    </style>
</head>
<body class="<?php echo $GLOBALS['body_class']; ?>">
<div class="page-content no-padding-top">
    <div class="row">
        <div class="col-xs-12">
            <div
                class="form-horizontal col-xs-12 well no-margin-bottom no-padding-bottom">
                <form id="currencyOrderSearch_conditionform">
                    <div class="form-group">
                        <label class="col-sm-1 control-label no-padding-right conditionLable"
                               for="currencyOrderSearch_query_orderno">订单号</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control"
                                   id="currencyOrderSearch_query_orderno"
                                   maxlength="24"/>
                        </div>
                        <label class="col-sm-1 control-label no-padding-right conditionLable"
                               for="currencyOrderSearch_query_channel">渠道号</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control"
                                   id="currencyOrderSearch_query_channel"
                                   maxlength="15"/>
                        </div>
                        <label class="col-sm-1 control-label no-padding-right conditionLable-small"
                               for="currencyOrderSearch_query_status">状态</label>
                        <div class="col-sm-2">
                            <select class="form-control" id="currencyOrderSearch_query_status">
                                <option value=""></option>
                                <?php
                                $statuses = $commonTools->getDatasBySQL("select name,code from acc_dic_orderstatus where code<>'33' order by code asc");
                                foreach ($statuses as $status) {
                                    echo '<option value="' . $status['code'] . '">' . $status['name'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-1 control-label no-padding-right conditionLable"
                               for="currencyOrderSearch_query_custid">客户号</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control"
                                   id="currencyOrderSearch_query_custid"
                                   maxlength="27"/>
                        </div>
                        <label class="col-sm-1 control-label no-padding-right conditionLable"
                               for="currencyOrderSearch_query_businesstradeno">交易号</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control"
                                   id="currencyOrderSearch_query_businesstradeno"
                                   maxlength="40"/>
                        </div>
                        <label class="col-sm-1 control-label no-padding-right conditionLable-small"
                               for="currencyOrderSearch_query_type">类型</label>
                        <div class="col-sm-2">
                            <select class="form-control" id="currencyOrderSearch_query_type">
                                <option value=""></option>
                                <?php
                                $types = $commonTools->getDatasBySQL("select name,code from acc_dic_ordertype where code in('401','402','403') order by code asc");
                                foreach ($types as $type) {
                                    echo '<option value="' . $type['code'] . '">' . $type['name'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-1 control-label no-padding-right conditionLable"
                               for="currencyOrderSearch_query_date_start">下单时间</label>
                        <div class="col-sm-5">
                            <div class="input-daterange input-group">
                                <input type="text" class="form-control" id="currencyOrderSearch_query_date_start"
                                       value="<?php echo \service\tools\ToolsClass::getNowDay(); ?>"/>
                                <span class="input-group-addon"><i class="fa fa-exchange"></i></span>
                                <input type="text" class="form-control" id="currencyOrderSearch_query_date_end"
                                       value="<?php echo \service\tools\ToolsClass::getNowDay(); ?>"/>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-xs-12 well no-margin-bottom" style="padding: 5px;">
                <div class="div-grid-button-area-b">
                    <button type="button" class="btn btn-xs btn-primary"
                            id="currencyOrderSearch_reset_btn">重置查询条件
                    </button>
                    <button type="button" class="btn btn-xs btn-primary"
                            id="currencyOrderSearch_query_btn">
                        <i class="ace-icon fa fa-search bigger-120"></i> 查询
                    </button>
                </div>
            </div>
            <div class="col-xs-12 no-padding">
                <table id="currencyOrderSearch_grid_table"></table>
                <div id="currencyOrderSearch_grid_pager"></div>
            </div>
        </div>
    </div>
</div>
<?php require $_SERVER['DOCUMENT_ROOT'] . $GLOBALS['webroot'] . '/view/common/foot.php'; ?>
<script type="text/javascript" defer async="async"
        charset="<?php echo $GLOBALS['charset']; ?>"
        src="<?php echo $GLOBALS['webroot'] . '/script/page/query/order/currencyOrderSearch.js?v=1.0.0'; ?>"></script>
</body>
</html>