/**
 * Created by zhangbin on 2017/5/13.
 */
(function ($) {

    var grid_selectorId = "query_his_batchtaskinfo_grid_table";
    var pager_selectorId = "query_his_batchtaskinfo_grid_pager";

    query_his_batchtaskinfo = {};

    /**
     * 生成列表
     *
     * @param grid_selectorId
     * @param pager_selectorId
     */
    query_his_batchtaskinfo.generateGrid = function (grid_selectorId, pager_selectorId) {
        var grid_selector = grid_selectorId;
        var pager_selector = pager_selectorId;
        var param = {
            url: G_webrootPath + "/service/page/query/history/serviceBatchtaskinfo",
            postData: {
                search_taskname: function () {
                    return $("#query_his_batchtaskinfo_query_taskname").val();
                },
                search_taskclassname: function () {
                    return $("#query_his_batchtaskinfo_query_taskclassname").val();
                },
                search_status: function () {
                    return $("#query_his_batchtaskinfo_query_status").val();
                },
                search_account: function () {
                    return $("#query_his_batchtaskinfo_query_accountdate").val();
                }
            },
            multiselect: false,
            height: 290,
            sortname: "accountdate",
            sortorder: "desc",
            colNames: ['id', '序号', '任务名称', '任务类名', '状态', '状态', '会计日期', '情况描述'],
            colModel: [{
                name: 'id', index: 'id', hidden: true
            }, {
                name: 'taskno', index: 'taskno', align: 'center', width: 50, fixed: true
            }, {
                name: 'taskname', index: 'taskname', align: 'center', sortable: false
            }, {
                name: 'taskclassname', index: 'taskclassname', align: 'center', sortable: false
            }, {
                name: 'status', index: 'status', hidden: true
            }, {
                name: 'statusname', index: 'statusname', align: 'center', width: 60, fixed: true
            }, {
                name: 'accountdate', index: 'accountdate', align: 'center', width: 90, fixed: true
            }, {
                name: 'description', index: 'description', sortable: false
            }]
        };
        AUI.grid.generateGrid(grid_selector, pager_selector, param);
    };

    /**
     * 绑定事件
     */
    query_his_batchtaskinfo.initEvent = function () {
        AUI.element.initDatePicker("query_his_batchtaskinfo_query_accountdate");
        $("#query_his_batchtaskinfo_reset_btn").click(function () {
            $("#query_his_batchtaskinfo_conditionform")[0].reset();
        });
        $("#query_his_batchtaskinfo_query_btn").click(function () {
            AUI.grid.refreshGrid(grid_selectorId, true);
        });
    };

    $(function () {
        query_his_batchtaskinfo.generateGrid(grid_selectorId, pager_selectorId);
        query_his_batchtaskinfo.initEvent();
    });
})($);