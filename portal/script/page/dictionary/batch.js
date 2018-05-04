/**
 * Created by zhangbin on 2016/11/19.
 */
(function ($) {

    var tablename = "acc_dic_batch";
    var grid_selectorId = "dic_batch_grid_table";
    var pager_selectorId = "dic_batch_grid_pager";

    dic_batch = {};

    /**
     * 生成用户列表
     *
     * @param grid_selectorId
     * @param pager_selectorId
     */
    dic_batch.generateGrid = function (grid_selectorId, pager_selectorId) {
        var grid_selector = grid_selectorId;
        var pager_selector = pager_selectorId;
        var param = {
            url: G_webrootPath + "/service/page/dictionary/serviceDictionary?tablename=" + tablename,
            editurl: G_webrootPath + "/service/page/dictionary/serviceDictionary?tablename=" + tablename,
            postData: {
                search_name: function () {
                    return $("#dic_batch_query_name").val();
                },
                search_code: function () {
                    return $("#dic_batch_query_code").val();
                },
                search_status: function () {
                    return $("#dic_batch_query_status").val();
                }
            },
            multiselect: true,
            height: 290,
            sortname: "type",
            colNames: ['编辑', 'id', '序号', '任务名称', '任务类名', '组件包名', '任务描述', '执行周期', '执行类型', '执行规则', '执行方式', '状态', 'authloginno', 'authpassword'],
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
                name: 'type', index: 'type',
                editable: true,
                editrules: {
                    required: true
                },
                edittype: 'text',
                align: 'center',
                fixed: true,
                width: 50
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
                edittype: 'text'
            }, {
                name: 'field1', index: 'field1',
                editable: true,
                editrules: {
                    required: true
                },
                edittype: 'text'
            }, {
                name: 'remark', index: 'remark',
                editable: true,
                edittype: 'textarea',
                editoptions: {rows: "2"}
            }, {
                name: 'field2', index: 'field2',
                align: 'center',
                editable: true,
                editrules: {
                    required: true
                },
                edittype: 'select',
                formatter: 'select',
                editoptions: {
                    value: 'Day:每天;Week:每周;Month:每月;Quarter:每季度;Year:每年'
                },
                width: 80,
                fixed: true
            }, {
                name: 'field3', index: 'field3',
                align: 'center',
                editable: true,
                editrules: {
                    required: true
                },
                edittype: 'select',
                formatter: 'select',
                editoptions: {
                    value: 'All:全部;WeekDay:工作日;Weekend:周末'
                },
                width: 80,
                fixed: true
            }, {
                name: 'field4', index: 'field4',
                editable: true,
                editrules: {
                    required: true
                },
                edittype: 'text'
            }, {
                name: 'field5', index: 'field5',
                align: 'center',
                editable: true,
                editrules: {
                    required: true
                },
                edittype: 'select',
                formatter: 'select',
                editoptions: {
                    value: '1:顺序;2:单独'
                },
                width: 65,
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

    /**
     * 绑定事件
     */
    dic_batch.initEvent = function () {
        $("#dic_batch_reset_btn").click(function () {
            $("#dic_batch_conditionform")[0].reset();
        });
        $("#dic_batch_query_btn").click(function () {
            AUI.grid.refreshGrid(grid_selectorId, true);
        });
        $("#dic_batch_add_btn").click(function () {
            AUI.grid.addRecordInline(grid_selectorId);
        });
        $("#dic_batch_del_btn").click(function () {
            AUI.grid.delRecord(grid_selectorId);
        });
    };

    $(function () {
        dic_batch.generateGrid(grid_selectorId, pager_selectorId);
        dic_batch.initEvent();
    });
})($);