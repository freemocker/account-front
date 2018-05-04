<?php
/**
 * Created by PhpStorm.
 * User: zhangbin
 * Date: 2016/10/13
 * Time: 13:58
 */
require dirname(__FILE__) . '/../../common/pageHead.php';
?>
<html <?php echo $GLOBALS['html_attr'] ?>>
<head>
    <title>C户管理</title>
    <?php require $_SERVER['DOCUMENT_ROOT'] . $GLOBALS['webroot'] . '/view/common/head.php'; ?>
</head>
<body class="<?php echo $GLOBALS['body_class']; ?>">
<div class="page-content no-padding-top">
    <div class="row">
        <div class="col-xs-12">
            <div
                class="form-horizontal col-xs-12 well no-margin-bottom no-padding-bottom">
                <form id="custAccountMng_conditionform">
                    <div class="form-group">
                        <label class="col-sm-1 control-label no-padding-right" style="width:100px"
                               for="custAccountMng_query_custid">C户客户号：</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control"
                                   id="custAccountMng_query_custid"
                                   name="custAccountMng_query_custid"
                                   maxlength="27"/>
                        </div>
                        <label class="col-sm-1 control-label no-padding-right" style="width:100px"
                               for="custAccountMng_query_telephone">电话号码：</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control"
                                   id="custAccountMng_query_telephone"
                                   name="custAccountMng_query_telephone"
                                   maxlength="11"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-1 control-label no-padding-right" style="width:100px"
                               for="custAccountMng_query_channel">注册渠道号：</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control"
                                   id="custAccountMng_query_channel"
                                   name="custAccountMng_query_channel"
                                   maxlength="15"/>
                        </div>
                        <label class="col-sm-1 control-label no-padding-right" style="width:100px"
                               for="custAccountMng_query_status">状态：</label>
                        <div class="col-sm-4">
                            <select class="form-control"
                                    id="custAccountMng_query_status"
                                    name="custAccountMng_query_status">
                                <option value=""></option>
                                <option value="1">激活</option>
                                <option value="0">禁用</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-xs-12 well no-margin-bottom" style="padding: 5px;">
                <div class="div-grid-button-area-b">
                    <button type="button" class="btn btn-xs btn-primary"
                            id="custAccountMng_reset_btn">重置查询条件
                    </button>
                    <button type="button" class="btn btn-xs btn-primary"
                            id="custAccountMng_query_btn">
                        <i class="ace-icon fa fa-search bigger-120"></i> 查询
                    </button>
                </div>
            </div>
            <div class="col-xs-12 no-padding">
                <table id="custAccountMng_grid_table"></table>
                <div id="custAccountMng_grid_pager"></div>
            </div>
        </div>
    </div>
</div>
<?php require $_SERVER['DOCUMENT_ROOT'] . $GLOBALS['webroot'] . '/view/common/foot.php'; ?>
<script type="text/javascript" defer async="async"
        charset="<?php echo $GLOBALS['charset']; ?>"
        src="<?php echo $GLOBALS['webroot'] . '/script/page/account/custAccountMng.js?v=1.0.0'; ?>"></script>
</body>
</html>