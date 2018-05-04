/**
 * Created by zhangbin on 2016/10/25.
 */
(function ($) {

    var amontruleid = "";
    var grid_selectorId = "dic_ordertype_amontrule_steprule_grid_table";
    var pager_selectorId = "dic_ordertype_amontrule_steprule_grid_pager";

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
            url: G_webrootPath + "/service/page/dictionary/serviceOrderRule?amontruleid=" + amontruleid,
            editurl: G_webrootPath + "/service/page/dictionary/serviceOrderRule?cmd=steprule&amontruleid=" + amontruleid,
            postData: {
                cmd: "steprule"
            },
            needFilter: true,
            filter: {
                searchOnEnter: null
            },
            multiselect: true,
            height: 285,
            sortname: "beginamont",
            colNames: ['编辑', 'id', '开始额', '结束额', '计算方式', '计算参数', '修改时间', 'authloginno', 'authpassword'],
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
                name: 'beginamont', index: 'beginamont',
                align: 'center',
                editable: true,
                editrules: {
                    required: true,
                    number: true,
                    minValue: 0
                },
                edittype: 'text'
            }, {
                name: 'endamont', index: 'endamont',
                align: 'center',
                editable: true,
                editrules: {
                    number: true,
                    minValue: 0
                },
                edittype: 'text'
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
                    value: ":;1:定额;2:比例"
                },
                width: 90,
                fixed: true
            }, {
                name: 'param', index: 'param',
                align: 'center',
                editable: true,
                editrules: {
                    required: true,
                    number: true
                },
                edittype: 'text'
            }, {
                name: 'modifydate', index: 'modifydate',
                align: 'center',
                fixed: true,
                width: 140
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
        amontruleid = $("#dic_ordertype_amontrule_steprule_amontruleid").val();
        generateGrid(grid_selectorId, pager_selectorId);
    });
})($);