<?php
/**
 * Created by PhpStorm.
 * User: zhang
 * Date: 2016/8/15
 * Time: 10:42
 */
require dirname(__FILE__) . '/../../common/pageHead.php';
?>
<html <?php echo $GLOBALS['html_attr'] ?>>
<head>
    <title>B户管理</title>
    <?php require $_SERVER['DOCUMENT_ROOT'] . $GLOBALS['webroot'] . '/view/common/head.php'; ?>
</head>
<body class="<?php echo $GLOBALS['body_class']; ?>">
<div class="page-content no-padding-top">
    <div class="row">
        <div class="col-xs-12">
            <div
                class="form-horizontal col-xs-12 well no-margin-bottom no-padding-bottom">
                <form id="businessAccountMng_conditionform">
                    <div class="form-group">
                        <label class="col-sm-1 control-label no-padding-right" style="width:100px"
                               for="businessAccountMng_query_businessid">B户客户号：</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control"
                                   id="businessAccountMng_query_businessid"
                                   name="businessAccountMng_query_businessid"
                                   maxlength="27"/>
                        </div>
                        <label class="col-sm-1 control-label no-padding-right" style="width:100px"
                               for="businessAccountMng_query_businessname">B户名称：</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control"
                                   id="businessAccountMng_query_businessname"
                                   name="businessAccountMng_query_businessname"
                                   maxlength="40"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-1 control-label no-padding-right" style="width:100px"
                               for="businessAccountMng_query_channel">渠道号：</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control"
                                   id="businessAccountMng_query_channel"
                                   name="businessAccountMng_query_channel"
                                   maxlength="15"/>
                        </div>
                        <label class="col-sm-1 control-label no-padding-right" style="width:100px"
                               for="businessAccountMng_query_name">法人：</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control"
                                   id="businessAccountMng_query_name"
                                   name="businessAccountMng_query_name"
                                   maxlength="10"/>
                        </div>
                        <label class="col-sm-1 control-label no-padding-right"
                               for="businessAccountMng_query_status">状态：</label>
                        <div class="col-sm-2">
                            <select class="form-control"
                                    id="businessAccountMng_query_status"
                                    name="businessAccountMng_query_status">
                                <option value=""></option>
                                <option value="1">激活</option>
                                <option value="2">注册中</option>
                                <option value="0">禁用</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-xs-12 well no-margin-bottom" style="padding: 5px;">
                <div class="div-grid-button-area-b">
                    <button type="button" class="btn btn-xs btn-primary"
                            id="businessAccountMng_reset_btn">重置查询条件
                    </button>
                    <button type="button" class="btn btn-xs btn-primary"
                            id="businessAccountMng_query_btn">
                        <i class="ace-icon fa fa-search bigger-120"></i> 查询
                    </button>
                </div>
                <div class="div-grid-button-area-p">
                    <button type="button" class="btn btn-xs btn-primary"
                            id="businessAccountMng_add_btn">
                        <i class="ace-icon fa fa-plus bigger-120"></i> 注册
                    </button>
                    <button type="button" class="btn btn-xs btn-primary"
                            id="businessAccountMng_del_btn">
                        <i class="ace-icon fa fa-trash-o bigger-120"></i> 删除
                    </button>
                </div>
            </div>
            <div class="col-xs-12 no-padding">
                <table id="businessAccountMng_grid_table"></table>
                <div id="businessAccountMng_grid_pager"></div>
            </div>
        </div>
    </div>
</div>
<?php require $_SERVER['DOCUMENT_ROOT'] . $GLOBALS['webroot'] . '/view/common/foot.php'; ?>
<script type="text/javascript" defer async="async"
        charset="<?php echo $GLOBALS['charset']; ?>"
        src="<?php echo $GLOBALS['webroot'] . '/script/page/account/businessAccountMng.js?v=1.0.0'; ?>"></script>
</body>
</html>