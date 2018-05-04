/**
 * Created by zhangbin on 2016/10/21.
 */
(function ($) {

    var typeid = "";
    var statusstr = "";
    var accounttypestr = "";
    var amontdetailstr = "";
    var businessesstr = "";
    var grid_selectorId = "dic_ordertype_balancerule_grid_table";
    var pager_selectorId = "dic_ordertype_balancerule_grid_pager";

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
            editurl: G_webrootPath + "/service/page/dictionary/serviceOrderRule?cmd=balancerule&typeid=" + typeid,
            postData: {
                cmd: "balancerule"
            },
            needFilter: true,
            filter: {
                searchOnEnter: null
            },
            multiselect: true,
            height: 248,
            sortname: "oldstatus",
            colNames: ['编辑', 'id', '订单原状态', '订单目标状态', '变更账户类型', "B类账户", '虚拟账户类型编码', '发生额', '变动', '修改时间', 'authloginno', 'authpassword'],
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
                    value: ':;0:账务平台;1:B类账户;2:目标B类账户;3:C类账户;4:目标C类账户'
                },
                width: 120,
                fixed: true
            }, {
                name: 'businessid', index: 'businessid',
                align: 'center',
                editable: true,
                edittype: 'select',
                formatter: 'select',
                stype: "select",
                editoptions: {
                    value: businessesstr
                }
            }, {
                name: 'accounttype', index: 'accounttype',
                align: 'center',
                editable: true,
                editrules: {
                    required: true
                },
                edittype: 'select',
                formatter: 'select',
                stype: "select",
                editoptions: {
                    value: accounttypestr
                },
                width: 120,
                fixed: true
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
                width: 160
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
                    value: ':;1:加;2:减'
                },
                width: 75,
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
    }

    $(function () {
        typeid = $("#dic_ordertype_balancerule_typeid").val();
        statusstr = $("#dic_ordertype_balancerule_statusstr").val();
        accounttypestr = $("#dic_ordertype_balancerule_accounttypestr").val();
        amontdetailstr = $("#dic_ordertype_balancerule_amontdetailstr").val();
        businessesstr = $("#dic_ordertype_balancerule_businessesstr").val();
        generateGrid(grid_selectorId, pager_selectorId);
    });
})($);