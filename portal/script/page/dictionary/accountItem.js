/**
 * Created by zhang on 2016/8/10.
 */
(function ($) {

    var tablename = "acc_dic_account_item";
    var grid_selectorId = "dic_accountitem_grid_table";
    var pager_selectorId = "dic_accountitem_grid_pager";

    dic_accountitem = {};

    /**
     * 生成用户列表
     *
     * @param grid_selectorId
     * @param pager_selectorId
     */
    dic_accountitem.generateGrid = function (grid_selectorId, pager_selectorId) {
        var grid_selector = grid_selectorId;
        var pager_selector = pager_selectorId;
        var param = {
            url: G_webrootPath + "/service/page/dictionary/serviceDictionary?tablename=" + tablename,
            editurl: G_webrootPath + "/service/page/dictionary/serviceDictionary?tablename=" + tablename,
            postData: {
                search_name: function () {
                    return $("#dic_accountitem_query_name").val();
                },
                search_code: function () {
                    return $("#dic_accountitem_query_code").val();
                },
                search_parent: function () {
                    return $("#dic_accountitem_query_parent").val();
                },
                search_status: "1",
                search_field1: function () {
                    return $("#dic_accountitem_query_field1").val();
                },
                search_field2: function () {
                    return $("#dic_accountitem_query_field2").val();
                }
            },
            height: 290,
            sortname: "code",
            colNames: ['编辑', 'id', '名称', '编码', '上级id', '上级名称', '余额方向', '科目类型', '层级', 'authloginno', 'authpassword'],
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
                name: 'field1', index: 'field1',
                editable: true,
                editrules: {
                    required: true
                },
                align: "center",
                edittype: 'select',
                formatter: 'select',
                editoptions: {
                    value: '1:借;2:贷;3:共同'
                },
                fixed: true,
                width: 80
            }, {
                name: 'field2', index: 'field2',
                editable: true,
                editrules: {
                    required: true
                },
                align: "center",
                edittype: 'select',
                formatter: 'select',
                editoptions: {
                    value: '1:资产类;2:负债类;3:共同类;4:所有者权益类;5:成本类;6:损益类'
                },
                fixed: true,
                width: 120
            }, {
                name: 'field5', index: 'field5',
                editable: false,
                align: "center",
                width: 40,
                fixed: true
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
    dic_accountitem.initEvent = function () {
        $("#dic_accountitem_reset_btn").click(function () {
            $("#dic_accountitem_conditionform")[0].reset();
        });
        $("#dic_accountitem_query_btn").click(function () {
            AUI.grid.refreshGrid(grid_selectorId, true);
        });
        $("#dic_accountitem_add_btn").click(function () {
            AUI.grid.addRecordInline(grid_selectorId);
        });
    };

    $(function () {
        dic_accountitem.generateGrid(grid_selectorId, pager_selectorId);
        dic_accountitem.initEvent();
    });
})($);