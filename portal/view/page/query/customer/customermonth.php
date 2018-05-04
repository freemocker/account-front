<?php
/**
 * Created by PhpStorm.
 * User: zhangbin
 * Date: 2017/5/15
 * Time: 10:19
 */
require dirname(__FILE__) . '/../../../common/pageHead.php';
?>
<html <?php echo $GLOBALS['html_attr'] ?>>
<head>
    <title>客户账统计</title>
    <?php
    require $_SERVER['DOCUMENT_ROOT'] . $GLOBALS['webroot'] . '/view/common/head.php';
    $commonTools = new \service\tools\ToolsClass();
    ?>
    <style type="text/css">
        .conditionLable {
            width: 80px;
        }
    </style>
</head>
<body class="<?php echo $GLOBALS['body_class']; ?>">
<div class="page-content no-padding-top">
    <div class="row">
        <div class="col-xs-12">
            <div class="form-horizontal col-xs-12 well no-margin-bottom no-padding-bottom">
                <form id="customermonth_conditionform">
                    <div class="form-group">
                        <label class="col-sm-1 control-label no-padding-right conditionLable"
                               for="customermonth_query_custid">C客户号</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control"
                                   id="customermonth_query_custid"
                                   maxlength="27"/>
                        </div>
                        <label class="col-sm-1 control-label no-padding-right conditionLable"
                               for="customermonth_query_custsubaccountcode">子账户号</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control"
                                   id="customermonth_query_custsubaccountcode"
                                   maxlength="32"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-1 control-label no-padding-right conditionLable"
                               for="customermonth_query_type">账户类型</label>
                        <div class="col-sm-3">
                            <select class="form-control" id="customermonth_query_type">
                                <option value=""></option>
                                <?php
                                $types = $commonTools->getDatasBySQL("select name,code from acc_dic_account_type order by code asc");
                                foreach ($types as $type) {
                                    echo '<option value="' . $type['code'] . '">' . $type['name'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <label class="col-sm-1 control-label no-padding-right conditionLable"
                               for="customermonth_query_date_start">统计年月</label>
                        <div class="col-sm-5">
                            <div class="input-daterange input-group">
                                <input type="text" class="form-control" id="customermonth_query_date_start"
                                       value="<?php echo date('Y-m', strtotime('-1 month')); ?>"/>
                                <span class="input-group-addon"><i class="fa fa-exchange"></i></span>
                                <input type="text" class="form-control" id="customermonth_query_date_end"
                                       value="<?php echo date('Y-m', strtotime('-1 month')); ?>"/>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-xs-12 well no-margin-bottom" style="padding: 5px;">
                <div class="div-grid-button-area-b">
                    <button type="button" class="btn btn-xs btn-primary"
                            id="customermonth_reset_btn">重置查询条件
                    </button>
                    <button type="button" class="btn btn-xs btn-primary"
                            id="customermonth_query_btn">
                        <i class="ace-icon fa fa-search bigger-120"></i> 查询
                    </button>
                </div>
            </div>
            <div class="col-xs-12 no-padding">
                <table id="customermonth_grid_table"></table>
                <div id="customermonth_grid_pager"></div>
            </div>
        </div>
    </div>
</div>
<?php require $_SERVER['DOCUMENT_ROOT'] . $GLOBALS['webroot'] . '/view/common/foot.php'; ?>
<script type="text/javascript" defer async="async"
        charset="<?php echo $GLOBALS['charset']; ?>"
        src="<?php echo $GLOBALS['webroot'] . '/script/page/query/customer/customermonth.js?v=1.0.0'; ?>"></script>
</body>
</html>