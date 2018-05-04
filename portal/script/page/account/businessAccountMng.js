/**
 * Created by zhang on 2016/8/15.
 */
(function ($) {

    var grid_selectorId = "businessAccountMng_grid_table";
    var pager_selectorId = "businessAccountMng_grid_pager";

    businessAccountMng = {};

    /**
     * 生成B户列表
     *
     * @param grid_selectorId
     * @param pager_selectorId
     */
    businessAccountMng.generateGrid = function (grid_selectorId, pager_selectorId) {
        var grid_selector = grid_selectorId;
        var pager_selector = pager_selectorId;
        var param = {
            url: G_webrootPath + "/service/page/account/serviceBusinessAccount",
            postData: {
                cmd: "account",
                search_businessid: function () {
                    return $("#businessAccountMng_query_businessid").val();
                },
                search_businessname: function () {
                    return $("#businessAccountMng_query_businessname").val();
                },
                search_channel: function () {
                    return $("#businessAccountMng_query_channel").val();
                },
                search_name: function () {
                    return $("#businessAccountMng_query_name").val();
                },
                search_status: function () {
                    return $("#businessAccountMng_query_status").val();
                }
            },
            multiselect: true,
            height: 290,
            sortname: "isdefault,createdate,businessid,status",
            sortorder: "desc",
            colNames: ['编辑', 'id', 'userid', '账务平台', '客户号', '名称', '法人', '渠道号', '创建时间', '状态', '行政区域编码', '行业分类编码'],
            colModel: [{
                name: 'myac',
                index: '',
                width: 70,
                fixed: true,
                sortable: false,
                align: 'center',
                formatter: function (cellvalue, options, rowObject) {
                    return "<div style=\"margin-left:8px;\">"
                        + "<div title=\"编辑所选记录\" style=\"float:left;cursor:pointer;\" class=\"ui-pg-div ui-inline-edit\" "
                        + "onclick=\"businessAccountMng.editRecord('"
                        + rowObject.id
                        + "');\" "
                        + "onmouseover=\"$(this).addClass('ui-state-hover');\" "
                        + "onmouseout=\"$(this).removeClass('ui-state-hover')\">"
                        + "<span class=\"ui-icon ui-icon-pencil\"></span></div>"
                        + "<div title=\"删除所选记录\" style=\"float:left;margin-left:5px;\" class=\"ui-pg-div ui-inline-del\" "
                        + "onclick=\"businessAccountMng.delRecord('"
                        + rowObject.id
                        + "','"
                        + rowObject.userid
                        + "','"
                        + rowObject.businessid
                        + "','"
                        + rowObject.businessname
                        + "','"
                        + rowObject.channel
                        + "','"
                        + rowObject.regioncode
                        + "','"
                        + rowObject.industrycode
                        + "');\" "
                        + "onmouseover=\"$(this).addClass('ui-state-hover');\" "
                        + "onmouseout=\"$(this).removeClass('ui-state-hover');\">"
                        + "<span class=\"ui-icon ui-icon-trash\"></span></div><div>";
                }
            }, {
                name: 'id',
                index: 'id',
                hidden: true
            }, {
                name: 'userid',
                index: 'userid',
                hidden: true
            }, {
                name: 'isdefault',
                index: 'isdefault',
                align: 'center',
                fixed: true,
                width: 80,
                formatter: function (cellvalue, options, rowObject) {
                    var temp = "";
                    if (cellvalue == "1") {
                        temp = "<div class='blue bolder grid-form-field-div align-center width-100'>是</div>";
                    } else {
                        temp = "<div class='red bolder grid-form-field-div align-center width-100'>否</div>";
                    }
                    return temp;
                }
            }, {
                name: 'businessid',
                index: 'businessid',
                align: 'center',
                fixed: true,
                width: 210
            }, {
                name: 'businessname',
                index: 'businessname'
            }, {
                name: 'name',
                index: 'name',
                align: 'center',
                fixed: true,
                width: 80
            }, {
                name: 'channel',
                index: 'channel',
                align: 'center',
                fixed: true,
                width: 125
            }, {
                name: 'createdate',
                index: 'createdate',
                align: 'center',
                fixed: true,
                width: 140
            }, {
                name: 'status',
                index: 'status',
                align: 'center',
                fixed: true,
                width: 60,
                formatter: function (cellvalue, options, rowObject) {
                    var temp = "";
                    if (cellvalue == "1") {
                        temp = "<div class='green bolder grid-form-field-div align-center width-100'>激活</div>";
                    } else if (cellvalue == "2") {
                        temp = "<div class='blue bolder grid-form-field-div align-center width-100'>注册中</div>";
                    } else {
                        temp = "<div class='red bolder grid-form-field-div align-center width-100'>禁用</div>";
                    }
                    return temp;
                }
            }, {
                name: 'regioncode',
                index: 'regioncode',
                hidden: true
            }, {
                name: 'industrycode',
                index: 'industrycode',
                hidden: true
            }]
        };
        AUI.grid.generateGrid(grid_selector, pager_selector, param);
    };

    /**
     * 绑定事件
     */
    businessAccountMng.initEvent = function () {
        $("#businessAccountMng_reset_btn").click(function () {
            $("#businessAccountMng_conditionform")[0].reset();
        });
        $("#businessAccountMng_query_btn").click(function () {
            AUI.grid.refreshGrid(grid_selectorId, true);
        });
        $("#businessAccountMng_del_btn").click(function () {
            businessAccountMng.delRecords();
        });
        $("#businessAccountMng_add_btn").click(function () {
            businessAccountMng.addRecord();
        });
    };

    /**
     * 新增
     */
    businessAccountMng.addRecord = function () {
        AUI.dialog.inDialog("max", "max", "B类账户详细信息", {
            innerUrl: G_webrootPath + "/view/page/account/businessAccountInfo",
            closeOnEscape: false,
            fullscreen: true
        }, null, function (rtn) {
            AUI.grid.refreshGrid(grid_selectorId);
        });
    };

    /**
     * 编辑
     */
    businessAccountMng.editRecord = function (id) {
        AUI.dialog.inDialog("max", "max", "B类账户详细信息", {
            innerUrl: G_webrootPath + "/view/page/account/businessAccountInfo?id=" + id,
            closeOnEscape: false,
            fullscreen: true
        }, null, function (rtn) {
            AUI.grid.refreshGrid(grid_selectorId);
        });
    };

    /**
     * 单个删除
     */
    businessAccountMng.delRecord = function (id, userid, businessid, businessname, channel, regioncode, industrycode) {
        AUI.dialog.confirm("确定删除B类账户【" + businessname + "（" + businessid + "）】？", function (data) {
            if (data) {
                var obj = {};
                obj.id = id;
                obj.userid = userid;
                obj.businessid = businessid;
                obj.channel = channel;
                obj.regioncode = regioncode;
                obj.industrycode = industrycode;
                var list = [];
                list.push(obj);
                businessAccountMng.doDelRecord(list);
            }
        });
    };

    /**
     * 批量删除
     */
    businessAccountMng.delRecords = function () {
        var list = [];
        var ids = AUI.grid.getSelectedIDs(grid_selectorId);
        if (ids.length > 0) {
            for (var i = 0; i < ids.length; i++) {
                var id = ids[i];
                var rowData = AUI.grid.getRowData(grid_selectorId, id);
                var obj = {};
                obj.id = rowData.id;
                obj.userid = rowData.userid;
                obj.businessid = rowData.businessid;
                obj.channel = rowData.channel;
                obj.regioncode = rowData.regioncode;
                obj.industrycode = rowData.industrycode;
                list.push(obj);
            }
            AUI.dialog.confirm("确定删除所选账户？", function (data) {
                if (data) {
                    businessAccountMng.doDelRecord(list);
                }
            });
        } else {
            AUI.dialog.alert("请选择需要删除的数据！", null, 3);
        }
    };

    /**
     * 执行删除
     *
     * @param list
     */
    businessAccountMng.doDelRecord = function (list) {
        if (list.length > 0) {
            portal_tools_obj.showAuthDialog(function (authdata) {
                portal_tools_obj.doAjax(G_webrootPath + "/service/page/account/serviceBusinessAccount", {
                    oper: "deleteaccount",
                    authloginno: authdata.authloginno,
                    authpassword: authdata.authpassword,
                    objs: JSON.stringify(list)
                }, function (data) {
                    if (data.errmsg) {
                        AUI.dialog.alert(data.errmsg, null, 3);
                    } else {
                        AUI.dialog.alert(data.result, function () {
                            $("#businessAccountMng_query_btn").click();
                        }, 1);
                    }
                });
            });
        }
    };

    $(function () {
        businessAccountMng.generateGrid(grid_selectorId, pager_selectorId);
        businessAccountMng.initEvent();
    });
})($);