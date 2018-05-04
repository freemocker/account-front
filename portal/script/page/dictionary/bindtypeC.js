/**
 * Created by zhang on 2016/8/15.
 */
(function ($) {

    var tablename = "acc_dic_c_bindtype";
    var grid_selectorId = "dic_bindtypec_grid_table";
    var pager_selectorId = "dic_bindtypec_grid_pager";

    dic_bindtypec = {};

    /**
     * 生成用户列表
     *
     * @param grid_selectorId
     * @param pager_selectorId
     */
    dic_bindtypec.generateGrid = function (grid_selectorId, pager_selectorId) {
        var grid_selector = grid_selectorId;
        var pager_selector = pager_selectorId;
        var param = {
            url: G_webrootPath + "/service/page/dictionary/serviceDictionary?tablename=" + tablename,
            editurl: G_webrootPath + "/service/page/dictionary/serviceDictionary?tablename=" + tablename,
            postData: {
                search_name: function () {
                    return $("#dic_bindtypec_query_name").val();
                },
                search_code: function () {
                    return $("#dic_bindtypec_query_code").val();
                },
                search_status: function () {
                    return $("#dic_bindtypec_query_status").val();
                }
            },
            height: 290,
            sortname: "code",
            colNames: ['编辑', 'id', '名称', '编码', '备注', '修改时间', '状态', 'authloginno', 'authpassword'],
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
                edittype: 'text'
            }, {
                name: 'remark', index: 'remark',
                editable: true,
                edittype: 'text'
            }, {
                name: 'modifydate', index: 'modifydate',
                align: 'center',
                fixed: true,
                width: 140
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
    dic_bindtypec.initEvent = function () {
        $("#dic_bindtypec_reset_btn").click(function () {
            $("#dic_bindtypec_conditionform")[0].reset();
        });
        $("#dic_bindtypec_query_btn").click(function () {
            AUI.grid.refreshGrid(grid_selectorId, true);
        });
        $("#dic_bindtypec_add_btn").click(function () {
            AUI.grid.addRecordInline(grid_selectorId);
        });
    };

    $(function () {
        dic_bindtypec.generateGrid(grid_selectorId, pager_selectorId);
        dic_bindtypec.initEvent();
    });
})($);