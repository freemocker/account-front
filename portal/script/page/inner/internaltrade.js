/**
 * Created by zhangbin on 2017/5/12.
 */
(function ($) {

    function initEvent() {
        AUI.element.initValidate("internaltrade_applyorderinfo_form", {
            internaltrade_applyorderinfo_ordertype: "请选择订单类型",
            internaltrade_applyorderinfo_businessid: "请输入B户客户号",
            internaltrade_applyorderinfo_amont: "请输入交易额",
            internaltrade_applyorderinfo_tradetype: "请选择交易类型",
            internaltrade_applyorderinfo_tradedescription: "请输入交易描述"
        });
        $("#internaltrade_applyorderinfo_reset_btn").click(function () {
            $("#internaltrade_applyorderinfo_form")[0].reset();
            AUI.element.resetValidate("internaltrade_applyorderinfo_form");
        });
        $("#internaltrade_applyorderinfo_save_btn").click(function () {
            if (AUI.element.doValidate("internaltrade_applyorderinfo_form")) {
                doSave();
            }
        });
    }

    function doSave() {
        if ($.trim($("#internaltrade_applyorderinfo_amont").val()) == "") {
            AUI.dialog.alert("交易额不能为空！", function () {
                $("#internaltrade_applyorderinfo_amont").val("").focus();
            }, 3);
            return;
        } else if (isNaN(Number($.trim($("#internaltrade_applyorderinfo_amont").val())))) {
            AUI.dialog.alert("交易额不合法！", function () {
                $("#internaltrade_applyorderinfo_amont").val("").focus();
            }, 3);
            return;
        }
        if ($.trim($("#internaltrade_applyorderinfo_ratio").val()) != "") {
            if (isNaN(Number($.trim($("#internaltrade_applyorderinfo_ratio").val())))) {
                AUI.dialog.alert("兑换比例不合法！", function () {
                    $("#internaltrade_applyorderinfo_ratio").val("").focus();
                }, 3);
                return;
            }
        }
        if ($("#internaltrade_applyorderinfo_tradetype").val() == "1") {
            if ($.trim($("#internaltrade_applyorderinfo_origorderno").val()) == "") {
                AUI.dialog.alert("请输入原订单号！", function () {
                    $("#internaltrade_applyorderinfo_origordertype").val("").focus();
                }, 3);
                return;
            }
        }
        if ($.trim($("#internaltrade_applyorderinfo_origorderno").val()) != "") {
            if ($.trim($("#internaltrade_applyorderinfo_origordertype").val()) == "") {
                AUI.dialog.alert("请选择原订单类型！", function () {
                    $("#internaltrade_applyorderinfo_origordertype").val("").focus();
                }, 3);
                return;
            }
        }
        var body = {
            data: {
                ordertype: function () {
                    return Number($("#internaltrade_applyorderinfo_ordertype").val());
                },
                businessid: function () {
                    return $("#internaltrade_applyorderinfo_businessid").val();
                },
                amont: function () {
                    return Number($("#internaltrade_applyorderinfo_amont").val());
                },
                tradetype: function () {
                    return Number($("#internaltrade_applyorderinfo_tradetype").val());
                },
                tradedescription: function () {
                    return $("#internaltrade_applyorderinfo_tradedescription").val();
                },
                recebusinessid: function () {
                    return $("#internaltrade_applyorderinfo_recebusinessid").val();
                },
                custid: function () {
                    return $("#internaltrade_applyorderinfo_custid").val();
                },
                rececustid: function () {
                    return $("#internaltrade_applyorderinfo_rececustid").val();
                },
                ratio: function () {
                    if ($.trim($("#internaltrade_applyorderinfo_ratio").val()) != "") {
                        return Number($("#internaltrade_applyorderinfo_ratio").val());
                    } else {
                        return 1;
                    }
                },
                origorderno: function () {
                    return $("#internaltrade_applyorderinfo_origorderno").val();
                },
                origordertype: function () {
                    return $("#internaltrade_applyorderinfo_origordertype").val();
                }
            }
        };
        portal_tools_obj.doAjaxToServer("back_1001", {
            service: {
                action: "back_applyInternalTrade"
            }
        }, body, function (data) {
            if (data.errmsg) {
                AUI.dialog.alert(data.errmsg, null, 3);
            } else {
                AUI.dialog.alert("操作成功", function () {
                    $("#internaltrade_applyorderinfo_reset_btn").click();
                }, 1);
            }
        });
    }

    $(function () {
        initEvent();
    });
})($);