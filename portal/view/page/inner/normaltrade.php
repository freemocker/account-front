<?php
/**
 * Created by PhpStorm.
 * User: zhangbin
 * Date: 2017/5/12
 * Time: 13:28
 */
require dirname(__FILE__) . '/../../common/pageHead.php';
?>
<html <?php echo $GLOBALS['html_attr'] ?>>
<head>
    <title>账务平台通用记账交易</title>
    <?php
    require $_SERVER['DOCUMENT_ROOT'] . $GLOBALS['webroot'] . '/view/common/head.php';
    $commonTools = new \service\tools\ToolsClass();
    $item = $commonTools->getDatasBySQL("select c.id,c.code,c.name from acc_dic_account_item c where c.field5='3' and c.status=1 order by c.code asc");
    $subitem = $commonTools->getDatasBySQL("select (select pc.code from acc_dic_account_item pc where pc.id=c.parentid) as parentcode,c.code,c.name from acc_dic_account_item c where c.field5='4' and c.status=1 order by c.code asc");
    ?>
</head>
<body class="<?php echo $GLOBALS['body_class']; ?>">
<div class="page-content no-padding-top">
    <input type="hidden" id="normaltrade_applyorderinfo_itemlist" value='<?php echo json_encode($item); ?>'/>
    <input type="hidden" id="normaltrade_applyorderinfo_subitemlist" value='<?php echo json_encode($subitem); ?>'/>
    <div class="page-header">
        <h1>账务平台通用记账交易</h1>
    </div>
    <form class="form-horizontal" id="normaltrade_applyorderinfo_form">
        <div class="form-group no-margin-bottom">
            <div class="form-group col-sm-12 no-padding no-margin-left no-margin-right">
                <label class="col-sm-3 control-label no-padding-right titlelabel"
                       for="normaltrade_applyorderinfo_amont">交易金额：</label>
                <div class="form-group col-sm-9 no-padding no-margin-left no-margin-right">
                    <div class="col-sm-12">
                        <div class="col-sm-8 no-padding-left">
                                <span class="block input-icon input-icon-right">
                                    <input class="form-control required"
                                           type="text"
                                           id="normaltrade_applyorderinfo_amont"
                                           name="normaltrade_applyorderinfo_amont"
                                           required placeholder="交易金额"/>
                                </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group no-margin-bottom">
            <div class="form-group col-sm-12 no-padding no-margin-left no-margin-right">
                <label class="col-sm-3 control-label no-padding-right titlelabel"
                       for="normaltrade_applyorderinfo_tradedescription">交易描述：</label>
                <div class="form-group col-sm-9 no-padding no-margin-left no-margin-right">
                    <div class="col-sm-12">
                        <div class="col-sm-8 no-padding-left">
                                <span class="block input-icon input-icon-right">
                                    <textarea class="form-control required"
                                              type="text"
                                              id="normaltrade_applyorderinfo_tradedescription"
                                              name="normaltrade_applyorderinfo_tradedescription"
                                              required placeholder="交易描述"></textarea>
                                </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr class="hr-14"/>
        <div id="normaltrade_applyorderinfo_entryitemparams" class="infotable-horizontal" style="margin-bottom: 20px">
            <div class="infotable-caption bigger-120">
                记账规则&nbsp;&nbsp;
                <button type="button"
                        class="btn btn-white btn-sm btn-primary"
                        id="normaltrade_applyorderinfo_tradedescription_add_btn">新增
                </button>
            </div>
            <div class="infotable-row">
                <div class="infotable-cell title" style="width:50px">操作</div>
                <div class="infotable-cell title">科目名称</div>
                <div class="infotable-cell title">科目账户</div>
                <div class="infotable-cell title">借贷方向</div>
                <div class="infotable-cell title">发生额</div>
            </div>
        </div>
        <hr class="hr-14"/>
        <div class="form-actions center no-margin">
            <button type="reset"
                    class="btn btn-white btn-warning btn-bold btn-round"
                    id="normaltrade_applyorderinfo_reset_btn">
                <i class="ace-icon fa fa-undo bigger-120 orange2"></i> 重置
            </button>
            &nbsp;&nbsp;
            <button type="button"
                    class="btn btn-white btn-success btn-bold btn-round"
                    id="normaltrade_applyorderinfo_save_btn">
                <i class="ace-icon fa fa-floppy-o bigger-120 green"></i> 提交
            </button>
        </div>
    </form>
</div>
<?php require $_SERVER['DOCUMENT_ROOT'] . $GLOBALS['webroot'] . '/view/common/foot.php'; ?>
<script type="text/javascript" defer async="async"
        charset="<?php echo $GLOBALS['charset']; ?>"
        src="<?php echo $GLOBALS['webroot'] . '/script/page/inner/normaltrade.js?v=1.0.0'; ?>"></script>
</body>
</html>