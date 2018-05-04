/**
 * Created by zhangbin on 2016/10/25.
 */
(function ($) {

    var typeid = "";
    var grid_selectorId = "dic_ordertype_amontrule_grid_table";
    var pager_selectorId = "dic_ordertype_amontrule_grid_pager";

    dic_ordertype_amontrule = {};

    /**
     * 生成用户列表
     *
     * @param grid_selectorId
     * @param pager_selectorId
     */
    dic_ordertype_amontrule.generateGrid = function (grid_selectorId, pager_selectorId) {
        var grid_selector = grid_selectorId;
        var pager_selector = pager_selectorId;
        var param = {
            url: G_webrootPath + "/service/page/dictionary/serviceOrderRule?typeid=" + typeid,
            editurl: G_webrootPath + "/service/page/dictionary/serviceOrderRule?cmd=amontrule&typeid=" + typeid,
            postData: {
                cmd: "amontrule"
            },
            needFilter: true,
            filter: {
                searchOnEnter: null
            },
            multiselect: true,
            height: 248,
            sortname: "sort",
            colNames: ['编辑', 'id', '名称', '类型', '计算方式', '计算模式', '基数类型', '计算参数', '最小值', '最大值', '分解类型', '小数处理', '计算序号', '阶梯规则', '修改时间', 'authloginno', 'authpassword'],
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
                name: 'ruletype', index: 'ruletype',
                align: 'center',
                editable: true,
                editrules: {
                    required: true
                },
                edittype: 'select',
                formatter: 'select',
                stype: "select",
                editoptions: {
                    value: ":;1:订单额;2:订单金额;3:差额;4:扩展额1;5:扩展额2;6:扩展额3;7:扩展额4;8:扩展额5;9:扩展额6;10:扩展额7;11:扩展额8;12:扩展额9;13:扩展额10"
                },
                width: 95,
                fixed: true
            }, {
                name: 'calculatetype', index: 'calculatetype',
                align: 'center',
                editable: true,
                editrules: {
                    required: true
                },
                edittype: 'select',
                formatter: 'select',
                stype: "select",
                editoptions: {
                    value: ":;1:定额;2:比例;3:阶梯;4:满减;5:余额;6:订单额"
                },
                width: 80,
                fixed: true
            }, {
                name: 'calculatemode', index: 'calculatemode',
                align: 'center',
                editable: true,
                editrules: {
                    required: true
                },
                edittype: 'select',
                formatter: 'select',
                stype: "select",
                editoptions: {
                    value: ":;1:计算;2:兑换"
                },
                width: 70,
                fixed: true
            }, {
                name: 'basictype', index: 'basictype',
                align: 'center',
                editable: true,
                editrules: {
                    required: true,
                    number: true,
                    minValue: -1
                },
                edittype: 'text',
                width: 70,
                fixed: true
            }, {
                name: 'param', index: 'param',
                align: 'center',
                editable: true,
                editrules: {
                    required: true,
                    number: true
                },
                edittype: 'text',
                width: 70,
                fixed: true
            }, {
                name: 'min', index: 'min',
                align: 'center',
                editable: true,
                editrules: {
                    required: true,
                    number: true
                },
                edittype: 'text',
                width: 60,
                fixed: true
            }, {
                name: 'max', index: 'max',
                align: 'center',
                editable: true,
                editrules: {
                    required: true,
                    number: true
                },
                edittype: 'text',
                width: 60,
                fixed: true
            }, {
                name: 'decomposetype', index: 'decomposetype',
                align: 'center',
                editable: true,
                editrules: {
                    required: true
                },
                edittype: 'select',
                formatter: 'select',
                stype: "select",
                editoptions: {
                    value: ':;1:价外;2:价内'
                },
                width: 70,
                fixed: true
            }, {
                name: 'decimalprocess', index: 'decimalprocess',
                align: 'center',
                editable: true,
                editrules: {
                    required: true
                },
                edittype: 'select',
                formatter: 'select',
                stype: "select",
                editoptions: {
                    value: ':;1:入;2:舍;3:正无穷大;4:负无穷大;5:四舍五入;6:五舍六入;7:银行家舍入'
                },
                width: 110,
                fixed: true
            }, {
                name: 'sort', index: 'sort',
                align: 'center',
                editable: true,
                editrules: {
                    required: true,
                    number: true,
                    minValue: 0
                },
                edittype: 'text',
                width: 70,
                fixed: true
            }, {
                name: 'steprule', index: 'steprule',
                formatter: function (cellvalue, options, rowObject) {
                    var temp = "";
                    if (cellvalue == "1") {
                        temp = "<div class='bolder grid-form-field-div align-center width-100'><a href='javascript:void(0);' class='blue' " +
                            "onclick='dic_ordertype_amontrule.configStepRule(\"" + rowObject.id + "\")'>修改</a></div>";
                    } else if (cellvalue == "0") {
                        temp = "<div class='bolder grid-form-field-div align-center width-100'><a href='javascript:void(0);' class='red' " +
                            "onclick='dic_ordertype_amontrule.configStepRule(\"" + rowObject.id + "\")'>设置</a></div>";
                    }
                    return temp;
                },
                width: 70,
                fixed: true
            }, {
                name: 'modifydate', index: 'modifydate',
                align: 'center',
                fixed: true,
                width: 80
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
                del: true,
                search: true,
                refresh: true
            },
            inlineNav: {
                add: true
            }
        });
    };

    dic_ordertype_amontrule.configStepRule = function (amontruleid) {
        AUI.dialog.inDialog(950, 500, "订单发生额阶梯分解规则", {
            innerUrl: G_webrootPath + "/view/page/dictionary/ordertypeamontrulesteprule?amontruleid=" + amontruleid
        }, null, function (rtn) {
            AUI.grid.refreshGrid(grid_selectorId);
        });
    };

    $(function () {
        typeid = $("#dic_ordertype_amontrule_typeid").val();
        dic_ordertype_amontrule.generateGrid(grid_selectorId, pager_selectorId);
    });
})($);