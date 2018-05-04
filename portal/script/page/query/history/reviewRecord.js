/**
 * Created by zhangbin on 2016/10/14.
 */
(function ($) {

    var grid_selectorId = "his_orderReviewRecord_grid_table";
    var pager_selectorId = "his_orderReviewRecord_grid_pager";

    his_orderReviewRecord = {};

    /**
     * 生成订单列表
     *
     * @param grid_selectorId
     * @param pager_selectorId
     */
    his_orderReviewRecord.generateGrid = function (grid_selectorId, pager_selectorId) {
        var grid_selector = grid_selectorId;
        var pager_selector = pager_selectorId;
        var param = {
            url: G_webrootPath + "/service/page/query/history/serviceReviewRecord",
            postData: {
                search_orderno: function () {
                    return $("#his_orderReviewRecord_query_orderno").val();
                },
                search_result: function () {
                    return $("#his_orderReviewRecord_query_result").val();
                },
                search_start: function () {
                    return $("#his_orderReviewRecord_query_date_start").val();
                },
                search_end: function () {
                    return $("#his_orderReviewRecord_query_date_end").val();
                }
            },
            height: 290,
            sortname: "reviewdate",
            sortorder: "desc",
            colNames: ['id', '审核时间', '会计日期', '订单号', '审核结果', '审核内容', '审核人'],
            colModel: [{
                name: 'id',
                index: 'id',
                hidden: true
            }, {
                name: 'reviewdate',
                index: 'reviewdate',
                align: 'center',
                fixed: true,
                width: 80
            }, {
                name: 'accountdate',
                index: 'accountdate',
                sortable: false,
                align: 'center',
                fixed: true,
                width: 80
            }, {
                name: 'orderno',
                index: 'orderno',
                align: 'center',
                sortable: false,
                fixed: true,
                width: 190
            }, {
                name: 'result',
                index: 'result',
                align: 'center',
                formatter: function (cellvalue, options, rowObject) {
                    var temp = "";
                    if (cellvalue == "1") {
                        temp = "<div class='green bolder grid-form-field-div align-center width-100'>通过</div>";
                    } else {
                        temp = "<div class='red bolder grid-form-field-div align-center width-100'>不通过</div>";
                    }
                    return temp;
                },
                sortable: false,
                fixed: true,
                width: 80
            }, {
                name: 'content',
                index: 'content',
                sortable: false
            }, {
                name: 'username',
                index: 'username',
                align: 'center',
                sortable: false,
                fixed: true,
                width: 80
            }]
        };
        AUI.grid.generateGrid(grid_selector, pager_selector, param);
    };

    /**
     * 绑定事件
     */
    his_orderReviewRecord.initEvent = function () {
        AUI.element.initDatePicker("his_orderReviewRecord_query_date_start");
        AUI.element.initDatePicker("his_orderReviewRecord_query_date_end");
        $("#his_orderReviewRecord_reset_btn").click(function () {
            $("#his_orderReviewRecord_conditionform")[0].reset();
        });
        $("#his_orderReviewRecord_query_btn").click(function () {
            if ($("#his_orderReviewRecord_query_date_start").val() == "") {
                AUI.dialog.alert("请输入时间范围！", null, 3);
                return;
            }
            if ($("#his_orderReviewRecord_query_date_end").val() == "") {
                AUI.dialog.alert("请输入时间范围！", null, 3);
                return;
            }
            AUI.grid.refreshGrid(grid_selectorId, true);
        });
    };

    $(function () {
        his_orderReviewRecord.generateGrid(grid_selectorId, pager_selectorId);
        his_orderReviewRecord.initEvent();
    });
})($);