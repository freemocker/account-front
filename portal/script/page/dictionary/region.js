/**
 * Created by zhang on 2016/8/10.
 */
(function ($) {

    var tablename = "acc_dic_region";
    var grid_selectorId = "dic_region_grid_table";
    var pager_selectorId = "dic_region_grid_pager";

    dic_region = {};

    /**
     * 生成用户列表
     *
     * @param grid_selectorId
     * @param pager_selectorId
     */
    dic_region.generateGrid = function (grid_selectorId, pager_selectorId) {
        var grid_selector = grid_selectorId;
        var pager_selector = pager_selectorId;
        var param = {
            url: G_webrootPath + "/service/page/dictionary/serviceDictionary?tablename=" + tablename,
            editurl: G_webrootPath + "/service/page/dictionary/serviceDictionary?tablename=" + tablename,
            postData: {
                search_name: function () {
                    return $("#dic_region_query_name").val();
                },
                search_code: function () {
                    return $("#dic_region_query_code").val();
                },
                search_status: function () {
                    return $("#dic_region_query_status").val();
                },
                search_parent: function () {
                    return $("#dic_region_query_parent").val();
                }
            },
            multiselect: true,
            height: 290,
            sortname: "code",
            colNames: ['编辑', 'id', '名称', '编码', '上级id', '上级名称', '备注', '修改时间', '状态', 'authloginno', 'authpassword'],
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
                name: 'parentid', index: 'parentid',
                editable: true,
                hidden: true,
                edittype: 'text'
            }, {
                name: 'parent', index: 'parent',
                editable: true,
                editoptions: {
                    readonly: true,
                    dataEvents: [{
                        type: 'click', fn: function () {
                            var obj = $(this);
                            var rowid = obj.parent().parent().attr("id");
                            var id = $("#" + grid_selector).getCell(rowid, "id");
                            AUI.tree.showTree({
                                title: "选择上级",
                                initUrl: G_webrootPath + "/service/page/dictionary/serviceDictionary",
                                initParam: {
                                    oper: "gettree",
                                    tablename: tablename,
                                    id: id
                                },
                                getAllPath: false,
                                datas: obj.parent().prev().find("input").val()
                            }, function (rtn) {
                                if (rtn) {
                                    obj.val(rtn[0].name);
                                    obj.parent().prev().find("input").val(rtn[0].id);
                                }
                            });
                        }
                    }]
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
    dic_region.initEvent = function () {
        $("#dic_region_reset_btn").click(function () {
            $("#dic_region_conditionform")[0].reset();
        });
        $("#dic_region_query_btn").click(function () {
            AUI.grid.refreshGrid(grid_selectorId, true);
        });
        $("#dic_region_add_btn").click(function () {
            AUI.grid.addRecordInline(grid_selectorId);
        });
        $("#dic_region_del_btn").click(function () {
            AUI.grid.delRecord(grid_selectorId);
        });
    };

    $(function () {
        dic_region.generateGrid(grid_selectorId, pager_selectorId);
        dic_region.initEvent();
    });
})($);