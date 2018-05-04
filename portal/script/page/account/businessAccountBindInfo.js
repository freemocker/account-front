/**
 * Created by zhang on 2016/8/24.
 */
(function ($) {

    var formid = "businessAccountMng_businessinfo_bindinfo_form";

    var id;

    var businessid;

    function initEvent() {
        $("#businessAccountMng_businessinfo_bindinfo_type").change(function () {
            $("#" + formid).children("div[id^='businessAccountMng_businessinfo_bindinfo_div_']").hide();
            var type = $(this).val();
            switch (type) {
                case "ALIPAY":
                    $("#businessAccountMng_businessinfo_bindinfo_div_alipay").show();
                    break;
                case "BANKCARD":
                    $("#businessAccountMng_businessinfo_bindinfo_div_bankcoard").show();
                    break;
                default:
                    $("#businessAccountMng_businessinfo_bindinfo_div_weixin").show();
            }
        });
        $("#businessAccountMng_businessinfo_bindinfo_cancle_btn").click(function () {
            AUI.dialog.closeDialog($("#businessAccountMng_businessinfo_bindinfo_type"));
        });
        $("#businessAccountMng_businessinfo_bindinfo_save_btn").click(function () {
            doSave();
        });
    }

    function doValidate() {
        var type = $("#businessAccountMng_businessinfo_bindinfo_type").val();
        var bankname = $.trim($("#businessAccountMng_businessinfo_bindinfo_bankname").val());
        var name = $.trim($("#businessAccountMng_businessinfo_bindinfo_name").val());
        var telephone = $.trim($("#businessAccountMng_businessinfo_bindinfo_telephone").val());
        var account = $.trim($("#businessAccountMng_businessinfo_bindinfo_account").val());
        var certtype = $.trim($("#businessAccountMng_businessinfo_bindinfo_certtype").val());
        var certno = $.trim($("#businessAccountMng_businessinfo_bindinfo_certno").val());
        var partner = $.trim($("#businessAccountMng_businessinfo_bindinfo_partner").val());
        var partnerkey = $.trim($("#businessAccountMng_businessinfo_bindinfo_partnerkey").val());
        var appid = $.trim($("#businessAccountMng_businessinfo_bindinfo_appid").val());
        var appsecret = $.trim($("#businessAccountMng_businessinfo_bindinfo_appsecret").val());
        var appsingn = $.trim($("#businessAccountMng_businessinfo_bindinfo_appsingn").val());
        var bundleid = $.trim($("#businessAccountMng_businessinfo_bindinfo_bundleid").val());
        var packages = $.trim($("#businessAccountMng_businessinfo_bindinfo_package").val());
        var seller_email = $.trim($("#businessAccountMng_businessinfo_bindinfo_seller_email").val());
        var seller_id = $.trim($("#businessAccountMng_businessinfo_bindinfo_seller_id").val());
        var private_key = $.trim($("#businessAccountMng_businessinfo_bindinfo_private_key").val());
        var params = {};
        params.type = type;
        params.bankname = bankname;
        params.name = name;
        params.telephone = telephone;
        params.account = account;
        params.certtype = certtype;
        params.certno = certno;
        params.partner = partner;
        params.partnerkey = partnerkey;
        params.appid = appid;
        params.appsecret = appsecret;
        params.appsingn = appsingn;
        params.bundleid = bundleid;
        params.package = packages;
        params.seller_email = seller_email;
        params.seller_id = seller_id;
        params.private_key = private_key;
        switch (type) {
            case "ALIPAY":
                var partner = $.trim($("#businessAccountMng_businessinfo_bindinfo_partner").val());
                var partnerkey = $.trim($("#businessAccountMng_businessinfo_bindinfo_partnerkey").val());
                if (partner == "") {
                    AUI.dialog.alert("请填写商户号", null, 3);
                    return false;
                }
                if (partnerkey == "") {
                    AUI.dialog.alert("请填写商户key", null, 3);
                    return false;
                }
                if (seller_email == "") {
                    AUI.dialog.alert("请填写支付宝email", null, 3);
                    return false;
                }
                if (seller_id == "") {
                    AUI.dialog.alert("请填写支付宝id", null, 3);
                    return false;
                }
                if (private_key == "") {
                    AUI.dialog.alert("请填写支付宝RSA私钥", null, 3);
                    return false;
                }
                params.partner = partner;
                params.partnerkey = partnerkey;
                break;
            case "BANKCARD":
                if (bankname == "") {
                    AUI.dialog.alert("请填写开户行名称", null, 3);
                    return false;
                }
                if (name == "") {
                    AUI.dialog.alert("请填写姓名", null, 3);
                    return false;
                }
                if (telephone == "") {
                    AUI.dialog.alert("请填写电话号码", null, 3);
                    return false;
                }
                if (account == "") {
                    AUI.dialog.alert("请填写卡号", null, 3);
                    return false;
                }
                if (certno == "") {
                    AUI.dialog.alert("请填写证件号码", null, 3);
                    return false;
                }
                break;
            default:
                var partner = $.trim($("#businessAccountMng_businessinfo_bindinfo_weixin_partner").val());
                var partnerkey = $.trim($("#businessAccountMng_businessinfo_bindinfo_weixin_partnerkey").val());
                if (partner == "") {
                    AUI.dialog.alert("请填写商户号", null, 3);
                    return false;
                }
                if (partnerkey == "") {
                    AUI.dialog.alert("请填写商户key", null, 3);
                    return false;
                }
                if (appid == "") {
                    AUI.dialog.alert("请填写应用id", null, 3);
                    return false;
                }
                if (appsecret == "") {
                    AUI.dialog.alert("请填写应用密钥", null, 3);
                    return false;
                }
                if (appsingn == "") {
                    AUI.dialog.alert("请填写应用签名", null, 3);
                    return false;
                }
                if (bundleid == "") {
                    AUI.dialog.alert("请填写ios组件id", null, 3);
                    return false;
                }
                if (packages == "") {
                    AUI.dialog.alert("请填写Android包名", null, 3);
                    return false;
                }
                params.partner = partner;
                params.partnerkey = partnerkey;
        }
        return params;
    }

    function doSave() {
        var param = doValidate();
        if (param != false) {
            portal_tools_obj.showAuthDialog(function (authdata) {
                param = $.extend(param, {
                    oper: "saveBindInfo",
                    authloginno: authdata.authloginno,
                    authpassword: authdata.authpassword,
                    id: id,
                    businessid: businessid
                });
                portal_tools_obj.doAjax(G_webrootPath + "/service/page/account/serviceBusinessAccount", param, function (data) {
                    if (data.errmsg) {
                        AUI.dialog.alert(data.errmsg, null, 3);
                    } else {
                        AUI.dialog.alert(data.result, function () {
                            AUI.dialog.closeDialog($("#businessAccountMng_businessinfo_bindinfo_type"), data);
                        }, 1);
                    }
                }, "POST");
            });
            // param = $.extend(param, {
            //     oper: "saveBindInfo",
            //     id: id,
            //     businessid: businessid
            // });
            // portal_tools_obj.doAjax(G_webrootPath + "/service/page/account/serviceBusinessAccount", param, function (data) {
            //     if (data.errmsg) {
            //         AUI.dialog.alert(data.errmsg, null, 3);
            //     } else {
            //         AUI.dialog.alert(data.result, function () {
            //             AUI.dialog.closeDialog($("#businessAccountMng_businessinfo_bindinfo_type"), data);
            //         }, 1);
            //     }
            // }, "POST");
        }
    }

    $(function () {
        id = $("#businessAccountMng_businessinfo_bindinfo_id").val();
        businessid = $("#businessAccountMng_businessinfo_bindinfo_businessid").val();
        initEvent();
    });
})($);