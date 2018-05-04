/**
 * Created by zhangbin on 2017/5/12.
 */
(function ($) {

    var orderno;

    function initPage() {
        orderno = $("#balancesettlementinfo_review_orderno").val();
        $("#balancesettlementinfo_review_content").autosize({append: ""});
    }

    function initEvent() {
        $("input[name='balancesettlementinfo_review_result']").click(function () {
            var obj = $("input[name='balancesettlementinfo_review_result']:checked")[0];
            if ($(obj).val() == "1") {
                $("#balancesettlementinfo_review_content").parent().parent().addClass("hidden");
            } else {
                $("#balancesettlementinfo_review_content").parent().parent().removeClass("hidden");
            }
        });
        $("#balancesettlementinfo_review_reset_btn").click(function () {
            $("#balancesettlementinfo_review_content").parent().parent().removeClass("hidden").addClass("hidden");
        });
        $("#balancesettlementinfo_review_cancle_btn").click(function () {
            AUI.dialog.closeDialog($(this));
        });
        $("#balancesettlementinfo_review_save_btn").click(function () {
            var action = "";
            var body = {
                data: {
                    orderno: orderno
                }
            };
            var obj = $("input[name='balancesettlementinfo_review_result']:checked")[0];
            var result = $(obj).val();
            if (result == "1") {
                action = "back_business_BalanceSettlement";
            } else {
                action = "back_business_cancleBalanceSettlement";
                var content = $("#balancesettlementinfo_review_content").val();
                if ($.trim(content) == "") {
                    AUI.dialog.alert("请填写审核意见", null, 3);
                    return;
                }
                body.data.opinion = content;
            }
            portal_tools_obj.doAjaxToServer("back_1001", {
                service: {
                    action: action
                }
            }, body, function (data) {
                if (data.errmsg) {
                    AUI.dialog.alert(data.errmsg, null, 3);
                } else {
                    AUI.dialog.alert("操作成功", function () {
                        AUI.dialog.closeDialog($("#balancesettlementinfo_review_orderno"));
                    }, 1);
                }
            });
        });
    }

    $(function () {
        initPage();
        initEvent();
    })
})($);