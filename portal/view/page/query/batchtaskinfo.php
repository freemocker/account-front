<?php
/**
 * Created by PhpStorm.
 * User: zhangbin
 * Date: 2017/5/13
 * Time: 22:35
 */
require dirname(__FILE__) . '/../../common/pageHead.php';
?>
<html <?php echo $GLOBALS['html_attr'] ?>>
<head>
    <title>批量任务执行情况</title>
    <?php
    require $_SERVER['DOCUMENT_ROOT'] . $GLOBALS['webroot'] . '/view/common/head.php';
    $batchtaskexcute = service\user\UserManagerClass::validatePermissions($GLOBALS['application']->getId(), $user->getId(), 'batchtask_excute');
    ?>
</head>
<body class="<?php echo $GLOBALS['body_class']; ?>">
<?php
if ($batchtaskexcute) {
    ?>
    <input type="hidden" id="query_batchtaskinfo_excuteable" value="true"/>
    <?php
} else {
    ?>
    <input type="hidden" id="query_batchtaskinfo_excuteable" value="false"/>
    <?php
}
?>
<div class="page-content no-padding-top">
    <div class="row">
        <div class="col-xs-12">
            <div class="form-horizontal col-xs-12 well no-margin-bottom no-padding-bottom">
                <form id="query_batchtaskinfo_conditionform">
                    <div class="form-group">
                        <label class="col-sm-2 control-label no-padding-right"
                               for="query_batchtaskinfo_query_taskname">任务名称：</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control"
                                   id="query_batchtaskinfo_query_taskname"
                                   name="query_batchtaskinfo_query_taskname"/>
                        </div>
                        <label class="col-sm-2 control-label no-padding-right"
                               for="query_batchtaskinfo_query_taskclassname">任务类名：</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control"
                                   id="query_batchtaskinfo_query_taskclassname"
                                   name="query_batchtaskinfo_query_taskclassname"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label no-padding-right"
                               for="query_batchtaskinfo_query_status">状态：</label>
                        <div class="col-sm-4">
                            <select class="form-control" id="query_batchtaskinfo_query_status"
                                    name="query_batchtaskinfo_query_status">
                                <option value=""></option>
                                <option value="1">开始</option>
                                <option value="2">处理中</option>
                                <option value="3">忽略</option>
                                <option value="4">成功</option>
                                <option value="-1">失败</option>
                            </select>
                        </div>
                        <label class="col-sm-2 control-label no-padding-right"
                               for="query_batchtaskinfo_query_accountdate">会计日期：</label>
                        <div class="col-sm-4">
                            <div class="input-group">
                                <input type="text" class="form-control"
                                       id="query_batchtaskinfo_query_accountdate"
                                       name="query_batchtaskinfo_query_accountdate"/>
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar bigger-110"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-xs-12 well no-margin-bottom" style="padding: 5px;">
                <div class="div-grid-button-area-b">
                    <button type="button" class="btn btn-xs btn-primary"
                            id="query_batchtaskinfo_reset_btn">重置查询条件
                    </button>
                    <button type="button" class="btn btn-xs btn-primary"
                            id="query_batchtaskinfo_query_btn">
                        <i class="ace-icon fa fa-search bigger-120"></i> 查询
                    </button>
                </div>
            </div>
            <div class="col-xs-12 no-padding">
                <table id="query_batchtaskinfo_grid_table"></table>
                <div id="query_batchtaskinfo_grid_pager"></div>
            </div>
        </div>
    </div>
</div>
<?php require $_SERVER['DOCUMENT_ROOT'] . $GLOBALS['webroot'] . '/view/common/foot.php'; ?>
<script type="text/javascript" defer async="async"
        charset="<?php echo $GLOBALS['charset']; ?>"
        src="<?php echo $GLOBALS['webroot'] . '/script/page/query/batchtaskinfo.js?v=1.0.0'; ?>"></script>
</body>
</html>