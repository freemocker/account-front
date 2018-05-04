<?php
/**
 * Created by PhpStorm.
 * User: zhangbin
 * Date: 2016/12/27
 * Time: 12:06
 */
require dirname(__FILE__) . '/../../common/pageHead.php';
?>
<html <?php echo $GLOBALS['html_attr'] ?>>
<head>
    <title>授权</title>
</head>
<body class="<?php echo $GLOBALS['body_class']; ?>">
<form class="form-horizontal" id="tradepower_form" style="margin-top: 15px;">
    <div class="form-group no-margin-right no-margin-left">
        <label class="col-sm-2 control-label no-padding-right"
               for="tradepower_authloginno">账号：</label>
        <div class="col-sm-10">
            <input type="text" id="tradepower_authloginno" class="form-control" autocomplete="off"
                   placeholder="账号" maxlength="40" value="">
        </div>
    </div>
    <div class="form-group no-margin-right no-margin-left">
        <label class="col-sm-2 control-label no-padding-right"
               for="tradepower_authpassword">密码：</label>
        <div class="col-sm-10">
            <input type="text" id="tradepower_authpassword" class="form-control" autocomplete="off"
                   onfocus="this.type='password'"
                   placeholder="密码" maxlength="40" value=""/>
        </div>
    </div>
</form>
<div class="form-actions center no-margin">
    <button type="reset"
            class="btn btn-white btn-warning btn-bold btn-round"
            id="tradepower_reset_btn">
        <i class="ace-icon fa fa-undo bigger-120 orange2"></i> 撤销
    </button>
    &nbsp; &nbsp;
    <button type="button"
            class="btn btn-white btn-success btn-bold btn-round"
            id="tradepower_save_btn">
        <i class="ace-icon fa fa-floppy-o bigger-120 green"></i> 确定
    </button>
    &nbsp; &nbsp;
    <button type="button"
            class="btn btn-white btn-danger btn-bold btn-round"
            id="tradepower_cancle_btn">
        <i class="ace-icon fa fa-times bigger-120 red2"></i> 取消
    </button>
</div>
<?php require $_SERVER['DOCUMENT_ROOT'] . $GLOBALS['webroot'] . '/view/common/foot.php'; ?>
<script type="text/javascript" defer async="async"
        charset="<?php echo $GLOBALS['charset']; ?>"
        src="<?php echo $GLOBALS['webroot'] . '/script/page/tradepower/tradepower.js?v=1.0.0'; ?>"></script>
</body>
</html>