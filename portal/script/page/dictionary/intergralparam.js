/**
 * Created by zhangbin on 2016/12/15.
 */
(function ($) {

    var tablename = "acc_dic_intergralparam";
    var grid_selectorId = "dic_intergralparam_grid_table";
    var pager_selectorId = "dic_intergralparam_grid_pager";

    dic_intergralparam = {};

    /**
     * 生成用户列表
     *
     * @param grid_selectorId
     * @param pager_selectorId
     */
    dic_intergralparam.generateGrid = function (grid_selectorId, pager_selectorId) {
        var grid_selector = grid_selectorId;
        var pager_selector = pager_selectorId;
        var param = {
            url: G_webrootPath + "/service/page/dictionary/serviceDictionary?tablename=" + tablename,
            editurl: G_webrootPath + "/service/page/dictionary/serviceDictionary?tablename=" + tablename,
            postData: {
                search_name: function () {
                    return $("#dic_intergralparam_query_name").val();
                },
                search_code: function () {
                    return $("#dic_intergralparam_query_code").val();
                },
                search_status: function () {
                    return $("#dic_intergralparam_query_status").val();
                },
                search_type: function () {
                    return $("#dic_intergralparam_query_type").val();
                },
                search_field1: function () {
                    return $("#dic_intergralparam_query_field1").val();
                },
                search_field2: function () {
                    return $("#dic_intergralparam_query_field2").val();
                }
            },
            height: 290,
            sortname: "code",
            colNames: ['编辑', 'id', '名称', '参数值', '参数类型', '说明', '有效期类型', '有效开始日期', '修改时间', '状态', 'authloginno', 'authpassword'],
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
                align: 'center',
                editable: true,
                editrules: {
                    required: true
                },
                edittype: 'text',
                width: 100,
                fixed: true
            }, {
                name: 'type', index: 'type',
                align: 'center',
                editable: true,
                editrules: {
                    required: true
                },
                edittype: 'select',
                formatter: 'select',
                stype: "select",
                editoptions: {
                    value: ':;1:积分价值'
                },
                width: 150,
                fixed: true
            }, {
                name: 'remark', index: 'remark',
                editable: true,
                edittype: 'text'
            }, {
                name: 'field1', index: 'field1',
                align: 'center',
                editable: true,
                editrules: {
                    required: true
                },
                edittype: 'select',
                formatter: 'select',
                stype: "select",
                editoptions: {
                    value: ':;0:会计日期;1:系统日期'
                },
                width: 100,
                fixed: true
            }, {
                name: 'field2', index: 'field2',
                align: 'center',
                editable: true,
                editrules: {
                    required: true
                },
                edittype: 'text',
                fixed: true,
                width: 100,
                editoptions: {
                    size: "10",
                    maxlength: "10"
                },
                unformat: AUI.grid.format.pickDate
            }, {
                name: 'modifydate', index: 'modifydate',
                align: 'center',
                fixed: true,
                width: 80
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

    /**
     * 绑定事件
     */
    dic_intergralparam.initEvent = function () {
        AUI.element.initDatePicker("dic_intergralparam_query_field2");
        $("#dic_intergralparam_reset_btn").click(function () {
            $("#dic_intergralparam_conditionform")[0].reset();
        });
        $("#dic_intergralparam_query_btn").click(function () {
            AUI.grid.refreshGrid(grid_selectorId, true);
        });
        $("#dic_intergralparam_add_btn").click(function () {
            AUI.grid.addRecordInline(grid_selectorId);
        });
    };

    $(function () {
        dic_intergralparam.generateGrid(grid_selectorId, pager_selectorId);
        dic_intergralparam.initEvent();
    });
})($);