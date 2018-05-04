/**
 * Created by zhangbin on 2016/11/18.
 */
(function ($) {

    var tablename = "acc_batch_histables";
    var grid_selectorId = "dic_histables_grid_table";
    var pager_selectorId = "dic_histables_grid_pager";

    dic_histables = {};

    /**
     * 生成列表
     *
     * @param grid_selectorId
     * @param pager_selectorId
     */
    dic_histables.generateGrid = function (grid_selectorId, pager_selectorId) {
        var grid_selector = grid_selectorId;
        var pager_selector = pager_selectorId;
        var param = {
            url: G_webrootPath + "/service/page/dictionary/serviceDictionary?tablename=" + tablename,
            editurl: G_webrootPath + "/service/page/dictionary/serviceDictionary?tablename=" + tablename,
            postData: {
                search_parentid: function () {
                    return $("#dic_histables_query_parentid").val();
                },
                search_code: function () {
                    return $("#dic_histables_query_code").val();
                }
            },
            multiselect: false,
            height: 290,
            sortname: "code",
            colNames: ['id', '原数据源编号', '原数据库名称', '原数据表名称', '历史数据源编号', '历史数据库名称', '历史数据表名称'],
            colModel: [{
                name: 'id', index: 'id',
                hidden: true
            }, {
                name: 'type', index: 'type', align: 'center', width: 100, fixed: true
            }, {
                name: 'parent', index: 'parent', align: 'center', width: 150, fixed: true
            }, {
                name: 'parentid', index: 'parentid'
            }, {
                name: 'remark', index: 'remark', align: 'center', width: 110, fixed: true
            }, {
                name: 'name', index: 'name', align: 'center', width: 150, fixed: true
            }, {
                name: 'code', index: 'code'
            }]
        };
        AUI.grid.generateGrid(grid_selector, pager_selector, param);
    };

    /**
     * 绑定事件
     */
    dic_histables.initEvent = function () {
        $("#dic_histables_reset_btn").click(function () {
            $("#dic_histables_conditionform")[0].reset();
        });
        $("#dic_histables_query_btn").click(function () {
            AUI.grid.refreshGrid(grid_selectorId, true);
        });
    };

    $(function () {
        dic_histables.generateGrid(grid_selectorId, pager_selectorId);
        dic_histables.initEvent();
    });
})($);