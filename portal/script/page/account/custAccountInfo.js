/**
 * Created by zhangbin on 2016/10/13.
 */
(function ($) {

    var custAccountMng_custinfo = function (id, custid, oldtelephone) {

        var formid = "custAccountMng_custinfo_form";

        var subaccount_grid_selectorId = "custAccountMng_custinfo_subaccount_grid_table";
        var subaccount_pager_selectorId = "custAccountMng_custinfo_subaccount_grid_pager";

        var custid = custid;

        var oldtelephone = oldtelephone;

        this.generateSubaccountGrid = function (grid_selectorId, pager_selectorId) {
            var grid_selector = grid_selectorId;
            var pager_selector = pager_selectorId;
            var param = {
                url: G_webrootPath + "/service/page/account/serviceCustAccount",
                editurl: G_webrootPath + "/service/page/account/serviceCustAccount?edittype=subaccount&accountid=" + custid,
                postData: {
                    cmd: "subaccount",
                    accountid: custid
                },
                sortname: "type",
                needFilter: true,
                filter: {
                    searchOnEnter: null
                },
                colNames: ['编辑', 'id', 'custid', '账户类型', '账户编码', '可用余额', '创建时间', '状态', 'authloginno', 'authpassword'],
                colModel: [{
                    name: 'myac',
                    index: '',
                    width: 70,
                    fixed: true,
                    sortable: false,
                    search: false,
                    formatter: 'actions'
                }, {
                    name: 'id',
                    index: 'id',
                    hidden: true
                }, {
                    name: 'custid',
                    index: 'custid',
                    hidden: true
                }, {
                    name: 'type',
                    index: 'type',
                    width: 150,
                    editable: true,
                    fixed: true,
                    formatter: "select",
                    stype: "select",
                    edittype: 'select',
                    editrules: {
                        required: true
                    },
                    editoptions: {
                        value: $("#custAccountMng_custinfo_subaccount_type_select").val()
                    }
                }, {
                    name: 'code',
                    index: 'code'
                }, {
                    name: 'balance',
                    index: 'balance',
                    search: false
                }, {
                    name: 'createdate',
                    index: 'createdate',
                    align: "center",
                    width: 150,
                    fixed: true
                }, {
                    name: 'statusname',
                    index: 'statusname',
                    align: "center",
                    width: 65,
                    editable: true,
                    fixed: true,
                    edittype: "checkbox",
                    editoptions: {
                        value: "启用:禁用"
                    },
                    formatter: function (cellvalue, options, rowObject) {
                        var temp = "";
                        if (cellvalue == "启用") {
                            temp = "<div class='blue bolder grid-form-field-div align-center width-100'>启用</div>";
                        } else {
                            temp = "<div class='red bolder grid-form-field-div align-center width-100'>禁用</div>";
                        }
                        return temp;
                    },
                    unformat: AUI.grid.format.auiSwitch
                }, {
                    name: 'authloginno', index: 'authloginno',
                    editable: true,
                    edittype: "text",
                    hidden: true
                }, {
                    name: 'authpassword', index: 'authpassword',
                    editable: true,
                    edittype: "text",
                    hidden: true
                }],
                customerParams: {
                    needAuth: true
                }
            };
            AUI.grid.generateGrid(grid_selector, pager_selector, param, null, {
                navGrid: {
                    search: true,
                    refresh: true
                },
                inlineNav: {
                    add: true
                }
            });
        };

        this.initBindList = function () {
            $("#custAccountMng_custinfo_edit_bindinfo_accordion").find("div[id^='custAccountMng_custinfo_edit_bindinfo_'][id$='_default']").addClass("hidden");
            $("#custAccountMng_custinfo_edit_bindinfo_accordion").find("div.panel-body").children().remove();
            $("#custAccountMng_custinfo_edit_bindinfo_accordion").find("span.badge").text("0");
            var configobj = this;
            configobj.doPost({
                    oper: "getBindList",
                    accountid: custid
                }, function (data) {
                    for (var i = 0; i < data.length; i++) {
                        var item = data[i];
                        var divid = "custAccountMng_custinfo_edit_bindinfo_" + item.type;
                        configobj.buildBindItem(item, divid);
                    }
                }
            );
        };

        this.buildBindItem = function (item, divid) {
            var innerHTML = new StringBuffer();
            var color = "alert-danger";
            var icon = "fa-times";
            var isdefaultname = item.isdefault;
            if (item.isdel == "已删除") {
                item.status = "已删除";
            }
            if (item.isdefault == "默认") {
                isdefaultname = "（" + isdefaultname + "）";
                $("#" + divid + "_default").removeClass("hidden");
                color = "alert-info";
            } else {
                if (item.status == "激活") {
                    color = "alert-success";
                }
            }
            if (item.status == "激活") {
                icon = "fa-check";
            }
            innerHTML.append('<div class="alert ');
            innerHTML.append(color);
            innerHTML.append('">');
            innerHTML.append('<div class="form-group no-margin no-padding"><div class="col-sm-8"><p><strong>');
            innerHTML.append(isdefaultname);
            innerHTML.append(item.account);
            innerHTML.append('</strong></p><p>创建时间：');
            innerHTML.append(item['createdate']);
            innerHTML.append('&nbsp;&nbsp;&nbsp;&nbsp;状态：');
            innerHTML.append(item.status);
            innerHTML.append('</p><p>');
            innerHTML.append('<p></div>');
            innerHTML.append('<div class="col-sm-4 item-icon-right"><span style="font-size: 70px;"><i class="ace-icon fa ');
            innerHTML.append(icon);
            innerHTML.append('"></i></span></div></div></div>');
            var divbody = $("#" + divid + " .panel-body");
            divbody.append(innerHTML.toString());
            var $divalert = divbody.children(":last");
            var $badge = $divalert.parent().parent().prev().find("span.badge");
            var number = Number($badge.text()) + 1;
            $badge.text(number);
        };

        /**
         * 初始化事件
         */
        this.initEvent = function () {
            var configobj = this;
            $("#custAccountMng_custinfo_telephone").mask('99999999999');
            this.generateSubaccountGrid(subaccount_grid_selectorId, subaccount_pager_selectorId);
            this.initBindList();
            $("#custAccountMng_custinfo_rpw_btn").click(function () {
                configobj.doResetPassword();
            });
            $("#custAccountMng_custinfo_cancle_btn").click(function () {
                AUI.dialog.closeDialog($("#" + formid));
            });
            $("#custAccountMng_custinfo_edit_subaccount_a,#custAccountMng_custinfo_edit_bindinfo_a").click(function () {
                setTimeout(function () {
                    AUI.grid.resizeGrid();
                }, 0);
            });
            $("#custAccountMng_custinfo_save_btn").click(function () {
                var telephone = $.trim($("#custAccountMng_custinfo_telephone").val());
                if (telephone == "") {
                    AUI.dialog.alert("请输入电话号码", null, 3);
                    return;
                } else if (telephone.length != 11) {
                    AUI.dialog.alert("请输入正确的电话号码", null, 3);
                    return;
                }
                if (oldtelephone != telephone) {
                    AUI.dialog.confirm("手机号发生变动，将自动重置登录密码，是否继续？", function (result) {
                        if (result) {
                            portal_tools_obj.showAuthDialog(function (authdata) {
                                configobj.doPost({
                                    oper: "updateBasic",
                                    authloginno: authdata.authloginno,
                                    authpassword: authdata.authpassword,
                                    custid: custid,
                                    nickname: $.trim($("#custAccountMng_custinfo_nickname").val()),
                                    name: $.trim($("#custAccountMng_custinfo_name").val()),
                                    certtype: $("#custAccountMng_custinfo_certtype").val(),
                                    certno: $.trim($("#custAccountMng_custinfo_certno").val()),
                                    telephone: telephone,
                                    status: $("#custAccountMng_custinfo_status").val()
                                }, function (data) {
                                    configobj.doPost({
                                        oper: "rpw",
                                        authloginno: authdata.authloginno,
                                        authpassword: authdata.authpassword,
                                        custid: custid
                                    }, function () {
                                        AUI.dialog.alert(data.result, undefined, 1);
                                    });
                                });
                            });
                        }
                    });
                } else {
                    portal_tools_obj.showAuthDialog(function (authdata) {
                        configobj.doPost({
                            oper: "updateBasic",
                            authloginno: authdata.authloginno,
                            authpassword: authdata.authpassword,
                            custid: custid,
                            nickname: $.trim($("#custAccountMng_custinfo_nickname").val()),
                            name: $.trim($("#custAccountMng_custinfo_name").val()),
                            certtype: $("#custAccountMng_custinfo_certtype").val(),
                            certno: $.trim($("#custAccountMng_custinfo_certno").val()),
                            telephone: telephone,
                            status: $("#custAccountMng_custinfo_status").val()
                        });
                    });
                }
            });
            $("#custAccountMng_custinfo_edit_bindinfo_add").click(function () {
                configobj.addBind(custid);
            });
        };

        /**
         * 初始化账户信息
         */
        this.initPage = function () {
            this.initEvent();
        };

        /**
         * 保存B户信息
         */
        this.doPost = function (param, callBackFunc) {
            AUI.showProcess(undefined, $("#" + formid).closest(".widget-main"), true);
            portal_tools_obj.doAjax(G_webrootPath + "/service/page/account/serviceCustAccount", param, function (data) {
                AUI.closeProcess($("#" + formid).closest(".widget-main"));
                if (data.errmsg) {
                    AUI.dialog.alert(data.errmsg, null, 3);
                } else {
                    if (typeof (callBackFunc) == "function") {
                        callBackFunc(data);
                    } else {
                        AUI.dialog.alert(data.result, undefined, 1);
                    }
                }
            }, "POST", false, "json", true, function (obj, message, exception) {
                AUI.dialog.alert(message, function () {
                    AUI.closeProcess($("#" + formid).closest(".widget-main"));
                }, 3);
            });
        };

        /**
         * 重置密码
         */
        this.doResetPassword = function () {
            var configobj = this;
            AUI.dialog.confirm("确定重置账户登录密码？", function (result) {
                if (result) {
                    portal_tools_obj.showAuthDialog(function (authdata) {
                        configobj.doPost({
                            oper: "rpw",
                            authloginno: authdata.authloginno,
                            authpassword: authdata.authpassword,
                            custid: custid
                        });
                    });
                }
            });
        };
    };

    $(function () {
        var obj = new custAccountMng_custinfo($("#custAccountMng_custinfo_id").val(), $("#custAccountMng_custinfo_custid").val(), $("#custAccountMng_custinfo_oldtelephone").val());
        obj.initPage();
    });
})($);