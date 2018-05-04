/**
 * Created by zhangbin on 2017/5/12.
 */
(function ($) {

    var grid_selectorId = "internaltradeReview_grid_table";
    var pager_selectorId = "internaltradeReview_grid_pager";

    function addAmontAttr(rowId, val, rawObject, cm, rdata) {
        return "style='color:red'";
    }

    internaltradeReview = {};

    /**
     * 生成订单列表
     *
     * @param grid_selectorId
     * @param pager_selectorId
     */
    internaltradeReview.generateGrid = function (grid_selectorId, pager_selectorId) {
        var grid_selector = grid_selectorId;
        var pager_selector = pager_selectorId;
        var param = {
            url: G_webrootPath + "/service/page/review/serviceInternaltrade",
            postData: {
                search_orderno: function () {
                    return $("#internaltradeReview_query_orderno").val();
                },
                search_tradetype: function () {
                    return $("#internaltradeReview_query_tradetype").val();
                },
                search_businessid: function () {
                    return $("#internaltradeReview_query_businessid").val();
                },
                search_custid: function () {
                    return $("#internaltradeReview_query_custid").val();
                }
            },
            height: 290,
            sortname: "createdate",
            sortorder: "asc",
            colNames: ['审核', '交易类型', '订单号', '交易额', 'B户客户号', 'C户客户号', '提交时间'],
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
                            + "onclick=\"internaltradeReview.editRecord('"
                            + rowObject.orderno
                            + "');\" "
                            + "onmouseover=\"$(this).addClass('ui-state-hover');\" "
                            + "onmouseout=\"$(this).removeClass('ui-state-hover')\">"
                            + "<span class=\"ui-icon ui-icon-pencil\"></span></div>";
                    }
                },
                {
                    name: 'tradetypename',
                    index: 'tradetypename',
                    align: 'center',
                    sortable: false,
                    fixed: true,
                    width: 100
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
                    sortable: false
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
                    name: 'custid',
                    index: 'custid',
                    align: 'center',
                    sortable: false,
                    fixed: true,
                    width: 210
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
    internaltradeReview.initEvent = function () {
        $("#internaltradeReview_reset_btn").click(function () {
            $("#internaltradeReview_conditionform")[0].reset();
        });
        $("#internaltradeReview_query_btn").click(function () {
            AUI.grid.refreshGrid(grid_selectorId, true);
        });
    };

    /**
     * 审核
     */
    internaltradeReview.editRecord = function (orderno) {
        AUI.dialog.inDialog("max", "max", "特殊交易订单审核", {
            innerUrl: G_webrootPath + "/view/page/review/internaltradeInfo?orderno=" + orderno,
            fullscreen: true
        }, null, function (rtn) {
            AUI.grid.refreshGrid(grid_selectorId);
        });
    };

    $(function () {
        internaltradeReview.generateGrid(grid_selectorId, pager_selectorId);
        internaltradeReview.initEvent();
    });
})($);