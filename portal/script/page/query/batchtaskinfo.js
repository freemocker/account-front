/**
 * Created by zhangbin on 2017/5/13.
 */
(function ($) {

    var grid_selectorId = "query_batchtaskinfo_grid_table";
    var pager_selectorId = "query_batchtaskinfo_grid_pager";

    var excuteable = $("#query_batchtaskinfo_excuteable").val();

    query_batchtaskinfo = {};

    /**
     * 生成列表
     *
     * @param grid_selectorId
     * @param pager_selectorId
     */
    query_batchtaskinfo.generateGrid = function (grid_selectorId, pager_selectorId) {
        var grid_selector = grid_selectorId;
        var pager_selector = pager_selectorId;
        var colNames, colModel;
        if (excuteable === 'true') {
            colNames = ['id', '执行', '序号', '任务名称', '任务类名', '状态', '状态', '会计日期', '情况描述'];
            colModel = [{
                name: 'id', index: 'id', hidden: true
            }, {
                name: 'excute',
                index: 'excute',
                align: 'center',
                classes: 'jqgrid config-btn row-td',
                sortable: false,
                fixed: true,
                width: 40,
                formatter: function (cellvalue, options, rowObject) {
                    return "<button type=\"button\" class=\"btn btn-minier btn-danger\" onclick=\"query_batchtaskinfo.excuteTask('" + rowObject.taskclassname + "','" + rowObject.accountdate + "'," + rowObject.status + ")\"><i class=\"ace-icon fa fa-bolt icon-only bigger-110\"></i></button>";
                }
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
            }];
        } else {
            colNames = ['id', '序号', '任务名称', '任务类名', '状态', '状态', '会计日期', '情况描述'];
            colModel = [{
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
            }];
        }
        var param = {
            url: G_webrootPath + "/service/page/query/serviceBatchtaskinfo",
            postData: {
                search_taskname: function () {
                    return $("#query_batchtaskinfo_query_taskname").val();
                },
                search_taskclassname: function () {
                    return $("#query_batchtaskinfo_query_taskclassname").val();
                },
                search_status: function () {
                    return $("#query_batchtaskinfo_query_status").val();
                },
                search_account: function () {
                    return $("#query_batchtaskinfo_query_accountdate").val();
                }
            },
            multiselect: false,
            height: 290,
            sortname: "accountdate",
            sortorder: "desc",
            colNames: colNames,
            colModel: colModel
        };
        AUI.grid.generateGrid(grid_selector, pager_selector, param);
    };

    /**
     * 手动执行批量任务
     * @param taskclassname 任务类名
     * @param accountdate 会计日期
     * @param status 状态
     */
    query_batchtaskinfo.excuteTask = function (taskclassname, accountdate, status) {
        if (status > -1) {
            AUI.dialog.alert("失败的批量任务才允许手动执行！", null, 3);
            return;
        }
        portal_tools_obj.showAuthDialog(function (authdata) {
            var body = {
                data: {
                    accountdate: accountdate,
                    taskclassname: taskclassname,
                    authloginno: authdata.authloginno,
                    authpassword: authdata.authpassword
                }
            };
            portal_tools_obj.doAjaxToServer("back_1003", {
                service: {
                    action: "batchtask_excute"
                }
            }, body, function (data) {
                if (data.errmsg) {
                    AUI.dialog.alert(data.errmsg, null, 3);
                } else {
                    AUI.dialog.alert("操作成功", function () {
                        $("#query_batchtaskinfo_query_btn").click();
                    }, 1);
                }
            });
        });
    };

    /**
     * 绑定事件
     */
    query_batchtaskinfo.initEvent = function () {
        AUI.element.initDatePicker("query_batchtaskinfo_query_accountdate");
        $("#query_batchtaskinfo_reset_btn").click(function () {
            $("#query_batchtaskinfo_conditionform")[0].reset();
        });
        $("#query_batchtaskinfo_query_btn").click(function () {
            AUI.grid.refreshGrid(grid_selectorId, true);
        });
    };

    $(function () {
        query_batchtaskinfo.generateGrid(grid_selectorId, pager_selectorId);
        query_batchtaskinfo.initEvent();
    });
})($);