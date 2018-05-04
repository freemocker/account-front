/**
 * Created by zhangbin on 2017/5/12.
 */
(function ($) {

    var grid_selectorId = "balanceSettlementReview_grid_table";
    var pager_selectorId = "balanceSettlementReview_grid_pager";

    function addAmontAttr(rowId, val, rawObject, cm, rdata) {
        return "style='color:red'";
    }

    balanceSettlementReview = {};

    /**
     * 生成订单列表
     *
     * @param grid_selectorId
     * @param pager_selectorId
     */
    balanceSettlementReview.generateGrid = function (grid_selectorId, pager_selectorId) {
        var grid_selector = grid_selectorId;
        var pager_selector = pager_selectorId;
        var param = {
            url: G_webrootPath + "/service/page/review/serviceBalanceSettlement",
            postData: {
                search_orderno: function () {
                    return $("#balanceSettlementReview_query_orderno").val();
                },
                search_businessid: function () {
                    return $("#balanceSettlementReview_query_businessid").val();
                }
            },
            height: 290,
            sortname: "createdate",
            sortorder: "asc",
            colNames: ['审核', '订单号', '结算金额', 'B户客户号', 'B户名称', '渠道号', '提交时间'],
            colModel: [
                {
                    name: 'myac',
                    index: '',
                    width: 40,
                    fixed: true,
                    sortable: false,
                    align: 'center',
                    formatter: function (cellvalue, options, rowObject) {
                        return "<div style=\"margin-left:8px;\">"
                            + "<div title=\"审核订单详情\" style=\"float:left;cursor:pointer;\" class=\"ui-pg-div ui-inline-edit\" "
                            + "onclick=\"balanceSettlementReview.editRecord('"
                            + rowObject.orderno
                            + "');\" "
                            + "onmouseover=\"$(this).addClass('ui-state-hover');\" "
                            + "onmouseout=\"$(this).removeClass('ui-state-hover')\">"
                            + "<span class=\"ui-icon ui-icon-pencil\"></span></div>";
                    }
                },
                {
                    name: 'orderno',
                    index: 'orderno',
                    align: 'center',
                    sortable: false,
                    fixed: true,
                    width: 190
                },
                {
                    name: 'amont',
                    index: 'amont',
                    align: 'center',
                    cellattr: addAmontAttr,
                    sortable: false,
                    fixed: true,
                    width: 150
                },
                {
                    name: 'businessid',
                    index: 'businessid',
                    align: 'center',
                    sortable: false,
                    fixed: true,
                    width: 210
                },
                {
                    name: 'businessname',
                    index: 'businessname',
                    align: 'center',
                    sortable: false
                },
                {
                    name: 'channel',
                    index: 'channel',
                    align: 'center',
                    sortable: false,
                    fixed: true,
                    width: 125
                },
                {
                    name: 'createdate',
                    index: 'createdate',
                    align: 'center',
                    fixed: true,
                    width: 140
                }]
        };
        AUI.grid.generateGrid(grid_selector, pager_selector, param);
    };

    /**
     * 绑定事件
     */
    balanceSettlementReview.initEvent = function () {
        $("#balanceSettlementReview_reset_btn").click(function () {
            $("#balanceSettlementReview_conditionform")[0].reset();
        });
        $("#balanceSettlementReview_query_btn").click(function () {
            AUI.grid.refreshGrid(grid_selectorId, true);
        });
    };

    /**
     * 审核
     */
    balanceSettlementReview.editRecord = function (orderno) {
        AUI.dialog.inDialog("max", "max", "B户余额结算订单审核", {
            innerUrl: G_webrootPath + "/view/page/review/balancesettlementInfo?orderno=" + orderno,
            fullscreen: true
        }, null, function (rtn) {
            AUI.grid.refreshGrid(grid_selectorId);
        });
    };

    $(function () {
        balanceSettlementReview.generateGrid(grid_selectorId, pager_selectorId);
        balanceSettlementReview.initEvent();
    });
})($);