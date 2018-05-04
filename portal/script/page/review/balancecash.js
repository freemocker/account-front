/**
 * Created by zhangbin on 2016/10/9.
 */
(function ($) {

    var grid_selectorId = "balanceCashReview_grid_table";
    var pager_selectorId = "balanceCashReview_grid_pager";

    function addAmontAttr(rowId, val, rawObject, cm, rdata) {
        return "style='color:red'";
    }

    balanceCashReview = {};

    /**
     * 生成订单列表
     *
     * @param grid_selectorId
     * @param pager_selectorId
     */
    balanceCashReview.generateGrid = function (grid_selectorId, pager_selectorId) {
        var grid_selector = grid_selectorId;
        var pager_selector = pager_selectorId;
        var param = {
            url: G_webrootPath + "/service/page/review/serviceBalancecash",
            postData: {
                search_orderno: function () {
                    return $("#balanceCashReview_query_orderno").val();
                },
                search_businesstradeno: function () {
                    return $("#balanceCashReview_query_businesstradeno").val();
                },
                search_channel: function () {
                    return $("#balanceCashReview_query_channel").val();
                },
                search_custid: function () {
                    return $("#balanceCashReview_query_custid").val();
                }
            },
            height: 290,
            sortname: "createdate",
            sortorder: "asc",
            colNames: ['审核', '订单号', '提现金额', 'C户客户号', '渠道号', '提交时间', '商户交易号'],
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
                            + "onclick=\"balanceCashReview.editRecord('"
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
                    width: 80
                },
                {
                    name: 'custid',
                    index: 'custid',
                    align: 'center',
                    sortable: false,
                    fixed: true,
                    width: 210
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
                },
                {
                    name: 'businesstradeno',
                    index: 'businesstradeno',
                    sortable: false
                }]
        };
        AUI.grid.generateGrid(grid_selector, pager_selector, param);
    };

    /**
     * 绑定事件
     */
    balanceCashReview.initEvent = function () {
        $("#balanceCashReview_reset_btn").click(function () {
            $("#balanceCashReview_conditionform")[0].reset();
        });
        $("#balanceCashReview_query_btn").click(function () {
            AUI.grid.refreshGrid(grid_selectorId, true);
        });
    };

    /**
     * 审核
     */
    balanceCashReview.editRecord = function (orderno) {
        AUI.dialog.inDialog("max", "max", "余额提现订单审核", {
            innerUrl: G_webrootPath + "/view/page/review/balancecashInfo?orderno=" + orderno,
            fullscreen: true
        }, null, function (rtn) {
            AUI.grid.refreshGrid(grid_selectorId);
        });
    };

    $(function () {
        balanceCashReview.generateGrid(grid_selectorId, pager_selectorId);
        balanceCashReview.initEvent();
    });
})($);