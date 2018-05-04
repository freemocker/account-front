/**
 * Created by zhangbin on 2017/5/15.
 */
(function ($) {

    var grid_selectorId = "customermonth_grid_table";
    var pager_selectorId = "customermonth_grid_pager";

    customermonth = {};

    /**
     * 生成列表
     *
     * @param grid_selectorId
     * @param pager_selectorId
     */
    customermonth.generateGrid = function (grid_selectorId, pager_selectorId) {
        var grid_selector = grid_selectorId;
        var pager_selector = pager_selectorId;
        var param = {
            url: G_webrootPath + "/service/page/query/customer/serviceCustomer",
            postData: {
                searchType: "month",
                search_custid: function () {
                    return $("#customermonth_query_custid").val();
                },
                search_custsubaccountcode: function () {
                    return $("#customermonth_query_custsubaccountcode").val();
                },
                search_type: function () {
                    return $("#customermonth_query_type").val();
                },
                search_start: function () {
                    return $("#customermonth_query_date_start").val();
                },
                search_end: function () {
                    return $("#customermonth_query_date_end").val();
                }
            },
            height: 290,
            sortname: "yearmonth",
            sortorder: "desc",
            colNames: ['id', 'C户客户号', '子账户账号', '子账户类型', '上月余额', '支出额', '收入额', '余额', '统计年月'],
            colModel: [{
                name: 'id', index: 'id', hidden: true
            }, {
                name: 'custid',
                index: 'custid',
                align: 'center',
                fixed: true,
                width: 220
            }, {
                name: 'custsubaccountcode',
                index: 'custsubaccountcode',
                align: 'center'
            }, {
                name: 'typename',
                index: 'typename',
                align: 'center',
                fixed: true,
                width: 100
            }, {
                name: 'prevbalance',
                index: 'prevbalance',
                align: 'center',
                sortable: false,
                fixed: true,
                width: 80
            }, {
                name: 'amontexpend',
                index: 'amontexpend',
                align: 'center',
                sortable: false,
                fixed: true,
                width: 80
            }, {
                name: 'amontrevenue',
                index: 'amontrevenue',
                align: 'center',
                sortable: false,
                fixed: true,
                width: 80
            }, {
                name: 'balance',
                index: 'balance',
                align: 'center',
                sortable: false,
                fixed: true,
                width: 80
            }, {
                name: 'yearmonth',
                index: 'yearmonth',
                align: 'center',
                fixed: true,
                width: 80
            }]
        };
        AUI.grid.generateGrid(grid_selector, pager_selector, param);
    };

    /**
     * 绑定事件
     */
    customermonth.initEvent = function () {
        AUI.element.initDatePicker("customermonth_query_date_start", {
            minViewMode: 'months',
            format: 'yyyy-mm'
        });
        AUI.element.initDatePicker("customermonth_query_date_end", {
            minViewMode: 'months',
            format: 'yyyy-mm'
        });
        $("#customermonth_reset_btn").click(function () {
            $("#customermonth_conditionform")[0].reset();
        });
        $("#customermonth_query_btn").click(function () {
            if ($("#customermonth_query_date_start").val() == "") {
                AUI.dialog.alert("请输入年月范围！", null, 3);
                return;
            }
            if ($("#customermonth_query_date_end").val() == "") {
                AUI.dialog.alert("请输入年月范围！", null, 3);
                return;
            }
            AUI.grid.refreshGrid(grid_selectorId, true);
        });
    };

    $(function () {
        customermonth.generateGrid(grid_selectorId, pager_selectorId);
        customermonth.initEvent();
    });
})($);
