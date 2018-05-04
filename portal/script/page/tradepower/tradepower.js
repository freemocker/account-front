/**
 * Created by zhangbin on 2016/12/27.
 */
(function ($) {

    var formid = "tradepower_form";

    /**
     * 键盘事件
     *
     * @param event
     */
    function keydownfun(event) {
        var e = event || window.event || arguments.callee.caller.arguments[0];
        if (e && e.keyCode == 13) {
            e.preventDefault();
            e.returnValue = false;
            doSave();
            return false;
        }
    }

    function doSave() {
        if ($.trim($("#tradepower_authloginno").val()) == "") {
            AUI.dialog.alert("请输入登录账号", undefined, 3);
            return;
        }
        if ($.trim($("#tradepower_authpassword").val()) == "") {
            AUI.dialog.alert("请输入登录密码", undefined, 3);
            return;
        }
        var datas = {
            authloginno: $("#tradepower_authloginno").val(),
            authpassword: $("#tradepower_authpassword").val()
        };
        $("#tradepower_authloginno").val("");
        $("#tradepower_authpassword").val("");
        $("#tradepower_authpassword").attr("type", "text");
        AUI.dialog.closeDialog($("#" + formid), datas);
    }

    function initEvent() {
        $("#tradepower_authpassword,#tradepower_authloginno").bind("keydown", keydownfun);
        $("#tradepower_save_btn").click(function () {
            doSave();
        });
        $("#tradepower_reset_btn").click(function () {
            $("#" + formid)[0].reset();
        });
        $("#tradepower_cancle_btn").click(function () {
            AUI.dialog.closeDialog($("#" + formid));
        });
    }

    $(function () {
        initEvent();
        $("#tradepower_authloginno").focus();
    });
})($);
