/**
 * Created by zhangbin on 2016/10/13.
 */
(function ($) {

    var grid_selectorId = "custAccountMng_grid_table";
    var pager_selectorId = "custAccountMng_grid_pager";

    custAccountMng = {};

    /**
     * 生成B户列表
     *
     * @param grid_selectorId
     * @param pager_selectorId
     */
    custAccountMng.generateGrid = function (grid_selectorId, pager_selectorId) {
        var grid_selector = grid_selectorId;
        var pager_selector = pager_selectorId;
        var param = {
            url: G_webrootPath + "/service/page/account/serviceCustAccount",
            postData: {
                cmd: "account",
                search_custid: function () {
                    return $("#custAccountMng_query_custid").val();
                },
                search_telephone: function () {
                    return $("#custAccountMng_query_telephone").val();
                },
                search_channel: function () {
                    return $("#custAccountMng_query_channel").val();
                },
                search_status: function () {
                    return $("#custAccountMng_query_status").val();
                }
            },
            height: 290,
            sortname: "createdate,channel,custid,status",
            sortorder: "desc",
            colNames: ['编辑', 'userid', '客户号', '电话号码', '昵称', '姓名', '注册渠道号', '创建时间', '状态'],
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
                            + "<div title=\"查看客户详细信息\" style=\"float:left;cursor:pointer;\" class=\"ui-pg-div ui-inline-edit\" "
                            + "onclick=\"custAccountMng.editRecord('"
                            + rowObject.custid
                            + "');\" "
                            + "onmouseover=\"$(this).addClass('ui-state-hover');\" "
                            + "onmouseout=\"$(this).removeClass('ui-state-hover')\">"
                            + "<span class=\"ui-icon ui-icon-pencil\"></span></div>";
                    }
                },
                {
                    name: 'userid',
                    index: 'userid',
                    hidden: true
                },
                {
                    name: 'custid',
                    index: 'custid',
                    align: 'center',
                    fixed: true,
                    width: 210
                },
                {
                    name: 'telephone',
                    index: 'telephone',
                    align: 'center',
                    fixed: true,
                    width: 100
                },
                {
                    name: 'nickname',
                    index: 'nickname'
                },
                {
                    name: 'name',
                    index: 'name'
                },
                {
                    name: 'channel',
                    index: 'channel',
                    align: 'center',
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
                    name: 'status',
                    index: 'status',
                    align: 'center',
                    fixed: true,
                    width: 60,
                    formatter: function (cellvalue, options, rowObject) {
                        var temp = "";
                        if (cellvalue == "1") {
                            temp = "<div class='green bolder grid-form-field-div align-center width-100'>激活</div>";
                        } else {
                            temp = "<div class='red bolder grid-form-field-div align-center width-100'>禁用</div>";
                        }
                        return temp;
                    }
                }]
        };
        AUI.grid.generateGrid(grid_selector, pager_selector, param);
    };

    /**
     * 绑定事件
     */
    custAccountMng.initEvent = function () {
        $("#custAccountMng_reset_btn").click(function () {
            $("#custAccountMng_conditionform")[0].reset();
        });
        $("#custAccountMng_query_btn").click(function () {
            AUI.grid.refreshGrid(grid_selectorId, true);
        });
    };

    /**
     * 编辑
     */
    custAccountMng.editRecord = function (custid) {
        AUI.dialog.inDialog("max", "max", "C类账户详细信息", {
            innerUrl: G_webrootPath + "/view/page/account/custAccountInfo?custid=" + custid,
            fullscreen: true
        }, null, function (rtn) {
            AUI.grid.refreshGrid(grid_selectorId);
        });
    };

    $(function () {
        custAccountMng.generateGrid(grid_selectorId, pager_selectorId);
        custAccountMng.initEvent();
    });
})($);