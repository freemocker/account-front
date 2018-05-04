<?php
/**
 * Created by PhpStorm.
 * User: zhangbin
 * Date: 2016/10/13
 * Time: 13:59
 */
require dirname(__FILE__) . '/../../common/pageHead.php';
?>
<html <?php echo $GLOBALS['html_attr'] ?>>
<head>
    <title>C账户信息</title>
    <?php
    require $_SERVER['DOCUMENT_ROOT'] . $GLOBALS['webroot'] . '/view/common/head.php';
    $commonTools = new \service\tools\ToolsClass();
    $custid = "";
    $custinfo = null;
    if (isset($_REQUEST['custid'])) {
        $custinfos = $commonTools->getDatasBySQL("select c.*,b.businessname from acc_cust_account c inner join acc_business_account b on c.channel=b.channel where c.custid='" . $_REQUEST['custid'] . "'");
        if (count($custinfos) > 0) {
            $custinfo = $custinfos[0];
            $custid = $_REQUEST['custid'];
        }
    }
    $certtype = $commonTools->getDatasBySQL("select c.code,c.name,case when c.code in (select ba.certtype from acc_cust_account ba where ba.custid='" . $custid . "') then 'selected' else '' end as selected from acc_dic_certtype c where c.status=1");
    ?>
    <style type="text/css">
        .titlelabel {
            width: 120px;
        }

        .selectclass {
            width: 100px;
        }

        .selectcerttype {
            width: 200px;
        }
    </style>
</head>
<body class="<?php echo $GLOBALS['body_class']; ?>">
<input class="hidden" id="custAccountMng_custinfo_custid"
       value="<?php if ($custinfo !== null) echo $custinfo['custid']; ?>"/>
<input class="hidden" id="custAccountMng_custinfo_oldtelephone"
       value="<?php if ($custinfo !== null) echo $custinfo['telephone']; ?>"/>
