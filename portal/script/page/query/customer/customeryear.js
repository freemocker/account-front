/**
 * Created by zhangbin on 2017/5/15.
 */
(function ($) {

    var grid_selectorId = "customeryear_grid_table";
    var pager_selectorId = "customeryear_grid_pager";

    customeryear = {};

    /**
     * 生成列表
     *
     * @param grid_selectorId
     * @param pager_selectorId
     */
    customeryear.generateGrid = function (grid_selectorId, pager_selectorId) {
        var grid_selector = grid_selectorId;
        var pager_selector = pager_selectorId;
        var param = {
            url: G_webrootPath + "/service/page/query/customer/serviceCustomer",
            postData: {
                searchType: "year",
                search_custid: function () {
                    return $("#customeryear_query_custid").val();
                },
                search_custsubaccountcode: function () {
                    return $("#customeryear_query_custsubaccountcode").val();
                },
                search_type: function () {
                    return $("#customeryear_query_type").val();
                },
                search_start: function () {
                    return $("#customeryear_query_date_start").val();
                }
            },
            height: 290,
            sortname: "createdate",
            sortorder: "desc",
            colNames: ['id', 'C户客户号', '子账户账号', '子账户类型', '上年余额', '支出额', '收入额', '余额', '统计年', '创建时间'],
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
                name: 'year',
                index: 'year',
                align: 'center',
                fixed: true,
                width: 80
            }, {
                name: 'createdate',
                index: 'createdate',
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
    customeryear.initEvent = function () {
        AUI.element.initDatePicker("customeryear_query_date_start", {
            minViewMode: 'years',
            format: 'yyyy'
        });
        $("#customeryear_reset_btn").click(function () {
            $("#customeryear_conditionform")[0].reset();
        });
        $("#customeryear_query_btn").click(function () {
            if ($("#customeryear_query_date_start").val() == "") {
                AUI.dialog.alert("请输入统计年份！", null, 3);
                return;
            }
            AUI.grid.refreshGrid(grid_selectorId, true);
        });
    };

    $(function () {
        customeryear.generateGrid(grid_selectorId, pager_selectorId);
        customeryear.initEvent();
    });
})($);
