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
    <title>特殊交易申请</title>
    <?php
    require $_SERVER['DOCUMENT_ROOT'] . $GLOBALS['webroot'] . '/view/common/head.php';
    $commonTools = new \service\tools\ToolsClass();
    $ordertype = $commonTools->getDatasBySQL("select c.code,c.name from acc_dic_ordertype c where c.field6='1' and c.status=1 order by c.code asc");
    $origordertype = $commonTools->getDatasBySQL("select c.code,c.name from acc_dic_ordertype c where c.status=1 order by c.code asc");
    ?>
</head>
<body class="<?php echo $GLOBALS['body_class']; ?>">
<div class="page-content no-padding-top">
    <div class="page-header">
        <h1>特殊交易申请</h1>
    </div>
    <form class="form-horizontal" id="internaltrade_applyorderinfo_form">
        <div class="form-group no-margin-bottom">
            <div class="form-group col-sm-12 no-padding no-margin-left no-margin-right">
                <label class="col-sm-3 control-label no-padding-right titlelabel"
                       for="internaltrade_applyorderinfo_ordertype">订单类型：</label>
                <div class="form-group col-sm-9 no-padding no-margin-left no-margin-right">
                    <div class="col-sm-12">
                        <div class="col-sm-8 no-padding-left">
                                <span class="block input-icon input-icon-right">
                                    <select class="form-control required" data-placeholder=" "
                                            id="internaltrade_applyorderinfo_ordertype"
                                            name="internaltrade_applyorderinfo_ordertype"
                                            required>
                                        <option value=""></option>
                                        <?php
                                        foreach ($ordertype as $o) {
                                            echo '<option value="' . $o['code'] . '">' . $o['name'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group no-margin-bottom">
            <div class="form-group col-sm-12 no-padding no-margin-left no-margin-right">
                <label class="col-sm-3 control-label no-padding-right titlelabel"
                       for="internaltrade_applyorderinfo_businessid">B户客户号：</label>
                <div class="form-group col-sm-9 no-padding no-margin-left no-margin-right">
                    <div class="col-sm-12">
                        <div class="col-sm-8 no-padding-left">
                                <span class="block input-icon input-icon-right">
                                    <input class="form-control required"
                                           type="text"
                                           id="internaltrade_applyorderinfo_businessid"
                                           name="internaltrade_applyorderinfo_businessid"
                                           maxlength="27"
                                           required placeholder="B户客户号"/>
                                </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group no-margin-bottom">
            <div class="form-group col-sm-12 no-padding no-margin-left no-margin-right">
                <label class="col-sm-3 control-label no-padding-right titlelabel"
                       for="internaltrade_applyorderinfo_amont">交易额：</label>
                <div class="form-group col-sm-9 no-padding no-margin-left no-margin-right">
                    <div class="col-sm-12">
                        <div class="col-sm-8 no-padding-left">
                                <span class="block input-icon input-icon-right">
                                    <input class="form-control required"
                                           type="text"
                                           id="internaltrade_applyorderinfo_amont"
                                           name="internaltrade_applyorderinfo_amont"
                                           required placeholder="交易额"/>
                                </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group no-margin-bottom">
            <div class="form-group col-sm-12 no-padding no-margin-left no-margin-right">
                <label class="col-sm-3 control-label no-padding-right titlelabel"
                       for="internaltrade_applyorderinfo_tradetype">交易类型：</label>
                <div class="form-group col-sm-9 no-padding no-margin-left no-margin-right">
                    <div class="col-sm-12">
                        <div class="col-sm-8 no-padding-left">
                                <span class="block input-icon input-icon-right">
                                    <select class="form-control required" data-placeholder=" "
                                            id="internaltrade_applyorderinfo_tradetype"
                                            name="internaltrade_applyorderinfo_tradetype"
                                            required>
                                        <option value="0">普通交易</option>
                                        <option value="1">冲正交易</option>
                                    </select>
                                </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group no-margin-bottom">
            <div class="form-group col-sm-12 no-padding no-margin-left no-margin-right">
                <label class="col-sm-3 control-label no-padding-right titlelabel"
                       for="internaltrade_applyorderinfo_tradedescription">交易描述：</label>
                <div class="form-group col-sm-9 no-padding no-margin-left no-margin-right">
                    <div class="col-sm-12">
                        <div class="col-sm-8 no-padding-left">
                                <span class="block input-icon input-icon-right">
                                    <textarea class="form-control required"
                                              type="text"
                                              id="internaltrade_applyorderinfo_tradedescription"
                                              name="internaltrade_applyorderinfo_tradedescription"
                                              required placeholder="交易描述"></textarea>
                                </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr class="hr-14"/>
        <div class="form-group no-margin-bottom">
            <div class="form-group col-sm-12 no-padding no-margin-left no-margin-right">
                <label class="col-sm-3 control-label no-padding-right titlelabel"
                       for="internaltrade_applyorderinfo_recebusinessid">收款方B户客户号：</label>
                <div class="form-group col-sm-9 no-padding no-margin-left no-margin-right">
                    <div class="col-sm-12">
                        <div class="col-sm-8 no-padding-left">
                                <span class="block input-icon input-icon-right">
                                    <input class="form-control"
                                           type="text"
                                           id="internaltrade_applyorderinfo_recebusinessid"
                                           name="internaltrade_applyorderinfo_recebusinessid"
                                           maxlength="27"
                                           placeholder="收款方B户客户号"/>
                                </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group no-margin-bottom">
            <div class="form-group col-sm-12 no-padding no-margin-left no-margin-right">
                <label class="col-sm-3 control-label no-padding-right titlelabel"
                       for="internaltrade_applyorderinfo_custid">C户客户号：</label>
                <div class="form-group col-sm-9 no-padding no-margin-left no-margin-right">
                    <div class="col-sm-12">
                        <div class="col-sm-8 no-padding-left">
                                <span class="block input-icon input-icon-right">
                                    <input class="form-control"
                                           type="text"
                                           id="internaltrade_applyorderinfo_custid"
                                           name="internaltrade_applyorderinfo_custid"
                                           maxlength="27"
                                           placeholder="C户客户号"/>
                                </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group no-margin-bottom">
            <div class="form-group col-sm-12 no-padding no-margin-left no-margin-right">
                <label class="col-sm-3 control-label no-padding-right titlelabel"
                       for="internaltrade_applyorderinfo_rececustid">收款方C户客户号：</label>
                <div class="form-group col-sm-9 no-padding no-margin-left no-margin-right">
                    <div class="col-sm-12">
                        <div class="col-sm-8 no-padding-left">
                                <span class="block input-icon input-icon-right">
                                    <input class="form-control"
                                           type="text"
                                           id="internaltrade_applyorderinfo_rececustid"
                                           name="internaltrade_applyorderinfo_rececustid"
                                           maxlength="27"
                                           placeholder="收款方C户客户号"/>
                                </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group no-margin-bottom">
            <div class="form-group col-sm-12 no-padding no-margin-left no-margin-right">
                <label class="col-sm-3 control-label no-padding-right titlelabel"
                       for="internaltrade_applyorderinfo_ratio">兑换比例：</label>
                <div class="form-group col-sm-9 no-padding no-margin-left no-margin-right">
                    <div class="col-sm-12">
                        <div class="col-sm-8 no-padding-left">
                                <span class="block input-icon input-icon-right">
                                    <input class="form-control"
                                           type="text"
                                           id="internaltrade_applyorderinfo_ratio"
                                           name="internaltrade_applyorderinfo_ratio"
                                           placeholder="兑换比例"/>
                                </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group no-margin-bottom">
            <div class="form-group col-sm-12 no-padding no-margin-left no-margin-right">
                <label class="col-sm-3 control-label no-padding-right titlelabel"
                       for="internaltrade_applyorderinfo_origorderno">原订单号：</label>
                <div class="form-group col-sm-9 no-padding no-margin-left no-margin-right">
                    <div class="col-sm-12">
                        <div class="col-sm-8 no-padding-left">
                                <span class="block input-icon input-icon-right">
                                    <input class="form-control"
                                           type="text"
                                           id="internaltrade_applyorderinfo_origorderno"
                                           name="internaltrade_applyorderinfo_origorderno"
                                           maxlength="25"
                                           placeholder="原订单号"/>
                                </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group no-margin-bottom">
            <div class="form-group col-sm-12 no-padding no-margin-left no-margin-right">
                <label class="col-sm-3 control-label no-padding-right titlelabel"
                       for="internaltrade_applyorderinfo_origordertype">原订单类型：</label>
                <div class="form-group col-sm-9 no-padding no-margin-left no-margin-right">
                    <div class="col-sm-12">
                        <div class="col-sm-8 no-padding-left">
                                <span class="block input-icon input-icon-right">
                                    <select class="form-control" data-placeholder=" "
                                            id="internaltrade_applyorderinfo_origordertype"
                                            name="internaltrade_applyorderinfo_origordertype">
                                        <option value=""></option>
                                        <?php
                                        foreach ($origordertype as $o) {
                                            echo '<option value="' . $o['code'] . '">' . $o['name'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions center no-margin">
            <button type="reset"
                    class="btn btn-white btn-warning btn-bold btn-round"
                    id="internaltrade_applyorderinfo_reset_btn">
                <i class="ace-icon fa fa-undo bigger-120 orange2"></i> 重置
            </button>
            &nbsp;&nbsp;
            <button type="button"
                    class="btn btn-white btn-success btn-bold btn-round"
                    id="internaltrade_applyorderinfo_save_btn">
                <i class="ace-icon fa fa-floppy-o bigger-120 green"></i> 提交
            </button>
        </div>
    </form>
</div>
<?php require $_SERVER['DOCUMENT_ROOT'] . $GLOBALS['webroot'] . '/view/common/foot.php'; ?>
<script type="text/javascript" defer async="async"
        charset="<?php echo $GLOBALS['charset']; ?>"
        src="<?php echo $GLOBALS['webroot'] . '/script/page/inner/internaltrade.js?v=1.0.0'; ?>"></script>
</body>
</html>