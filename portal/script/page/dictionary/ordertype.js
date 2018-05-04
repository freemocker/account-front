/**
 * Created by zhangbin on 2016/9/13.
 */
(function ($) {

    var tablename = "acc_dic_ordertype";
    var grid_selectorId = "dic_ordertype_grid_table";
    var pager_selectorId = "dic_ordertype_grid_pager";

    dic_ordertype = {};

    /**
     * 生成用户列表
     *
     * @param grid_selectorId
     * @param pager_selectorId
     */
    dic_ordertype.generateGrid = function (grid_selectorId, pager_selectorId) {
        var grid_selector = grid_selectorId;
        var pager_selector = pager_selectorId;
        var param = {
            url: G_webrootPath + "/service/page/dictionary/serviceDictionary?tablename=" + tablename,
            editurl: G_webrootPath + "/service/page/dictionary/serviceDictionary?tablename=" + tablename,
            postData: {
                search_name: function () {
                    return $("#dic_ordertype_query_name").val();
                },
                search_code: function () {
                    return $("#dic_ordertype_query_code").val();
                },
                search_status: function () {
                    return $("#dic_ordertype_query_status").val();
                },
                search_type: function () {
                    return $("#dic_accountItem_query_type").val();
                },
                search_field3: function () {
                    return $("#dic_ordertype_query_field3").val();
                },
                search_field4: function () {
                    return $("#dic_ordertype_query_field4").val();
                },
                search_field5: function () {
                    return $("#dic_ordertype_query_field5").val();
                }
            },
            height: 290,
            sortname: "code",
            colNames: ['编辑', 'id', '名称', '编码', '表名', '审核', '审核菜单', '特殊交易', '配置发生额规则', '配置余额规则', '配置会计规则', '状态', 'authloginno', 'authpassword'],
            colModel: [{
                name: 'myac', index: '',
                width: 70,
                fixed: true,
                sortable: false,
                search: false,
                formatter: 'actions'
            }, {
                name: 'id', index: 'id',
                hidden: true
            }, {
                name: 'name', index: 'name',
                editable: true,
                editrules: {
                    required: true
                },
                edittype: 'text'
            }, {
                name: 'code', index: 'code',
                editable: true,
                editrules: {
                    required: true
                },
                edittype: 'text',
                align: 'center',
                width: 55,
                fixed: true
            }, {
                name: 'field1', index: 'field1',
                editable: true,
                edittype: 'text'
            }, {
                name: 'type', index: 'type',
                align: 'center',
                editable: true,
                editrules: {
                    required: true
                },
                edittype: 'select',
                formatter: 'select',
                editoptions: {
                    value: '2:否;1:是'
                },
                width: 55,
                fixed: true
            }, {
                name: 'field2', index: 'field2',
                editable: true,
                edittype: 'text'
            }, {
                name: 'field6', index: 'field6',
                align: 'center',
                editable: true,
                editrules: {
                    required: true
                },
                edittype: 'select',
                formatter: 'select',
                editoptions: {
                    value: '0:否;1:是'
                },
                width: 65,
                fixed: true
            }, {
                name: 'field5', index: 'field5',
                formatter: function (cellvalue, options, rowObject) {
                    var temp = "";
                    if (cellvalue == "1") {
                        temp = "<div class='bolder grid-form-field-div align-center width-100'><a href='javascript:void(0);' class='blue' " +
                            "onclick='dic_ordertype.configAmontDetail(\"" + rowObject.id + "\",\"" + rowObject.code + "\",\"" + rowObject.name + "\")'>修改</a></div>";
                    } else if (cellvalue == "0") {
                        temp = "<div class='bolder grid-form-field-div align-center width-100'><a href='javascript:void(0);' class='red' " +
                            "onclick='dic_ordertype.configAmontDetail(\"" + rowObject.id + "\",\"" + rowObject.code + "\",\"" + rowObject.name + "\")'>设置</a></div>";
                    }
                    return temp;
                },
                width: 120,
                fixed: true
            }, {
                name: 'field3', index: 'field3',
                formatter: function (cellvalue, options, rowObject) {
                    var temp = "";
                    if (cellvalue == "1") {
                        temp = "<div class='bolder grid-form-field-div align-center width-100'><a href='javascript:void(0);' class='blue' " +
                            "onclick='dic_ordertype.configBalance(\"" + rowObject.id + "\",\"" + rowObject.code + "\",\"" + rowObject.name + "\")'>修改</a></div>";
                    } else if (cellvalue == "0") {
                        temp = "<div class='bolder grid-form-field-div align-center width-100'><a href='javascript:void(0);' class='red' " +
                            "onclick='dic_ordertype.configBalance(\"" + rowObject.id + "\",\"" + rowObject.code + "\",\"" + rowObject.name + "\")'>设置</a></div>";
                    }
                    return temp;
                },
                width: 110,
                fixed: true
            }, {
                name: 'field4', index: 'field4',
                formatter: function (cellvalue, options, rowObject) {
                    var temp = "";
                    if (cellvalue == "1") {
                        temp = "<div class='bolder grid-form-field-div align-center width-100'><a href='javascript:void(0);' class='blue' " +
                            "onclick='dic_ordertype.configAccountItem(\"" + rowObject.id + "\",\"" + rowObject.code + "\",\"" + rowObject.name + "\")'>修改</a></div>";
                    } else if (cellvalue == "0") {
                        temp = "<div class='bolder grid-form-field-div align-center width-100'><a href='javascript:void(0);' class='red' " +
                            "onclick='dic_ordertype.configAccountItem(\"" + rowObject.id + "\",\"" + rowObject.code + "\",\"" + rowObject.name + "\")'>设置</a></div>";
                    }
                    return temp;
                },
                width: 110,
                fixed: true
            }, {
                name: 'statusname', index: 'statusname',
                align: 'center',
                fixed: true,
                editable: true,
                width: 65,
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
        AUI.grid.generateGrid(grid_selector, pager_selector, param);
    };

    dic_ordertype.configAmontDetail = function (typeid, typecode, typename) {
        AUI.dialog.inDialog("max", 500, "订单发生额分解规则", {
            innerUrl: G_webrootPath + "/view/page/dictionary/ordertypeamontrule?typeid=" + typeid + "&typename=" + typename + "&typecode=" + typecode
        }, null, function (rtn) {
            AUI.grid.refreshGrid(grid_selectorId);
        });
    };

    dic_ordertype.configBalance = function (typeid, typecode, typename) {
        AUI.dialog.inDialog("max", 500, "订单虚拟账户余额变化规则", {
            innerUrl: G_webrootPath + "/view/page/dictionary/ordertypebalancerule?typeid=" + typeid + "&typename=" + typename + "&typecode=" + typecode
        }, null, function (rtn) {
            AUI.grid.refreshGrid(grid_selectorId);
        });
    };

    dic_ordertype.configAccountItem = function (typeid, typecode, typename) {
        AUI.dialog.inDialog("max", 500, "订单会计分录规则", {
            innerUrl: G_webrootPath + "/view/page/dictionary/ordertypesubjectrule?typeid=" + typeid + "&typename=" + typename + "&typecode=" + typecode
        }, null, function (rtn) {
            AUI.grid.refreshGrid(grid_selectorId);
        });
    };

    /**
     * 绑定事件
     */
    dic_ordertype.initEvent = function () {
        $("#dic_ordertype_reset_btn").click(function () {
            $("#dic_ordertype_conditionform")[0].reset();
        });
        $("#dic_ordertype_query_btn").click(function () {
            AUI.grid.refreshGrid(grid_selectorId, true);
        });
        $("#dic_ordertype_add_btn").click(function () {
            AUI.grid.addRecordInline(grid_selectorId);
        });
    };

    $(function () {
        dic_ordertype.generateGrid(grid_selectorId, pager_selectorId);
        dic_ordertype.initEvent();
    });
})($);