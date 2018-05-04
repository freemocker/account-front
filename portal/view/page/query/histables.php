<?php
/**
 * Created by PhpStorm.
 * User: zhangbin
 * Date: 2016/11/18
 * Time: 20:50
 */
require dirname(__FILE__) . '/../../common/pageHead.php';
?>
<html <?php echo $GLOBALS['html_attr'] ?>>
<head>
    <title>历史数据表对应关系</title>
    <?php require $_SERVER['DOCUMENT_ROOT'] . $GLOBALS['webroot'] . '/view/common/head.php'; ?>
</head>
<body class="<?php echo $GLOBALS['body_class']; ?>">
<div class="page-content no-padding-top">
    <div class="row">
        <div class="col-xs-12">
            <div
                    class="form-horizontal col-xs-12 well no-margin-bottom no-padding-bottom">
                <form id="dic_histables_conditionform">
                    <div class="form-group">
                        <label class="col-sm-2 control-label no-padding-right"
                               for="dic_histables_query_parentid">原数据表名称：</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" maxlength="40"
                                   id="dic_histables_query_parentid"
                                   name="dic_histables_query_parentid"/>
                        </div>
                        <label class="col-sm-2 control-label no-padding-right"
                               for="dic_histables_query_code">历史数据表名称：</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control"
                                   id="dic_histables_query_code"
                                   name="dic_histables_query_code"/>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-xs-12 well no-margin-bottom" style="padding: 5px;">
                <div class="div-grid-button-area-b">
                    <button type="button" class="btn btn-xs btn-primary"
                            id="dic_histables_reset_btn">重置查询条件
                    </button>
                    <button type="button" class="btn btn-xs btn-primary"
                            id="dic_histables_query_btn">
                        <i class="ace-icon fa fa-search bigger-120"></i> 查询
                    </button>
                </div>
            </div>
            <div class="col-xs-12 no-padding">
                <table id="dic_histables_grid_table"></table>
                <div id="dic_histables_grid_pager"></div>
            </div>
        </div>
    </div>
</div>
<?php require $_SERVER['DOCUMENT_ROOT'] . $GLOBALS['webroot'] . '/view/common/foot.php'; ?>
<script type="text/javascript" defer async="async"
        charset="<?php echo $GLOBALS['charset']; ?>"
        src="<?php echo $GLOBALS['webroot'] . '/script/page/query/histables.js?v=1.0.0'; ?>"></script>
</body>
</html>