<div class="widget-main">
    <form class="form-horizontal" id="custAccountMng_custinfo_form">
        <ul class="nav nav-tabs padding-16">
            <li class="active">
                <a data-toggle="tab" aria-expanded="true" href="#custAccountMng_custinfo_edit_basic">
                    <i class="green ace-icon fa fa-pencil-square-o bigger-125"></i> 账户基础信息
                </a>
            </li>
            <li>
                <a data-toggle="tab" aria-expanded="true" id="custAccountMng_custinfo_edit_subaccount_a"
                   href="#custAccountMng_custinfo_edit_subaccount">
                    <i class="red ace-icon fa fa-rmb bigger-125"></i> 账户信息
                </a>
            </li>
            <li>
                <a data-toggle="tab" aria-expanded="true" id="custAccountMng_custinfo_edit_bindinfo_a"
                   href="#custAccountMng_custinfo_edit_bindinfo">
                    <i class="orange ace-icon fa fa-chain bigger-125"></i> 账户绑定信息
                </a>
            </li>
        </ul>
        <div class="tab-content div-info-tab-content">
            <div id="custAccountMng_custinfo_edit_basic" class="tab-pane active">
                <div class="form-group no-margin-bottom">
                    <div class="form-group col-sm-6 no-padding no-margin-left no-margin-right">
                        <div class="form-group col-sm-12 no-padding no-margin-left no-margin-right">
                            <label class="col-sm-1 control-label no-padding-right titlelabel">C户客户号：</label>
                            <label class="col-sm-7 control-label no-padding-right align-left blue">
                                <?php if ($custinfo !== null) echo $custinfo['custid']; ?>
                            </label>
                        </div>
                    </div>
                    <div class="form-group col-sm-6 no-padding no-margin-left no-margin-right">
                        <div class="form-group col-sm-12 no-padding no-margin-left no-margin-right">
                            <label class="col-sm-1 control-label no-padding-right titlelabel">注册渠道号：</label>
                            <label class="col-sm-7 control-label no-padding-right align-left blue">
                                <?php if ($custinfo !== null) echo $custinfo['channel']; ?>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group no-margin-bottom">
                    <div class="form-group col-sm-6 no-padding no-margin-left no-margin-right">
                        <label class="col-sm-1 control-label no-padding-right titlelabel"
                               for="custAccountMng_custinfo_nickname">昵称：</label>
                        <div class="col-sm-7">
                            <input class="form-control" type="text"
                                   id="custAccountMng_custinfo_nickname"
                                   placeholder="昵称"
                                   maxlength="40"
                                   value="<?php if ($custinfo !== null) echo $custinfo['nickname']; ?>"/>
                        </div>
                    </div>
                    <div class="form-group col-sm-6 no-padding no-margin-left no-margin-right">
                        <div class="form-group col-sm-12 no-padding no-margin-left no-margin-right">
                            <label class="col-sm-1 control-label no-padding-right titlelabel">渠道名称：</label>
                            <label class="col-sm-7 control-label no-padding-right align-left blue">
                                <?php if ($custinfo !== null) echo $custinfo['businessname']; ?>
                            </label>
                        </div>
                    </div>
                </div>
                <hr class="hr-14"/>
                <div class="form-group no-margin-bottom">
                    <div class="form-group col-sm-6 no-padding no-margin-left no-margin-right">
                        <label class="col-sm-1 control-label no-padding-right titlelabel"
                               for="custAccountMng_custinfo_name">姓名：</label>
                        <div class="col-sm-7">
                            <input class="form-control" type="text"
                                   id="custAccountMng_custinfo_name"
                                   placeholder="姓名"
                                   maxlength="40"
                                   value="<?php if ($custinfo !== null) echo $custinfo['name']; ?>"/>
                        </div>
                    </div>
                    <div class="form-group col-sm-6 no-padding no-margin-left no-margin-right">
                        <label class="col-sm-1 control-label no-padding-right titlelabel"
                               for="custAccountMng_custinfo_certtype">证件类型：</label>
                        <div class="col-sm-7">
                            <select class="form-control selectcerttype"
                                    id="custAccountMng_custinfo_certtype" data-placeholder=" ">
                                <?php
                                foreach ($certtype as $cert) {
                                    echo '<option ' . $cert['selected'] . ' value="' . $cert['code'] . '">' . $cert['name'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group no-margin-bottom">
                    <div class="form-group col-sm-12 no-padding no-margin-left no-margin-right">
                        <label class="col-sm-1 control-label no-padding-right titlelabel"
                               for="custAccountMng_custinfo_certno">证件号码：</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="text"
                                   id="custAccountMng_custinfo_certno"
                                   placeholder="证件号码"
                                   maxlength="40"
                                   value="<?php if ($custinfo !== null) echo $custinfo['certno']; ?>"/>
                        </div>
                    </div>
                </div>
                <hr class="hr-14"/>
                <div class="form-group no-margin-bottom">
                    <div class="form-group col-sm-6 no-padding no-margin-left no-margin-right">
                        <label class="col-sm-1 control-label no-padding-right titlelabel"
                               for="custAccountMng_custinfo_telephone">电话号码：</label>
                        <div class="col-sm-7" style="padding-right:30px;">
                            <div class="col-sm-9 no-padding-left" style="width:180px">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="ace-icon fa fa-phone"></i>
                                    </span>
                                    <span class="block input-icon input-icon-right">
                                        <input class="required form-control" type="text"
                                               id="custAccountMng_custinfo_telephone"
                                               required placeholder="电话号码"
                                               maxlength="11"
                                               value="<?php if ($custinfo !== null) echo $custinfo['telephone']; ?>"/>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-sm-6 no-padding no-margin-left no-margin-right">
                        <label class="col-sm-1 control-label no-padding-right titlelabel"
                               for="custAccountMng_custinfo_status">账户状态：</label>
                        <div class="col-sm-7" style="padding-right:30px;">
                            <select class="form-control selectclass"
                                    id="custAccountMng_custinfo_status">
                                <option <?php if ($custinfo !== null && $custinfo['status'] == '1') echo 'selected'; ?>
                                        value="1"> 激活
                                </option>
                                <option <?php if ($custinfo !== null && $custinfo['status'] == '0') echo 'selected'; ?>
                                        value="0"> 禁用
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-actions center no-margin">
                    <?php
                    if ($custid !== "") {
                        echo '<button type="button" class="btn btn-white btn-info btn-bold btn-round" id="custAccountMng_custinfo_rpw_btn"><i class="ace-icon fa fa-key bigger-120 blue"></i> 重置登录密码</button> &nbsp; &nbsp;';
                    }
                    ?>
                    <button type="reset"
                            class="btn btn-white btn-warning btn-bold btn-round"
                            id="custAccountMng_custinfo_reset_btn">
                        <i class="ace-icon fa fa-undo bigger-120 orange2"></i> 撤销
                    </button>
                    &nbsp;&nbsp;
                    <button type="button"
                            class="btn btn-white btn-success btn-bold btn-round"
                            id="custAccountMng_custinfo_save_btn">
                        <i class="ace-icon fa fa-floppy-o bigger-120 green"></i> 保存
                    </button>
                    &nbsp;&nbsp;
                    <button type="button"
                            class="btn btn-white btn-danger btn-bold btn-round"
                            id="custAccountMng_custinfo_cancle_btn">
                        <i class="ace-icon fa fa-times bigger-120 red2"></i> 取消
                    </button>
                </div>
            </div>
            <div id="custAccountMng_custinfo_edit_subaccount" class="tab-pane">
                <input class="hidden" id="custAccountMng_custinfo_subaccount_type_select"
                       value="<?php
                       $types = $commonTools->getDatasBySQL("select type,name from acc_dic_account_type order by code asc");
                       $typevalue = ":";
                       foreach ($types as $type) {
                           $typevalue .= ";" . $type['type'] . ":" . $type['name'];
                       }
                       echo $typevalue;
                       ?>"/>
                <div class="form-group no-margin-bottom no-margin-left no-margin-right">
                    <div class="col-sm-12 no-padding">
                        <table id="custAccountMng_custinfo_subaccount_grid_table"></table>
                        <div id="custAccountMng_custinfo_subaccount_grid_pager"></div>
                    </div>
                </div>
            </div>
            <div id="custAccountMng_custinfo_edit_bindinfo" class="tab-pane">
                <div class="form-group no-margin-bottom no-margin-left no-margin-right">
                    <div class="col-sm-12 no-padding">
                        <div id="custAccountMng_custinfo_edit_bindinfo_accordion"
                             class="accordion-style1 panel-group">
                            <?php
                            $bindtypes_c = $commonTools->getDatasBySQL("select b.code,b.name,(select count(bb.id) from acc_cust_bindinfo bb where bb.custid='" . $custinfo['custid'] . "' and bb.type=b.code) as typecount from acc_dic_c_bindtype b where b.status=1 order by b.code");
                            $index = 0;
                            foreach ($bindtypes_c as $bindtype_c) {
                                $typecount = intval($bindtype_c['typecount']);
                                ?>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a class="accordion-toggle <?php if ($index == 0 && $typecount > 0) echo 'collapsed'; ?>"
                                               data-toggle="collapse"
                                               data-parent="#custAccountMng_custinfo_edit_bindinfo_accordion"
                                               href="#custAccountMng_custinfo_edit_bindinfo_<?php echo $bindtype_c['code']; ?>">
                                                <i class="ace-icon fa <?php if ($index == 0 && $typecount > 0) echo 'fa-angle-down'; else echo 'fa-angle-right'; ?> bigger-110"
                                                   data-icon-hide="ace-icon fa fa-angle-down"
                                                   data-icon-show="ace-icon fa fa-angle-right"></i>
                                                &nbsp;<?php echo $bindtype_c['name'] . ' （' . $bindtype_c['code'] . '）'; ?>
                                                <span class="badge"
                                                      style="background-color: #ff892a !important">0</span>
                                                <span id="custAccountMng_custinfo_edit_bindinfo_<?php
                                                echo $bindtype_c['code']; ?>_default"
                                                      class="red hidden">默认</span>
                                            </a>
                                        </h4>
                                    </div>
                                    <div class="panel-collapse collapse <?php if ($index == 0 && $typecount > 0) {
                                        echo 'in';
                                        $index++;
                                    } ?>"
                                         id="custAccountMng_custinfo_edit_bindinfo_<?php echo $bindtype_c['code']; ?>">
                                        <div class="panel-body"></div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<?php require $_SERVER['DOCUMENT_ROOT'] . $GLOBALS['webroot'] . '/view/common/foot.php'; ?>
<script type="text/javascript" defer async="async"
        charset="<?php echo $GLOBALS['charset']; ?>"
        src="<?php echo $GLOBALS['webroot'] . '/script/page/account/custAccountInfo.js?v=1.0.0'; ?>"></script>
</body>
</html>