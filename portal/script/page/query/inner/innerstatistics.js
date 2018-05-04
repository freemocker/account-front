/**
 * Created by zhangbin on 2017/5/15.
 */
(function ($) {

    var grid_selectorId = "innerstatistics_grid_table";
    var pager_selectorId = "innerstatistics_grid_pager";

    innerstatistics = {};

    /**
     * 生成列表
     *
     * @param grid_selectorId
     * @param pager_selectorId
     */
    innerstatistics.generateGrid = function (grid_selectorId, pager_selectorId) {
        var grid_selector = grid_selectorId;
        var pager_selector = pager_selectorId;
        var param = {
            url: G_webrootPath + "/service/page/query/inner/serviceInnerstatistics",
            postData: {
                search_businessid: function () {
                    return $("#innerstatistics_query_businessid").val();
                },
                search_innerid: function () {
                    return $("#innerstatistics_query_innerid").val();
                },
                search_accountdate: function () {
                    return $("#innerstatistics_query_accountdate").val();
                }
            },
            height: 290,
            sortname: "accountdate",
            sortorder: "desc",
            colNames: ['id', 'B户客户号', '内部账号', '一级科目', '二级科目', '三级科目', '科目账户', '上日余额', '借方额', '贷方额', '余额', '会计日期'],
            colModel: [{
                name: 'id', index: 'id', hidden: true
            }, {
                name: 'businessid',
                index: 'businessid',
                align: 'center',
                fixed: true,
                width: 220
            }, {
                name: 'innerid',
                index: 'innerid',
                align: 'center'
            }, {
                name: 'accountitemfirstname',
                index: 'accountitemfirstname',
                align: 'center'
            }, {
                name: 'accountitemsecdname',
                index: 'accountitemsecdname',
                align: 'center'
            }, {
                name: 'accountitemthirdname',
                index: 'accountitemthirdname',
                align: 'center'
            }, {
                name: 'accountsubitemname',
                index: 'accountsubitemname',
                align: 'center'
            }, {
                name: 'prevbalance',
                index: 'prevbalance',
                align: 'center',
                sortable: false,
                fixed: true,
                width: 80
            }, {
                name: 'amontdebit',
                index: 'amontdebit',
                align: 'center',
                sortable: false,
                fixed: true,
                width: 80
            }, {
                name: 'amontcredit',
                index: 'amontcredit',
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
                name: 'accountdate',
                index: 'accountdate',
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
    innerstatistics.initEvent = function () {
        AUI.element.initDatePicker("innerstatistics_query_accountdate");
        $("#innerstatistics_reset_btn").click(function () {
            $("#innerstatistics_conditionform")[0].reset();
        });
        $("#innerstatistics_query_btn").click(function () {
            if ($("#innerstatistics_query_accountdate").val() == "") {
                AUI.dialog.alert("请输入统计的会计日期！", null, 3);
                return;
            }
            AUI.grid.refreshGrid(grid_selectorId, true);
        });
    };

    $(function () {
        innerstatistics.generateGrid(grid_selectorId, pager_selectorId);
        innerstatistics.initEvent();
    });
})($);
