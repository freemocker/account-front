<?php
/**
 * Created by PhpStorm.
 * User: zhang
 * Date: 2016/8/10
 * Time: 12:08
 */
require dirname(__FILE__) . '/../../common/pageHead.php';
?>
<html <?php echo $GLOBALS['html_attr'] ?>>
<head>
    <title>会计科目</title>
    <?php require $_SERVER['DOCUMENT_ROOT'] . $GLOBALS['webroot'] . '/view/common/head.php'; ?>
</head>
<body class="<?php echo $GLOBALS['body_class']; ?>">
<div class="page-content no-padding-top">
    <div class="row">
        <div class="col-xs-12">
            <div
                class="form-horizontal col-xs-12 well no-margin-bottom no-padding-bottom">
                <form id="dic_accountitem_conditionform">
                    <div class="form-group">
                        <label class="col-sm-1 control-label no-padding-right"
                               for="dic_accountitem_query_name">名称：</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" maxlength="40"
                                   id="dic_accountitem_query_name"/>
                        </div>
                        <label class="col-sm-1 control-label no-padding-right"
                               for="dic_accountitem_query_code">编码：</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" maxlength="40"
                                   id="dic_accountitem_query_code"/>
                        </div>
                        <label class="col-sm-1 control-label no-padding-right"
                               for="dic_accountitem_query_parent">上级名称：</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" maxlength="40"
                                   id="dic_accountitem_query_parent"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-1 control-label no-padding-right"
                               for="dic_accountitem_query_field1">余额方向：</label>
                        <div class="col-sm-2">
                            <select class="form-control"
                                    id="dic_accountitem_query_field1">
                                <option value=""></option>
                                <option value="1">借</option>
                                <option value="2">贷</option>
                                <option value="3">共同</option>
                            </select>
                        </div>
                        <label class="col-sm-1 control-label no-padding-right"
                               for="dic_accountitem_query_field2">科目类型：</label>
                        <div class="col-sm-2">
                            <select class="form-control"
                                    id="dic_accountitem_query_field2">
                                <option value=""></option>
                                <option value="1">资产类</option>
                                <option value="2">负债类</option>
                                <option value="3">共同类</option>
                                <option value="4">所有者权益类</option>
                                <option value="5">成本类</option>
                                <option value="6">损益类</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-xs-12 well no-margin-bottom" style="padding: 5px;">
                <div class="div-grid-button-area-b">
                    <button type="button" class="btn btn-xs btn-primary"
                            id="dic_accountitem_reset_btn">重置查询条件
                    </button>
                    <button type="button" class="btn btn-xs btn-primary"
                            id="dic_accountitem_query_btn">
                        <i class="ace-icon fa fa-search bigger-120"></i> 查询
                    </button>
                </div>
                <div class="div-grid-button-area-p">
                    <button type="button" class="btn btn-xs btn-primary"
                            id="dic_accountitem_add_btn">
                        <i class="ace-icon fa fa-plus bigger-120"></i> 新增
                    </button>
                </div>
            </div>
            <div class="col-xs-12 no-padding">
                <table id="dic_accountitem_grid_table"></table>
                <div id="dic_accountitem_grid_pager"></div>
            </div>
        </div>
    </div>
</div>
<?php require $_SERVER['DOCUMENT_ROOT'] . $GLOBALS['webroot'] . '/view/common/foot.php'; ?>
<script type="text/javascript" defer async="async"
        charset="<?php echo $GLOBALS['charset']; ?>"
        src="<?php echo $GLOBALS['webroot'] . '/script/page/dictionary/accountItem.js?v=1.0.0'; ?>"></script>
</body>
</html>