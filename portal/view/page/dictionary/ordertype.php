<?php
/**
 * Created by PhpStorm.
 * User: zhangbin
 * Date: 2016/9/13
 * Time: 17:14
 */
require dirname(__FILE__) . '/../../common/pageHead.php';
?>
<html <?php echo $GLOBALS['html_attr'] ?>>
<head>
    <title>订单类型</title>
    <?php require $_SERVER['DOCUMENT_ROOT'] . $GLOBALS['webroot'] . '/view/common/head.php'; ?>
</head>
<body class="<?php echo $GLOBALS['body_class']; ?>">
<div class="page-content no-padding-top">
    <div class="row">
        <div class="col-xs-12">
            <div
                    class="form-horizontal col-xs-12 well no-margin-bottom no-padding-bottom">
                <form id="dic_ordertype_conditionform">
                    <div class="form-group">
                        <label class="col-sm-1 control-label no-padding-right"
                               for="dic_ordertype_query_name">名称：</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" maxlength="40"
                                   id="dic_ordertype_query_name"
                                   name="dic_ordertype_query_name"/>
                        </div>
                        <label class="col-sm-1 control-label no-padding-right"
                               for="dic_ordertype_query_code">编码：</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" maxlength="40"
                                   id="dic_ordertype_query_code"
                                   name="dic_ordertype_query_code"/>
                        </div>
                        <label class="col-sm-1 control-label no-padding-right"
                               for="dic_accountItem_query_type">需审核：</label>
                        <div class="col-sm-2">
                            <select class="form-control"
                                    id="dic_accountItem_query_type"
                                    name="dic_accountItem_query_type">
                                <option value=""></option>
                                <option value="1">是</option>
                                <option value="2">否</option>
                            </select>
                        </div>
                        <label class="col-sm-1 control-label no-padding-right"
                               for="dic_ordertype_query_status">状态：</label>
                        <div class="col-sm-2">
                            <select class="form-control"
                                    id="dic_ordertype_query_status"
                                    name="dic_ordertype_query_status">
                                <option value=""></option>
                                <option value="1">启用</option>
                                <option value="0">禁用</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right"
                               for="dic_ordertype_query_field5">是否配置发生额规则：</label>
                        <div class="col-sm-1">
                            <select class="form-control"
                                    id="dic_ordertype_query_field5"
                                    name="dic_ordertype_query_field5">
                                <option value=""></option>
                                <option value="1">是</option>
                                <option value="0">否</option>
                            </select>
                        </div>
                        <label class="col-sm-3 control-label no-padding-right"
                               for="dic_ordertype_query_field3">是否配置余额规则：</label>
                        <div class="col-sm-1">
                            <select class="form-control"
                                    id="dic_ordertype_query_field3"
                                    name="dic_ordertype_query_field3">
                                <option value=""></option>
                                <option value="1">是</option>
                                <option value="0">否</option>
                            </select>
                        </div>
                        <label class="col-sm-3 control-label no-padding-right"
                               for="dic_ordertype_query_field4">是否配置会计规则：</label>
                        <div class="col-sm-1">
                            <select class="form-control"
                                    id="dic_ordertype_query_field4"
                                    name="dic_ordertype_query_field4">
                                <option value=""></option>
                                <option value="1">是</option>
                                <option value="0">否</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-xs-12 well no-margin-bottom" style="padding: 5px;">
                <div class="div-grid-button-area-b">
                    <button type="button" class="btn btn-xs btn-primary"
                            id="dic_ordertype_reset_btn">重置查询条件
                    </button>
                    <button type="button" class="btn btn-xs btn-primary"
                            id="dic_ordertype_query_btn">
                        <i class="ace-icon fa fa-search bigger-120"></i> 查询
                    </button>
                </div>
                <div class="div-grid-button-area-p">
                    <button type="button" class="btn btn-xs btn-primary"
                            id="dic_ordertype_add_btn">
                        <i class="ace-icon fa fa-plus bigger-120"></i> 新增
                    </button>
                </div>
            </div>
            <div class="col-xs-12 no-padding">
                <table id="dic_ordertype_grid_table"></table>
                <div id="dic_ordertype_grid_pager"></div>
            </div>
        </div>
    </div>
</div>
<?php require $_SERVER['DOCUMENT_ROOT'] . $GLOBALS['webroot'] . '/view/common/foot.php'; ?>
<script type="text/javascript" defer async="async"
        charset="<?php echo $GLOBALS['charset']; ?>"
        src="<?php echo $GLOBALS['webroot'] . '/script/page/dictionary/ordertype.js?v=1.0.0'; ?>"></script>
</body>
</html>