/**
 * Created by zhangbin on 2016/10/25.
 */
(function ($) {

    var typeid = "";
    var statusstr = "";
    var businessesstr = "";
    var paytypestr = "";
    var accountsubitemstr = "";
    var amontdetailstr = "";
    var grid_selectorId = "dic_ordertype_subjectrule_grid_table";
    var pager_selectorId = "dic_ordertype_subjectrule_grid_pager";

    /**
     * 生成用户列表
     *
     * @param grid_selectorId
     * @param pager_selectorId
     */
    function generateGrid(grid_selectorId, pager_selectorId) {
        var grid_selector = grid_selectorId;
        var pager_selector = pager_selectorId;
        var param = {
            url: G_webrootPath + "/service/page/dictionary/serviceOrderRule?typeid=" + typeid,
            editurl: G_webrootPath + "/service/page/dictionary/serviceOrderRule?cmd=subjectrule&typeid=" + typeid,
            postData: {
                cmd: "subjectrule"
            },
            needFilter: true,
            filter: {
                searchOnEnter: null
            },
            multiselect: true,
            height: 248,
            sortname: "oldstatus",
            colNames: ['编辑', 'id', '订单原状态', '订单目标状态', '记账会计主体', 'B类账户', '发生额', '交易类型', '会计科目', '余额方向', 'authloginno', 'authpassword'],
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
                name: 'oldstatus', index: 'oldstatus',
                align: 'center',
                editable: true,
                editrules: {
                    required: true
                },
                edittype: 'select',
                formatter: 'select',
                stype: "select",
                editoptions: {
                    value: statusstr
                },
                width: 110,
                fixed: true
            }, {
                name: 'newstatus', index: 'newstatus',
                align: 'center',
                editable: true,
                editrules: {
                    required: true
                },
                edittype: 'select',
                formatter: 'select',
                stype: "select",
                editoptions: {
                    value: statusstr
                },
                width: 110,
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
                    value: ':;0:账务平台;1:B类账户;2:目标B类账户'
                },
                width: 120,
                fixed: true
            }, {
                name: 'businessid', index: 'businessid',
                align: 'center',
                editable: true,
                editrules: {
                    required: true
                },
                edittype: 'select',
                formatter: 'select',
                stype: "select",
                editoptions: {
                    value: businessesstr
                }
            }, {
                name: 'amontruleid', index: 'amontruleid',
                align: 'center',
                editable: true,
                editrules: {
                    required: true
                },
                edittype: 'select',
                formatter: 'select',
                stype: "select",
                editoptions: {
                    value: amontdetailstr
                },
                fixed: true,
                width: 150
            }, {
                name: 'paytypecode', index: 'paytypecode',
                align: 'center',
                editable: true,
                edittype: 'select',
                formatter: 'select',
                stype: "select",
                editoptions: {
                    value: paytypestr
                },
                width: 140,
                fixed: true
            }, {
                name: 'accountsubitemid', index: 'accountsubitemid',
                align: 'center',
                editable: true,
                editrules: {
                    required: true
                },
                edittype: 'select',
                formatter: 'select',
                stype: "select",
                editoptions: {
                    value: accountsubitemstr
                }
            }, {
                name: 'balancedirect', index: 'balancedirect',
                align: 'center',
                editable: true,
                editrules: {
                    required: true
                },
                edittype: 'select',
                formatter: 'select',
                stype: "select",
                editoptions: {
                    value: ':;1:借;2:贷'
                },
                width: 70,
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
    }

    $(function () {
        typeid = $("#dic_ordertype_subjectrule_typeid").val();
        statusstr = $("#dic_ordertype_subjectrule_statusstr").val();
        businessesstr = $("#dic_ordertype_balancerule_businessesstr").val();
        paytypestr = $("#dic_ordertype_subjectrule_paytypestr").val();
        accountsubitemstr = $("#dic_ordertype_subjectrule_accountsubitemstr").val();
        amontdetailstr = $("#dic_ordertype_subjectrule_amontdetailstr").val();
        generateGrid(grid_selectorId, pager_selectorId);
    });
})($);