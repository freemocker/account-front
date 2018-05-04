/**
 * Created by zhangbin on 2017/5/12.
 */
(function ($) {

    var itemlist = [];

    var subitemlist = [];

    function initEvent() {
        AUI.element.initValidate("normaltrade_applyorderinfo_form", {
            normaltrade_applyorderinfo_amont: "请输入交易额",
            normaltrade_applyorderinfo_tradedescription: "请输入交易描述"
        });
        $("#normaltrade_applyorderinfo_reset_btn").click(function () {
            $("#normaltrade_applyorderinfo_form")[0].reset();
            AUI.element.resetValidate("normaltrade_applyorderinfo_form");
            $("#normaltrade_applyorderinfo_entryitemparams").children("div:gt(1)").remove();
        });
        $("#normaltrade_applyorderinfo_save_btn").click(function () {
            if (AUI.element.doValidate("normaltrade_applyorderinfo_form")) {
                doSave();
            }
        });
        $("#normaltrade_applyorderinfo_tradedescription_add_btn").click(function () {
            var itemselect = buildItemSelect();
            var rowdiv = new StringBuffer();
            rowdiv.append('<div class="infotable-row">');
            rowdiv.append('<div class="infotable-cell info align-center" style="width:50px">');
            rowdiv.append('<span><i class="ace-icon fa fa-trash-o bigger-200 red" onmouseover="jQuery(this).addClass(\'bigger-220\');" onmouseout="jQuery(this).removeClass(\'bigger-220\');" style="cursor: pointer"></i></span>');
            rowdiv.append('</div>');
            rowdiv.append('<div class="infotable-cell info">');
            rowdiv.append(itemselect);
            rowdiv.append('</div>');
            rowdiv.append('<div class="infotable-cell info">');
            rowdiv.append('<select class="form-control"></select>');
            rowdiv.append('</div>');
            rowdiv.append('<div class="infotable-cell info align-center">');
            rowdiv.append('<select class="form-control"><option value="1">借</option><option value="2">贷</option></select>');
            rowdiv.append('</div>');
            rowdiv.append('<div class="infotable-cell info align-center">');
            rowdiv.append('<input class="form-control" type="text" placeholder="交易额"/>');
            rowdiv.append('</div>');
            rowdiv.append('</div>');
            $("#normaltrade_applyorderinfo_entryitemparams").append(rowdiv.toString());
            $("#normaltrade_applyorderinfo_entryitemparams").children("div:last").children("div:eq(1)").find("select").change(function () {
                $(this).closest(".infotable-row").children("div:eq(2)").find("select")[0].innerHTML = buildSubItemSelect($(this).val());
            });
            $("#normaltrade_applyorderinfo_entryitemparams").children("div:last").children("div:eq(0)").find("i").click(function () {
                $(this).closest(".infotable-row").remove();
            });
        });
    }

    /**
     * 生成科目下拉框
     */
    function buildItemSelect() {
        var select = new StringBuffer();
        select.append('<select class="form-control"><option value=""></option>');
        for (i in itemlist) {
            select.append('<option value="');
            select.append(itemlist[i].code);
            select.append('">');
            select.append(itemlist[i].name);
            select.append('</option>');
        }
        select.append('</select>');
        return select.toString();
    }

    /**
     * 动态加载科目下立子账户
     * @param itemcode 科目编码
     */
    function buildSubItemSelect(itemcode) {
        var options = new StringBuffer();
        options.append('<option value=""></option>');
        for (i in subitemlist) {
            if (itemcode == subitemlist[i].parentcode) {
                options.append('<option value="');
                options.append(subitemlist[i].code);
                options.append('">');
                options.append(subitemlist[i].name);
                options.append('</option>');
            }
        }
        return options;
    }

    function doSave() {
        if (!doValidate()) {
            return;
        }
        var entryitemparams = [];
        $("#normaltrade_applyorderinfo_entryitemparams").children("div:gt(1)").each(function (i, n) {
            var entryitem = {};
            entryitem.amont = Number($.trim($(n).children("div:eq(4)").find("input").val()));
            entryitem.itemcode = $(n).children("div:eq(1)").find("select").val();
            entryitem.subitemcode = $(n).children("div:eq(2)").find("select").val();
            entryitem.balancedirect = Number($(n).children("div:eq(3)").find("select").val());
            entryitemparams.push(entryitem);
        });
        var body = {
            data: {
                amont: function () {
                    return Number($("#normaltrade_applyorderinfo_amont").val());
                },
                tradedescription: function () {
                    return $("#normaltrade_applyorderinfo_tradedescription").val();
                },
                entryitemparams: entryitemparams
            }
        };
        portal_tools_obj.doAjaxToServer("back_1001", {
            service: {
                action: "back_business_normaltrade"
            }
        }, body, function (data) {
            if (data.errmsg) {
                AUI.dialog.alert(data.errmsg, null, 3);
            } else {
                AUI.dialog.alert("操作成功", function () {
                    $("#normaltrade_applyorderinfo_reset_btn").click();
                }, 1);
            }
        });
    }

    function doValidate() {
        if ($.trim($("#normaltrade_applyorderinfo_amont").val()) == "") {
            AUI.dialog.alert("交易金额不能为空！", function () {
                $("#normaltrade_applyorderinfo_amont").focus();
            }, 3);
            return false;
        } else if (isNaN(Number($.trim($("#normaltrade_applyorderinfo_amont").val())))) {
            AUI.dialog.alert("交易金额不合法！", function () {
                $("#normaltrade_applyorderinfo_amont").focus();
            }, 3);
            return false;
        }
        if ($("#normaltrade_applyorderinfo_entryitemparams").children().length == 2) {
            AUI.dialog.alert("请配置记账规则！", null, 3);
            return false;
        }
        var validateresult = true;
        $("#normaltrade_applyorderinfo_entryitemparams").children("div:gt(1)").each(function (i, n) {
            if ($(n).children("div:eq(1)").find("select").val() == "") {
                AUI.dialog.alert("请选择科目名称！", null, 3);
                validateresult = false;
                return false;
            }
            if ($(n).children("div:eq(2)").find("select").val() == "") {
                AUI.dialog.alert("请选择科目账户！", null, 3);
                validateresult = false;
                return false;
            }
            if ($.trim($(n).children("div:eq(4)").find("input").val()) == "") {
                AUI.dialog.alert("发生额不能为空！", function () {
                    $(n).children("div:eq(4)").find("input").focus();
                }, 3);
                validateresult = false;
                return false;
            } else if (isNaN(Number($.trim($(n).children("div:eq(4)").find("input").val())))) {
                AUI.dialog.alert("发生额不合法！", function () {
                    $(n).children("div:eq(4)").find("input").focus();
                }, 3);
                validateresult = false;
                return false;
            }
        });
        return validateresult;
    }

    $(function () {
        itemlist = eval($("#normaltrade_applyorderinfo_itemlist").val());
        subitemlist = eval($("#normaltrade_applyorderinfo_subitemlist").val());
        initEvent();
    });
})($);