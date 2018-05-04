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
    <title>内部账科目汇总</title>
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
                <form id="his_innersummary_conditionform">
                    <div class="form-group">
                        <label class="col-sm-1 control-label no-padding-right conditionLable"
                               for="his_innersummary_query_businessid">B客户号</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control"
                                   id="his_innersummary_query_businessid"
                                   maxlength="27"/>
                        </div>
                        <label class="col-sm-1 control-label no-padding-right conditionLable"
                               for="his_innersummary_query_accountdate">会计日期</label>
                        <div class="col-sm-2">
                            <div class="input-group">
                                <input type="text" class="form-control"
                                       id="his_innersummary_query_accountdate"
                                       value="<?php echo \service\tools\ToolsClass::getNowDay(); ?>"/>
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar bigger-110"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                    </div>
                </form>
            </div>
            <div class="col-xs-12 well no-margin-bottom" style="padding: 5px;">
                <div class="div-grid-button-area-b">
                    <button type="button" class="btn btn-xs btn-primary"
                            id="his_innersummary_reset_btn">重置查询条件
                    </button>
                    <button type="button" class="btn btn-xs btn-primary"
                            id="his_innersummary_query_btn">
                        <i class="ace-icon fa fa-search bigger-120"></i> 查询
                    </button>
                </div>
            </div>
            <div class="col-xs-12 no-padding">
                <table id="his_innersummary_grid_table"></table>
                <div id="his_innersummary_grid_pager"></div>
            </div>
        </div>
    </div>
</div>
<?php require $_SERVER['DOCUMENT_ROOT'] . $GLOBALS['webroot'] . '/view/common/foot.php'; ?>
<script type="text/javascript" defer async="async"
        charset="<?php echo $GLOBALS['charset']; ?>"
        src="<?php echo $GLOBALS['webroot'] . '/script/page/query/history/innersummary.js?v=1.0.0'; ?>"></script>
</body>
</html>