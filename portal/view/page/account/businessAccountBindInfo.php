<?php
/**
 * Created by PhpStorm.
 * User: zhang
 * Date: 2016/8/24
 * Time: 20:23
 */
require dirname(__FILE__) . '/../../common/pageHead.php';
?>
<html <?php echo $GLOBALS['html_attr'] ?>>
<head>
    <title>B类账户绑定详细信息</title>
    <?php
    require $_SERVER['DOCUMENT_ROOT'] . $GLOBALS['webroot'] . '/view/common/head.php';
    $commonTools = new \service\tools\ToolsClass();
    $id = "";
    $bindinfo = null;
    if (isset($_REQUEST['id'])) {
        $id = $_REQUEST['id'];
        $bindinfo = $commonTools->getDatasBySQL("select * from acc_business_bindinfo where id='" . $id . "'")[0];
    }
    $businessid = $_REQUEST['businessid'];
    $businessinfo = $commonTools->getDatasBySQL("select * from acc_business_account where businessid='" . $businessid . "'")[0];
    ?>
</head>
<body class="<?php echo $GLOBALS['body_class']; ?>">
<input class="hidden" id="businessAccountMng_businessinfo_bindinfo_id" value="<?php echo $id; ?>"/>
<input class="hidden" id="businessAccountMng_businessinfo_bindinfo_businessid" value="<?php echo $businessid; ?>"/>
<div class="widget-main">
    <form class="form-horizontal" id="businessAccountMng_businessinfo_bindinfo_form" style="height: 400px">
        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right"
                   for="businessAccountMng_businessinfo_bindinfo_type">绑定类型：<span class="red">*</span></label>
            <div class="col-sm-9">
                <select class="form-control"
                        id="businessAccountMng_businessinfo_bindinfo_type"
                        name="businessAccountMng_businessinfo_bindinfo_type">
                    <?php
                    $types = $commonTools->getDatasBySQL("select code,name from acc_dic_b_bindtype where status=1 order by code asc");
                    foreach ($types as $type) {
                        echo '<option ' . ($bindinfo != null && $type['code'] == $bindinfo['type'] ? "selected" : "") . ' value="' . $type['code'] . '">' . $type['name'] . '</option>';
                    }
                    ?>
                </select>
            </div>
        </div>
        <div id="businessAccountMng_businessinfo_bindinfo_div_alipay"
             style="display: <?php if ($id == "" || ($bindinfo != null && $bindinfo['type'] == 'ALIPAY')) echo 'block'; else echo 'none'; ?>;">
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right"
                       for="businessAccountMng_businessinfo_bindinfo_partner">商户号：<span class="red">*</span></label>
                <div class="col-sm-9">
                    <input type="text" id="businessAccountMng_businessinfo_bindinfo_partner"
                           name="businessAccountMng_businessinfo_bindinfo_partner"
                           class="form-control"
                           placeholder="商户号"
                           value="<?php if ($bindinfo !== null) echo $bindinfo['partner']; ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right"
                       for="businessAccountMng_businessinfo_bindinfo_partnerkey">商户key：<span
                        class="red">*</span></label>
                <div class="col-sm-9">
                    <input type="text" id="businessAccountMng_businessinfo_bindinfo_partnerkey"
                           name="businessAccountMng_businessinfo_bindinfo_partnerkey"
                           class="form-control"
                           placeholder="商户key"
                           value="<?php if ($bindinfo !== null) echo $bindinfo['partnerkey']; ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right"
                       for="businessAccountMng_businessinfo_bindinfo_seller_email">支付宝email：<span
                        class="red">*</span></label>
                <div class="col-sm-9">
                    <input type="text" id="businessAccountMng_businessinfo_bindinfo_seller_email"
                           name="businessAccountMng_businessinfo_bindinfo_seller_email"
                           class="form-control"
                           placeholder="支付宝email"
                           value="<?php if ($bindinfo !== null) echo $bindinfo['seller_email']; ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right"
                       for="businessAccountMng_businessinfo_bindinfo_seller_id">支付宝id：<span
                        class="red">*</span></label>
                <div class="col-sm-9">
                    <input type="text" id="businessAccountMng_businessinfo_bindinfo_seller_id"
                           name="businessAccountMng_businessinfo_bindinfo_seller_id"
                           class="form-control"
                           placeholder="支付宝id"
                           value="<?php if ($bindinfo !== null) echo $bindinfo['seller_id']; ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right"
                       for="businessAccountMng_businessinfo_bindinfo_private_key">支付宝RSA私钥：<span
                        class="red">*</span></label>
                <div class="col-sm-9">
                        <textarea id="businessAccountMng_businessinfo_bindinfo_private_key"
                                  name="businessAccountMng_businessinfo_bindinfo_private_key"
                                  class="form-control width-100" rows="6"
                                  placeholder="支付宝RSA私钥"><?php if ($bindinfo !== null) echo $bindinfo['private_key']; ?></textarea>
                </div>
            </div>
        </div>
        <div id="businessAccountMng_businessinfo_bindinfo_div_bankcoard"
             style="display: <?php if ($bindinfo != null && $bindinfo['type'] == 'BANKCARD') echo 'block'; else echo 'none'; ?>;">
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right"
                       for="businessAccountMng_businessinfo_bindinfo_bankname">开户行名称：<span
                        class="red">*</span></label>
                <div class="col-sm-9">
                    <input type="text" id="businessAccountMng_businessinfo_bindinfo_bankname"
                           name="businessAccountMng_businessinfo_bindinfo_bankname"
                           class="form-control"
                           placeholder="开户行名称"
                           value="<?php if ($bindinfo !== null) echo $bindinfo['bankname']; ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right"
                       for="businessAccountMng_businessinfo_bindinfo_name">姓名：<span
                        class="red">*</span></label>
                <div class="col-sm-9">
                    <input type="text" id="businessAccountMng_businessinfo_bindinfo_name"
                           name="businessAccountMng_businessinfo_bindinfo_name"
                           class="form-control"
                           placeholder="姓名"
                           value="<?php if ($bindinfo !== null) echo $bindinfo['name']; ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right"
                       for="businessAccountMng_businessinfo_bindinfo_telephone">电话号码：<span
                        class="red">*</span></label>
                <div class="col-sm-9">
                    <input type="text" id="businessAccountMng_businessinfo_bindinfo_telephone"
                           name="businessAccountMng_businessinfo_bindinfo_telephone"
                           class="form-control"
                           placeholder="电话号码"
                           value="<?php if ($bindinfo !== null) echo $bindinfo['telephone']; ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right"
                       for="businessAccountMng_businessinfo_bindinfo_account">卡号：<span
                        class="red">*</span></label>
                <div class="col-sm-9">
                    <input type="text" id="businessAccountMng_businessinfo_bindinfo_account"
                           name="businessAccountMng_businessinfo_bindinfo_account"
                           class="form-control"
                           placeholder="卡号"
                           value="<?php if ($bindinfo !== null) echo $bindinfo['account']; ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right"
                       for="businessAccountMng_businessinfo_bindinfo_certtype">证件类型：<span
                        class="red">*</span></label>
                <div class="col-sm-9">
                    <select class="form-control"
                            id="businessAccountMng_businessinfo_bindinfo_certtype"
                            name="businessAccountMng_businessinfo_bindinfo_certtype">
                        <?php
                        $types = $commonTools->getDatasBySQL("select code,name from acc_dic_certtype where status=1 order by code asc");
                        $default = $businessinfo['certtype'];
                        if ($bindinfo != null) {
                            $default = $bindinfo['certtype'];
                        }
                        foreach ($types as $type) {
                            echo '<option ' . ($type['code'] == $default ? "selected" : "") . ' value="' . $type['code'] . '">' . $type['name'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right"
                       for="businessAccountMng_businessinfo_bindinfo_certno">证件号码：<span
                        class="red">*</span></label>
                <div class="col-sm-9">
                    <input type="text" id="businessAccountMng_businessinfo_bindinfo_certno"
                           name="businessAccountMng_businessinfo_bindinfo_certno"
                           class="form-control"
                           placeholder="证件号码"
                           value="<?php
                           $default = $businessinfo['certno'];
                           if ($bindinfo != null) {
                               $default = $bindinfo['certno'];
                           }
                           echo $default; ?>"/>
                </div>
            </div>
        </div>
        <div id="businessAccountMng_businessinfo_bindinfo_div_weixin"
             style="display: <?php if ($bindinfo != null && $bindinfo['type'] != 'ALIPAY' && $bindinfo['type'] != 'BANKCARD') echo 'block'; else echo 'none'; ?>;">
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right"
                       for="businessAccountMng_businessinfo_bindinfo_weixin_partner">商户号：<span
                        class="red">*</span></label>
                <div class="col-sm-9">
                    <input type="text" id="businessAccountMng_businessinfo_bindinfo_weixin_partner"
                           name="businessAccountMng_businessinfo_bindinfo_weixin_partner"
                           class="form-control"
                           placeholder="商户号"
                           value="<?php if ($bindinfo !== null) echo $bindinfo['partner']; ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right"
                       for="businessAccountMng_businessinfo_bindinfo_weixin_partnerkey">商户key：<span
                        class="red">*</span></label>
                <div class="col-sm-9">
                    <input type="text" id="businessAccountMng_businessinfo_bindinfo_weixin_partnerkey"
                           name="businessAccountMng_businessinfo_bindinfo_weixin_partnerkey"
                           class="form-control"
                           placeholder="商户key"
                           value="<?php if ($bindinfo !== null) echo $bindinfo['partnerkey']; ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right"
                       for="businessAccountMng_businessinfo_bindinfo_appid">应用id：<span
                        class="red">*</span></label>
                <div class="col-sm-9">
                    <input type="text" id="businessAccountMng_businessinfo_bindinfo_appid"
                           name="businessAccountMng_businessinfo_bindinfo_appid"
                           class="form-control"
                           placeholder="应用id"
                           value="<?php if ($bindinfo !== null) echo $bindinfo['appid']; ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right"
                       for="businessAccountMng_businessinfo_bindinfo_appsecret">应用密钥：<span
                        class="red">*</span></label>
                <div class="col-sm-9">
                    <input type="text" id="businessAccountMng_businessinfo_bindinfo_appsecret"
                           name="businessAccountMng_businessinfo_bindinfo_appsecret"
                           class="form-control"
                           placeholder="应用密钥"
                           value="<?php if ($bindinfo !== null) echo $bindinfo['appsecret']; ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right"
                       for="businessAccountMng_businessinfo_bindinfo_appsingn">应用签名：<span
                        class="red">*</span></label>
                <div class="col-sm-9">
                    <input type="text" id="businessAccountMng_businessinfo_bindinfo_appsingn"
                           name="businessAccountMng_businessinfo_bindinfo_appsingn"
                           class="form-control"
                           placeholder="应用签名"
                           value="<?php if ($bindinfo !== null) echo $bindinfo['appsingn']; ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right"
                       for="businessAccountMng_businessinfo_bindinfo_bundleid">ios组件id：<span
                        class="red">*</span></label>
                <div class="col-sm-9">
                    <input type="text" id="businessAccountMng_businessinfo_bindinfo_bundleid"
                           name="businessAccountMng_businessinfo_bindinfo_bundleid"
                           class="form-control"
                           placeholder="ios组件id"
                           value="<?php if ($bindinfo !== null) echo $bindinfo['bundleid']; ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right"
                       for="businessAccountMng_businessinfo_bindinfo_package">Android包名：<span
                        class="red">*</span></label>
                <div class="col-sm-9">
                    <input type="text" id="businessAccountMng_businessinfo_bindinfo_package"
                           name="businessAccountMng_businessinfo_bindinfo_package"
                           class="form-control"
                           placeholder="Android包名"
                           value="<?php if ($bindinfo !== null) echo $bindinfo['package']; ?>"/>
                </div>
            </div>
        </div>
        <div class="form-actions center no-margin">
            <button type="reset"
                    class="btn btn-white btn-warning btn-bold btn-round">
                <i class="ace-icon fa fa-undo bigger-120 orange2"></i> 撤销
            </button>
            &nbsp; &nbsp;
            <button type="button"
                    class="btn btn-white btn-success btn-bold btn-round"
                    id="businessAccountMng_businessinfo_bindinfo_save_btn">
                <i class="ace-icon fa fa-floppy-o bigger-120 green"></i> 保存
            </button>
            &nbsp; &nbsp;
            <button type="button"
                    class="btn btn-white btn-danger btn-bold btn-round"
                    id="businessAccountMng_businessinfo_bindinfo_cancle_btn">
                <i class="ace-icon fa fa-times bigger-120 red2"></i> 取消
            </button>
        </div>
    </form>
</div>
<?php require $_SERVER['DOCUMENT_ROOT'] . $GLOBALS['webroot'] . '/view/common/foot.php'; ?>
<script type="text/javascript" defer async="async"
        charset="<?php echo $GLOBALS['charset']; ?>"
        src="<?php echo $GLOBALS['webroot'] . '/script/page/account/businessAccountBindInfo.js?v=1.0.0'; ?>"></script>
</body>
</html>