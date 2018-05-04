<?php
/**
 * Created by PhpStorm.
 * User: zhangbin
 * Date: 2016/12/15
 * Time: 15:38
 */
require dirname(__FILE__) . '/../../common/pageHead.php';
?>
<html <?php echo $GLOBALS['html_attr'] ?>>
<head>
    <title>积分参数</title>
    <?php require $_SERVER['DOCUMENT_ROOT'] . $GLOBALS['webroot'] . '/view/common/head.php'; ?>
</head>
<body class="<?php echo $GLOBALS['body_class']; ?>">
<div class="page-content no-padding-top">
    <div class="row">
        <div class="col-xs-12">
            <div class="form-horizontal col-xs-12 well no-margin-bottom no-padding-bottom">
                <form id="dic_intergralparam_conditionform">
                    <div class="form-group">
                        <label class="col-sm-1 control-label no-padding-right"
                               for="dic_intergralparam_query_name">名称：</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" maxlength="40"
                                   id="dic_intergralparam_query_name"
                                   name="dic_intergralparam_query_name"/>
                        </div>
                        <label class="col-sm-2 control-label no-padding-right"
                               for="dic_intergralparam_query_code">编码：</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" maxlength="40"
                                   id="dic_intergralparam_query_code"
                                   name="dic_intergralparam_query_code"/>
                        </div>
                        <label class="col-sm-1 control-label no-padding-right"
                               for="dic_intergralparam_query_status">状态：</label>
                        <div class="col-sm-2">
                            <select class="form-control"
                                    id="dic_intergralparam_query_status"
                                    name="dic_intergralparam_query_status">
                                <option value=""></option>
                                <option value="1">启用</option>
                                <option value="0">禁用</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-1 control-label no-padding-right"
                               for="dic_intergralparam_query_type">类型：</label>
                        <div class="col-sm-2">
                            <select class="form-control"
                                    id="dic_intergralparam_query_type"
                                    name="dic_intergralparam_query_type">
                                <option value=""></option>
                                <option value="1">积分价值</option>
                            </select>
                        </div>
                        <label class="col-sm-2 control-label no-padding-right"
                               for="dic_intergralparam_query_field1">有效期类型：</label>
                        <div class="col-sm-2">
                            <select class="form-control"
                                    id="dic_intergralparam_query_field1"
                                    name="dic_intergralparam_query_field1">
                                <option value=""></option>
                                <option value="0">会计日期</option>
                                <option value="1">系统日期</option>
                            </select>
                        </div>
                        <label class="col-sm-1 control-label no-padding-right"
                               for="dic_intergralparam_query_field2">有效日期：</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="dic_intergralparam_query_field2"/>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-xs-12 well no-margin-bottom" style="padding: 5px;">
                <div class="div-grid-button-area-b">
                    <button type="button" class="btn btn-xs btn-primary"
                            id="dic_intergralparam_reset_btn">重置查询条件
                    </button>
                    <button type="button" class="btn btn-xs btn-primary"
                            id="dic_intergralparam_query_btn">
                        <i class="ace-icon fa fa-search bigger-120"></i> 查询
                    </button>
                </div>
                <div class="div-grid-button-area-p">
                    <button type="button" class="btn btn-xs btn-primary"
                            id="dic_intergralparam_add_btn">
                        <i class="ace-icon fa fa-plus bigger-120"></i> 新增
                    </button>
                </div>
            </div>
            <div class="col-xs-12 no-padding">
                <table id="dic_intergralparam_grid_table"></table>
                <div id="dic_intergralparam_grid_pager"></div>
            </div>
        </div>
    </div>
</div>
<?php require $_SERVER['DOCUMENT_ROOT'] . $GLOBALS['webroot'] . '/view/common/foot.php'; ?>
<script type="text/javascript" defer async="async"
        charset="<?php echo $GLOBALS['charset']; ?>"
        src="<?php echo $GLOBALS['webroot'] . '/script/page/dictionary/intergralparam.js?v=1.0.0'; ?>"></script>
</body>
</html>