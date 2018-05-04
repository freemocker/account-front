/**
 * Created by zhang on 2016/8/17.
 */
(function ($) {

    var businessAccountMng_businessinfo = function (id, oldemail, regioncode, industrycode, initflag, imagePath, businessid) {

        var formid = "businessAccountMng_businessinfo_form";

        var subaccount_grid_selectorId = "businessAccountMng_businessinfo_subaccount_grid_table";
        var subaccount_pager_selectorId = "businessAccountMng_businessinfo_subaccount_grid_pager";
        var inneraccount_grid_selectorId = "businessAccountMng_businessinfo_inneraccount_grid_table";
        var inneraccount_pager_selectorId = "businessAccountMng_businessinfo_inneraccount_grid_pager";

        var id = id;

        var oldemail = oldemail;

        var regioncode = regioncode;

        var industrycode = industrycode;

        var initflag = initflag;

        var imagePath = imagePath;

        var businessid = businessid;

        this.generateSubaccountGrid = function (grid_selectorId, pager_selectorId) {
            var grid_selector = grid_selectorId;
            var pager_selector = pager_selectorId;
            var param = {
                url: G_webrootPath + "/service/page/account/serviceBusinessAccount",
                editurl: G_webrootPath + "/service/page/account/serviceBusinessAccount?edittype=subaccount&accountid=" + id,
                postData: {
                    cmd: "subaccount",
                    accountid: id
                },
                sortname: "type",
                needFilter: true,
                filter: {
                    searchOnEnter: null
                },
                colNames: ['编辑', 'id', 'businessid', '默认账户', '账户类型', '账户编码', '可用余额', '折算金额', '创建时间', '状态', 'authloginno', 'authpassword'],
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
                    name: 'businessid',
                    index: 'businessid',
                    hidden: true
                }, {
                    name: 'isdefaultname',
                    index: 'isdefaultname',
                    align: "center",
                    width: 65,
                    editable: true,
                    fixed: true,
                    edittype: "checkbox",
                    editoptions: {
                        value: "是:否"
                    },
                    formatter: function (cellvalue, options, rowObject) {
                        var temp = "";
                        if (cellvalue == "是") {
                            temp = "<div class='blue bolder grid-form-field-div align-center width-100'>是</div>";
                        } else {
                            temp = "<div class='red bolder grid-form-field-div align-center width-100'>否</div>";
                        }
                        return temp;
                    },
                    unformat: AUI.grid.format.auiSwitch
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
                        value: $("#businessAccountMng_businessinfo_subaccount_type_select").val()
                    }
                }, {
                    name: 'code',
                    index: 'code',
                    width: 300,
                    fixed: true
                }, {
                    name: 'balance',
                    index: 'balance',
                    search: false
                }, {
                    name: 'money',
                    index: 'money',
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

        this.generateInneraccountGrid = function (grid_selectorId, pager_selectorId) {
            var grid_selector = grid_selectorId;
            var pager_selector = pager_selectorId;
            var param = {
                url: G_webrootPath + "/service/page/account/serviceBusinessAccount",
                postData: {
                    cmd: "inneraccount",
                    accountid: id
                },
                sortname: "innerid",
                needFilter: true,
                filter: {
                    searchOnEnter: null
                },
                colNames: ['id', 'businessid', '内部账号', '一级科目', '二级科目', '三级科目', '四级科目', '账户余额'],
                colModel: [{
                    name: 'id',
                    index: 'id',
                    hidden: true
                }, {
                    name: 'businessid',
                    index: 'businessid',
                    hidden: true
                }, {
                    name: 'innerid',
                    index: 'innerid',
                    width: 250,
                    fixed: true
                }, {
                    name: 'accountitemfirstname',
                    index: 'accountitemfirstname',
                    align: "center"
                }, {
                    name: 'accountitemsecdname',
                    index: 'accountitemsecdname',
                    align: "center"
                }, {
                    name: 'accountitemthirdname',
                    index: 'accountitemthirdname',
                    align: "center"
                }, {
                    name: 'accountsubitemname',
                    index: 'accountsubitemname',
                    align: "center"
                }, {
                    name: 'balance',
                    index: 'balance',
                    align: "center",
                    search: false
                }]
            };
            AUI.grid.generateGrid(grid_selector, pager_selector, param, null, {
                navGrid: {
                    search: true,
                    refresh: true
                }
            });
        };

        this.initBindList = function () {
            $("#businessAccountMng_businessinfo_edit_bindinfo_accordion").find("div[id^='businessAccountMng_businessinfo_edit_bindinfo_'][id$='_default']").addClass("hidden");
            $("#businessAccountMng_businessinfo_edit_bindinfo_accordion").find("div.panel-body").children().remove();
            $("#businessAccountMng_businessinfo_edit_bindinfo_accordion").find("span.badge").text("0");
            var configobj = this;
            configobj.doPost({
                    oper: "getBindList",
                    accountid: id
                }, function (data) {
                    for (var i = 0; i < data.length; i++) {
                        var item = data[i];
                        var divid = "businessAccountMng_businessinfo_edit_bindinfo_" + item.type;
                        configobj.buildBindItem(item, divid);
                    }
                }
            );
        };

        this.buildBindItem = function (item, divid) {
            var configobj = this;
            var innerHTML = new StringBuffer();
            var color = "alert-danger";
            var icon = "fa-times";
            var isdefaultname = item.isdefault;
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
            var name = item[item['bindno']];
            innerHTML.append('<div class="alert ');
            innerHTML.append(color);
            innerHTML.append('">');
            innerHTML.append('<div class="form-group no-margin no-padding"><div class="col-sm-8"><p><strong>');
            innerHTML.append(isdefaultname);
            innerHTML.append(name);
            innerHTML.append('</strong></p><p>创建时间：');
            innerHTML.append(item['createdate']);
            innerHTML.append('&nbsp;&nbsp;&nbsp;&nbsp;状态：');
            innerHTML.append(item.status);
            innerHTML.append('</p><p>');
            if (item.isdefault != "默认") {
                if (item.status == "激活") {
                    innerHTML.append('<button type="button" class="btn btn-sm btn-danger">禁用</button>&nbsp;');
                } else {
                    innerHTML.append('<button type="button" class="btn btn-sm btn-success">激活</button>&nbsp;');
                }
            }
            innerHTML.append('<button type="button" class="btn btn-sm btn-warning">编辑</button>');
            if (item.isdefault != "默认") {
                innerHTML.append('&nbsp;<button type="button" class="btn btn-sm">删除</button>');
                innerHTML.append('&nbsp;<button type="button" class="btn btn-sm btn-info">设为默认</button>');
            }
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
            var buttons = $divalert.children(":eq(0)").children(":eq(0)").children(":eq(2)").children();
            if (item.isdefault != "默认") {
                if (item.status == "激活") {
                    $(buttons[0]).click(function () {
                        configobj.disabledBind(item['id'], $divalert);
                    });
                } else {
                    $(buttons[0]).click(function () {
                        configobj.enabledBind(item['id'], $divalert);
                    });
                }
                $(buttons[1]).click(function () {
                    configobj.editBind(item['id'], item.businessid, $divalert);
                });
                $(buttons[2]).click(function () {
                    configobj.deleteBind(item['id'], $divalert);
                });
                $(buttons[3]).click(function () {
                    configobj.setDefaultBind(item['id'], item.businessid, item.type);
                });
            } else {
                $(buttons[0]).click(function () {
                    configobj.editBind(item['id'], item.businessid, $divalert);
                });
            }
        };

        this.disabledBind = function (bindinfoid, $divalert) {
            var configobj = this;
            portal_tools_obj.showAuthDialog(function (authdata) {
                configobj.doPost({
                        oper: "disabledBindInfo",
                        authloginno: authdata.authloginno,
                        authpassword: authdata.authpassword,
                        id: bindinfoid
                    }, function () {
                        configobj.changeBindInfoStatus(bindinfoid, 0, $divalert);
                    }
                );
            });
        };

        this.enabledBind = function (bindinfoid, $divalert) {
            var configobj = this;
            portal_tools_obj.showAuthDialog(function (authdata) {
                configobj.doPost({
                        oper: "enabledBindInfo",
                        authloginno: authdata.authloginno,
                        authpassword: authdata.authpassword,
                        id: bindinfoid
                    }, function () {
                        configobj.changeBindInfoStatus(bindinfoid, 1, $divalert);
                    }
                );
            });
        };

        this.deleteBind = function (bindinfoid, $divalert) {
            var configobj = this;
            portal_tools_obj.showAuthDialog(function (authdata) {
                configobj.doPost({
                        oper: "del",
                        authloginno: authdata.authloginno,
                        authpassword: authdata.authpassword,
                        edittype: "bindinfo",
                        id: bindinfoid
                    }, function () {
                        var $a = $divalert.parent().parent().prev().find("a[data-parent='#businessAccountMng_businessinfo_edit_bindinfo_accordion']");
                        var $badge = $divalert.parent().parent().prev().find("span.badge");
                        var number = Number($badge.text()) - 1;
                        $badge.text(number);
                        if (number == 0) {
                            $a.click();
                        }
                        $divalert.remove();
                    }
                );
            });
        };

        this.setDefaultBind = function (bindinfoid, businessid, type) {
            var configobj = this;
            portal_tools_obj.showAuthDialog(function (authdata) {
                configobj.doPost({
                        oper: "setDefaultBind",
                        authloginno: authdata.authloginno,
                        authpassword: authdata.authpassword,
                        id: bindinfoid,
                        businessid: businessid,
                        type: type
                    }, function () {
                        configobj.initBindList();
                    }
                );
            });
        };

        this.editBind = function (bindinfoid, businessid, $divalert) {
            AUI.dialog.inDialog(600, 553, "B类账户绑定详细信息", {
                innerUrl: G_webrootPath + "/view/page/account/businessAccountBindInfo?id=" + bindinfoid + "&businessid=" + businessid
            }, null, function (item) {
                if (item) {
                    var str = item[item.bindno];
                    if ($divalert.hasClass("alert-info")) {
                        str = "（默认）" + str;
                    }
                    $divalert.find("p:first strong").text(str);
                }
            });
        };

        this.addBind = function (businessid) {
            var configobj = this;
            AUI.dialog.inDialog(600, 553, "B类账户绑定详细信息", {
                innerUrl: G_webrootPath + "/view/page/account/businessAccountBindInfo?businessid=" + businessid
            }, null, function (item) {
                if (item) {
                    var divid = "businessAccountMng_businessinfo_edit_bindinfo_" + item['type'];
                    configobj.buildBindItem(item, divid);
                    $("#" + divid).prev().find("a[data-parent='#businessAccountMng_businessinfo_edit_bindinfo_accordion'][aria-expanded!='true']").click();
                }
            });
        };

        /**
         * 设置显示状态
         * @param bindinfoid
         * @param status 0-禁用，1-激活
         * @param $divbody
         */
        this.changeBindInfoStatus = function (bindinfoid, status, $divalert) {
            var configobj = this;
            switch (status) {
                case 0:
                    var $div = $divalert;
                    $div.removeClass("alert-success").addClass("alert-danger");
                    var statusStr = $div.find("p:eq(1)").text();
                    $div.find("p:eq(1)").text(statusStr.substring(0, statusStr.length - 2) + "禁用");
                    var buttonP = $div.find("p:eq(2)");
                    buttonP.children("button:eq(0)").remove();
                    buttonP.prepend('<button type="button" class="btn btn-sm btn-success">激活</button>');
                    buttonP.children("button:eq(0)").click(function () {
                        configobj.enabledBind(bindinfoid, $divalert);
                    });
                    $div.find(".item-icon-right i").removeClass("fa-check").addClass("fa-times");
                    break;
                case 1:
                    var $div = $divalert;
                    $div.removeClass("alert-danger").addClass("alert-success");
                    var statusStr = $div.find("p:eq(1)").text();
                    $div.find("p:eq(1)").text(statusStr.substring(0, statusStr.length - 2) + "激活");
                    var buttonP = $div.find("p:eq(2)");
                    buttonP.children("button:eq(0)").remove();
                    buttonP.prepend('<button type="button" class="btn btn-sm btn-danger">禁用</button>');
                    buttonP.children("button:eq(0)").click(function () {
                        configobj.disabledBind(bindinfoid, $divalert);
                    });
                    $div.find(".item-icon-right i").removeClass("fa-times").addClass("fa-check");
                    break;
            }
        };

        /**
         * 获取验证码
         */
        this.changeYZM = function (obj) {
            var $jobj = $(obj);
            var srcStr = $jobj.attr("src").substring(0, $jobj.attr("src").indexOf("?"));
            $jobj.attr("src", srcStr + "?" + Math.random());
        };

        /**
         * 初始化事件
         */
        this.initEvent = function () {
            var configobj = this;
            AUI.element.initValidate(formid, {
                businessAccountMng_businessinfo_businessname: "请填写B户名称",
                businessAccountMng_businessinfo_regionname: "请选择行政区域",
                businessAccountMng_businessinfo_regioncode: "请选择行政区域",
                businessAccountMng_businessinfo_industryname: "请选择行业分类",
                businessAccountMng_businessinfo_industrycode: "请选择行业分类",
                businessAccountMng_businessinfo_name: "请填写法人名称",
                businessAccountMng_businessinfo_certno: "请输入法人证件号码",
                businessAccountMng_businessinfo_telephone: "请输入预留电话号码",
                businessAccountMng_businessinfo_email: "请输入邮箱"
            });
            $("#businessAccountMng_businessinfo_telephone").mask('99999999999');
            $("#businessAccountMng_businessinfo_regionname").click(function () {
                var obj = $(this);
                configobj.showSelectTree(obj, {
                    title: "选择行政区域",
                    initParam: {
                        oper: "gettree",
                        tablename: "acc_dic_region",
                        selectall: true
                    }
                });
            });
            $("#businessAccountMng_businessinfo_industryname").click(function () {
                var obj = $(this);
                configobj.showSelectTree(obj, {
                    title: "选择国家行业分类",
                    initParam: {
                        oper: "gettree",
                        tablename: "acc_dic_industry",
                        selectall: false
                    }
                });
            });
            configobj.initUpLoadPlugin(initflag);
            if (initflag == 0) {
                this.generateSubaccountGrid(subaccount_grid_selectorId, subaccount_pager_selectorId);
                this.generateInneraccountGrid(inneraccount_grid_selectorId, inneraccount_pager_selectorId);
                this.initBindList();
                $("#businessAccountMng_businessinfo_rpw_btn").click(function () {
                    configobj.doResetPassword();
                });
                $("#businessAccountMng_businessinfo_rkey_btn").click(function () {
                    configobj.doRebuildKey();
                });
                $("#businessAccountMng_businessinfo_reset_btn").click(function () {
                    AUI.element.resetValidate(formid);
                });
                $("#businessAccountMng_businessinfo_cancle_btn").click(function () {
                    AUI.dialog.closeDialog($("#" + formid));
                });
                $("#businessAccountMng_businessinfo_edit_subaccount_a,#businessAccountMng_businessinfo_edit_inneraccount_a").click(function () {
                    setTimeout(function () {
                        AUI.grid.resizeGrid();
                    }, 0);
                });
                $("#businessAccountMng_businessinfo_save_btn").click(function () {
                    if (AUI.element.doValidate(formid)) {
                        var email = $("#businessAccountMng_businessinfo_email").val();
                        if (oldemail !== email) {
                            AUI.dialog.confirm("邮箱发生变动，将自动重置登录密码，是否继续？", function (result) {
                                if (result) {
                                    portal_tools_obj.showAuthDialog(function (authdata) {
                                        configobj.doPost({
                                            oper: "updateBasic",
                                            authloginno: authdata.authloginno,
                                            authpassword: authdata.authpassword,
                                            id: id,
                                            businessname: $("#businessAccountMng_businessinfo_businessname").val(),
                                            regionname: $("#businessAccountMng_businessinfo_regionname").val(),
                                            regioncode: $("#businessAccountMng_businessinfo_regioncode").val(),
                                            industryname: $("#businessAccountMng_businessinfo_industryname").val(),
                                            industrycode: $("#businessAccountMng_businessinfo_industrycode").val(),
                                            name: $("#businessAccountMng_businessinfo_name").val(),
                                            certtype: $("#businessAccountMng_businessinfo_certtype").val(),
                                            certno: $("#businessAccountMng_businessinfo_certno").val(),
                                            email: email,
                                            telephone: $("#businessAccountMng_businessinfo_telephone").val(),
                                            bankaccount: $("#businessAccountMng_businessinfo_bankaccount").val(),
                                            accountname: $("#businessAccountMng_businessinfo_accountname").val(),
                                            bank: $("#businessAccountMng_businessinfo_bank").val(),
                                            status: $("#businessAccountMng_businessinfo_status").val(),
                                            settlementtype: $("#businessAccountMng_businessinfo_settlementtype").val()
                                        }, function (data) {
                                            configobj.doPost({
                                                oper: "rpw",
                                                authloginno: authdata.authloginno,
                                                authpassword: authdata.authpassword,
                                                id: id
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
                                    id: id,
                                    businessname: $("#businessAccountMng_businessinfo_businessname").val(),
                                    regionname: $("#businessAccountMng_businessinfo_regionname").val(),
                                    regioncode: $("#businessAccountMng_businessinfo_regioncode").val(),
                                    industryname: $("#businessAccountMng_businessinfo_industryname").val(),
                                    industrycode: $("#businessAccountMng_businessinfo_industrycode").val(),
                                    name: $("#businessAccountMng_businessinfo_name").val(),
                                    certtype: $("#businessAccountMng_businessinfo_certtype").val(),
                                    certno: $("#businessAccountMng_businessinfo_certno").val(),
                                    email: email,
                                    telephone: $("#businessAccountMng_businessinfo_telephone").val(),
                                    bankaccount: $("#businessAccountMng_businessinfo_bankaccount").val(),
                                    accountname: $("#businessAccountMng_businessinfo_accountname").val(),
                                    bank: $("#businessAccountMng_businessinfo_bank").val(),
                                    status: $("#businessAccountMng_businessinfo_status").val(),
                                    settlementtype: $("#businessAccountMng_businessinfo_settlementtype").val()
                                });
                            });
                        }
                    }
                });
                $("#businessAccountMng_businessinfo_edit_bindinfo_add").click(function () {
                    configobj.addBind(businessid);
                });
            } else {
                $("#businessAccountMng_businessinfo_yzm_img").click(function () {
                    configobj.changeYZM(this);
                });
                $("#businessAccountMng_businessinfo_yzm").bind("keydown", function (event) {
                    var e = event || window.event || arguments.callee.caller.arguments[0];
                    if (e && e.keyCode == 13) {
                        if (e && e.preventDefault) {
                            e.preventDefault();
                        }
                        else {
                            window.event.returnValue = false;
                        }
                    }
                });
                $("#businessAccountMng_businessinfo_wizard_container").ace_wizard({
                    step: parseInt(initflag)
                }).on('actionclicked.fu.wizard', function (e, info) {
                    if (info.direction == "next") {
                        var fuwizard = $(this);
                        switch (info.step) {
                            case 1:
                                if (AUI.element.doValidate(formid)) {
                                    configobj.doPost({
                                        oper: "saveBasic",
                                        id: id,
                                        businessname: $("#businessAccountMng_businessinfo_businessname").val(),
                                        regionname: $("#businessAccountMng_businessinfo_regionname").val(),
                                        regioncode: $("#businessAccountMng_businessinfo_regioncode").val(),
                                        industryname: $("#businessAccountMng_businessinfo_industryname").val(),
                                        industrycode: $("#businessAccountMng_businessinfo_industrycode").val(),
                                        isdefault: $("#businessAccountMng_businessinfo_isdefault").val(),
                                        name: $("#businessAccountMng_businessinfo_name").val(),
                                        certtype: $("#businessAccountMng_businessinfo_certtype").val(),
                                        certno: $("#businessAccountMng_businessinfo_certno").val(),
                                        telephone: $("#businessAccountMng_businessinfo_telephone").val(),
                                        bankaccount: $("#businessAccountMng_businessinfo_bankaccount").val(),
                                        accountname: $("#businessAccountMng_businessinfo_accountname").val(),
                                        bank: $("#businessAccountMng_businessinfo_bank").val(),
                                        settlementtype: $("#businessAccountMng_businessinfo_settlementtype").val(),
                                        email: $("#businessAccountMng_businessinfo_email").val()
                                    }, function (data) {
                                        id = data.id;
                                        regioncode = $("#businessAccountMng_businessinfo_regioncode").val();
                                        industrycode = $("#businessAccountMng_businessinfo_industrycode").val();
                                        configobj.initUpLoadPlugin();
                                        var wizard = fuwizard.data('fu.wizard');
                                        wizard.currentStep = 2;
                                        wizard.setState();
                                    });
                                }
                                break;
                            case 2:
                                if ($.trim($("#businessAccountMng_businessinfo_businesslicense").val()) == "") {
                                    AUI.dialog.alert("请上传营业执照", undefined, 2, true);
                                    break;
                                }
                                if ($.trim($("#businessAccountMng_businessinfo_certpicture").val()) == "") {
                                    AUI.dialog.alert("请上传法人证件", undefined, 2, true);
                                    break;
                                }
                                var wizard = fuwizard.data('fu.wizard');
                                wizard.currentStep = 3;
                                wizard.setState();
                                break;
                            case 3:
                                if ($.trim($("#businessAccountMng_businessinfo_yzm").val()) == "") {
                                    AUI.dialog.alert("请输入验证码", undefined, 2, true);
                                    break;
                                }
                                var $this = $(this);
                                configobj.doPost({
                                    oper: "register",
                                    id: id,
                                    yzm: $("#businessAccountMng_businessinfo_yzm").val()
                                }, function (data) {
                                    $this.next().next().children().eq(0).remove();
                                    $("#businessAccountMng_businessinfo_result_businessname").text(data.businessname);
                                    $("#businessAccountMng_businessinfo_result_businessid").text(data.businessid);
                                    $("#businessAccountMng_businessinfo_result_channel").text(data.channel);
                                    $("#businessAccountMng_businessinfo_result_id").text(data.id);
                                    $("#businessAccountMng_businessinfo_result_businesskey").text(data.businesskey);
                                    $("#businessAccountMng_businessinfo_result_loginno").text(data.loginno);
                                    $("#businessAccountMng_businessinfo_result_password").text(data.password);
                                    var subaccount = data.subaccount;
                                    var tbodyHTML = new StringBuffer();
                                    if (subaccount.length > 0) {
                                        for (var i = 0; i < subaccount.length; i++) {
                                            tbodyHTML.append('<tr>');
                                            tbodyHTML.append('<td class="center">' + (i + 1) + '</td>');
                                            tbodyHTML.append('<td class="center">' + subaccount[i]['type'] + '</td>');
                                            tbodyHTML.append('<td class="hidden-xs">' + subaccount[i]['code'] + '</td>');
                                            tbodyHTML.append('<td>0.00</td>');
                                            tbodyHTML.append('<td>0.00</td>');
                                            tbodyHTML.append('<td class="center hidden-480">' + subaccount[i]['createdate'] + '</td>');
                                            tbodyHTML.append('</tr>');
                                        }
                                    } else {
                                        tbodyHTML.append('');
                                    }
                                    $("#businessAccountMng_businessinfo_result_subaccountbody").append(tbodyHTML.toString());
                                    var wizard = fuwizard.data('fu.wizard');
                                    wizard.currentStep = 4;
                                    wizard.setState();
                                });
                                break;
                        }
                        e.preventDefault();
                    }
                }).on('finished.fu.wizard', function (e) {
                    AUI.dialog.closeDialog($("#" + formid), true);
                }).on('stepclicked.fu.wizard', function (e) {
                    e.preventDefault();
                });
            }
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
            portal_tools_obj.doAjax(G_webrootPath + "/service/page/account/serviceBusinessAccount", param, function (data) {
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
                console.log(obj);
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
                            id: id
                        });
                    });
                }
            });
        };

        /**
         * 重新生成安全校验key
         */
        this.doRebuildKey = function () {
            var configobj = this;
            AUI.dialog.confirm("确定重新生成安全校验key？", function (result) {
                if (result) {
                    portal_tools_obj.showAuthDialog(function (authdata) {
                        configobj.doPost({
                            oper: "rkey",
                            authloginno: authdata.authloginno,
                            authpassword: authdata.authpassword,
                            id: id
                        }, function (data) {
                            AUI.dialog.alert(data.result, function () {
                                $("#businessAccountMng_businessinfo_key").text(data.key);
                            }, 1);
                        });
                    });
                }
            });
        };

        this.showSelectTree = function (obj, param) {
            var param = $.extend({
                initUrl: G_webrootPath + "/service/page/account/serviceBusinessAccount",
                getAllPath: true,
                getid: false,
                datas: obj.val().replace(/->/ig, "/")
            }, param);
            AUI.tree.showTree(param, function (rtn) {
                if (rtn) {
                    var name = "";
                    var code = "";
                    if (rtn.length > 0) {
                        name = rtn[0].name.replace(/\//ig, "->");
                        code = name.substring(name.lastIndexOf("(") + 1, name.length - 1);
                    }
                    obj.val(name);
                    obj.next().val(code);
                }
            });
        };

        this.doSaveImage = function (imageid, fieldname) {
            this.doPost({
                oper: "saveImage",
                id: id,
                urls: $("#" + imageid).val(),
                fieldname: fieldname
            }, function (data) {
            });
        };

        this.initUpLoadPlugin = function (initflag) {
            var readonly = initflag == 0;
            var currObj = this;
            /* 营业执照上传组件 */
            var options_businesslicense = {
                title: "营业执照",
                readonly: readonly,
                path: currObj.getImagePath(),
                files: $("#businessAccountMng_businessinfo_businesslicense_init").val(),
                maxFilesize: 1024,
                acceptedFiles: '.jpg,.jpe,.jpeg,.gif,.png',
                onlyimg: true,
                imgmaxwidth: 150,
                imgmaxheight: 150,
                maxFiles: 5,
                afterCompleteFun: function (filepath) {
                    if (filepath != undefined) {
                        currObj.doSaveImage("businessAccountMng_businessinfo_businesslicense", "businesslicense");
                    }
                },
                afterDeleteFun: function (result, filepath) {
                    currObj.doSaveImage("businessAccountMng_businessinfo_businesslicense", "businesslicense");
                }
            };
            var upload_businesslicense = new _tools_file_obj.UpLoadPlugin("businessAccountMng_businessinfo_businesslicense_div", "businessAccountMng_businessinfo_businesslicense", options_businesslicense);
            upload_businesslicense.destroy();
            upload_businesslicense.show();
            /* 法人证件上传组件 */
            var options_certtype = {
                title: "法人证件",
                readonly: readonly,
                path: currObj.getImagePath(),
                files: $("#businessAccountMng_businessinfo_certpicture_init").val(),
                maxFilesize: 1024,
                acceptedFiles: '.jpg,.jpe,.jpeg,.gif,.png',
                onlyimg: true,
                imgmaxwidth: 150,
                imgmaxheight: 150,
                maxFiles: 2,
                afterCompleteFun: function (filepath) {
                    if (filepath != undefined) {
                        currObj.doSaveImage("businessAccountMng_businessinfo_certpicture", "certpicture");
                    }
                },
                afterDeleteFun: function (result, filepath) {
                    currObj.doSaveImage("businessAccountMng_businessinfo_certpicture", "certpicture");
                }
            };
            var upload_certtype = new _tools_file_obj.UpLoadPlugin("businessAccountMng_businessinfo_certpicture_div", "businessAccountMng_businessinfo_certpicture", options_certtype);
            upload_certtype.destroy();
            upload_certtype.show();
        };

        /**
         * 获取图片上传路径
         * @returns {string}
         */
        this.getImagePath = function () {
            return imagePath + regioncode + "/" + industrycode + "/" + id;
        };
    };

    $(function () {
        var obj = new businessAccountMng_businessinfo($("#businessAccountMng_businessinfo_id").val(), $("#businessAccountMng_businessinfo_oldemail").val(), $("#businessAccountMng_businessinfo_regioncode_init").val(), $("#businessAccountMng_businessinfo_industrycode_init").val(),
            $("#businessAccountMng_businessinfo_initflag").val(), $("#businessAccountMng_businessinfo_imagePath").val(), $("#businessAccountMng_businessinfo_businessid").val());
        obj.initPage();
    });
})($);