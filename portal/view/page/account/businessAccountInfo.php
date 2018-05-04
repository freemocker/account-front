<?php
/**
 * Created by PhpStorm.
 * User: zhang
 * Date: 2016/8/17
 * Time: 16:45
 */
require dirname(__FILE__) . '/../../common/pageHead.php';
?>
<html <?php echo $GLOBALS['html_attr'] ?>>
<head>
    <title>B账户信息</title>
    <?php
    require $_SERVER['DOCUMENT_ROOT'] . $GLOBALS['webroot'] . '/view/common/head.php';
    $commonTools = new \service\tools\ToolsClass();
    $id = "";
    $businessinfo = null;
    /*初始化页面标记：1-注册第一步，2-注册第二步，3-注册第三步，0-注册完成*/
    $initflag = 1;
    if (isset($_REQUEST['id'])) {
        $businessinfos = $commonTools->getDatasBySQL("select * from acc_business_account where id='" . $_REQUEST['id'] . "'");
        if (count($businessinfos) > 0) {
            $id = $_REQUEST['id'];
            $businessinfo = $businessinfos[0];
            if ($businessinfo['status'] == '0' || $businessinfo['status'] == '1') {
                $initflag = 0;
            } else {
                if ($businessinfo['businesslicense'] != "" && $businessinfo['certpicture'] != "") {
                    $initflag = 3;
                } else {
                    $initflag = 2;
                }
            }
        }
    }
    $searchresult = $commonTools->getDatasBySQL("select * from acc_business_account where isdefault=1 and id<>'$id'");
    if (count($searchresult) > 0) {
        $showIsDefault = "hidden";
    } else {
        $showIsDefault = "";
    }
    $config = \portal\config\PortalConfig::getInstance();
    $certtype = $commonTools->getDatasBySQL("select c.code,c.name,case when c.code in (select ba.certtype from acc_business_account ba where ba.id='" . $id . "') then 'selected' else '' end as selected from acc_dic_certtype c where c.status=1");
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
<input class="hidden" id="businessAccountMng_businessinfo_id" value="<?php echo $id; ?>"/>
<input class="hidden" id="businessAccountMng_businessinfo_initflag" value="<?php echo $initflag; ?>"/>
<input class="hidden" id="businessAccountMng_businessinfo_businessid"
       value="<?php if ($businessinfo !== null) echo $businessinfo['businessid']; ?>"/>
<input class="hidden" id="businessAccountMng_businessinfo_oldemail"
       value="<?php if ($businessinfo !== null) echo $businessinfo['email']; ?>"/>
<input class="hidden" id="businessAccountMng_businessinfo_regioncode_init"
       value="<?php if ($businessinfo !== null) echo $businessinfo['regioncode']; ?>"/>
<input class="hidden" id="businessAccountMng_businessinfo_industrycode_init"
       value="<?php if ($businessinfo !== null) echo $businessinfo['industrycode']; ?>"/>
<input class="hidden" id="businessAccountMng_businessinfo_imagePath"
       value="<?php echo $config["img"]["uploadBacountUrl"]; ?>"/>
<input class="hidden" id="businessAccountMng_businessinfo_businesslicense_init"
       value="<?php
       if ($businessinfo !== null && $businessinfo['businesslicense'] != null && $businessinfo['businesslicense'] != "") {
           $json = json_decode($businessinfo['businesslicense'], true);
           $str = "";
           foreach ($json as $img) {
               if ($str != "") {
                   $str = $str . ";";
               }
               $str .= $img['linkurl'];
           }
           echo $str;
       }
       ?>"/>
<input class="hidden" id="businessAccountMng_businessinfo_certpicture_init"
       value="<?php
       if ($businessinfo !== null && $businessinfo['certpicture'] != null && $businessinfo['certpicture'] != "") {
           $json = json_decode($businessinfo['certpicture'], true);
           $str = "";
           foreach ($json as $img) {
               if ($str != "") {
                   $str = $str . ";";
               }
               $str = $str . $img['linkurl'];
           }
           echo $str;
       }
       ?>"/>
<?php if ($initflag === 0) { ?>
    <div class="widget-main">
        <form class="form-horizontal" id="businessAccountMng_businessinfo_form">
            <ul class="nav nav-tabs padding-16">
                <li class="active">
                    <a data-toggle="tab" aria-expanded="true" href="#businessAccountMng_businessinfo_edit_basic">
                        <i class="green ace-icon fa fa-pencil-square-o bigger-125"></i> 账户基础信息
                    </a>
                </li>
                <li>
                    <a data-toggle="tab" aria-expanded="true" href="#businessAccountMng_businessinfo_edit_image">
                        <i class="blue ace-icon fa fa-file-image-o bigger-125"></i> 图片附件
                    </a>
                </li>
                <li>
                    <a data-toggle="tab" aria-expanded="true" id="businessAccountMng_businessinfo_edit_subaccount_a"
                       href="#businessAccountMng_businessinfo_edit_subaccount">
                        <i class="red ace-icon fa fa-rmb bigger-125"></i> 账户信息
                    </a>
                </li>
                <li>
                    <a data-toggle="tab" aria-expanded="true" id="businessAccountMng_businessinfo_edit_inneraccount_a"
                       href="#businessAccountMng_businessinfo_edit_inneraccount">
                        <i class="red ace-icon fa fa-newspaper-o bigger-125"></i> 内部账户信息
                    </a>
                </li>
                <li>
                    <a data-toggle="tab" aria-expanded="true" id="businessAccountMng_businessinfo_edit_bindinfo_a"
                       href="#businessAccountMng_businessinfo_edit_bindinfo">
                        <i class="orange ace-icon fa fa-chain bigger-125"></i> 账户绑定信息
                    </a>
                </li>
            </ul>
            <div class="tab-content div-info-tab-content">
                <div id="businessAccountMng_businessinfo_edit_basic" class="tab-pane active">
                    <div class="form-group no-margin-bottom">
                        <div class="form-group col-sm-12 no-padding no-margin-left no-margin-right">
                            <label class="col-sm-1 control-label no-padding-right titlelabel">B户客户号：</label>
                            <label class="col-sm-7 control-label no-padding-right align-left blue">
                                <?php if ($businessinfo !== null) echo $businessinfo['businessid']; ?>
                            </label>
                        </div>
                        <div class="form-group col-sm-12 no-padding no-margin-left no-margin-right">
                            <label class="col-sm-1 control-label no-padding-right titlelabel">渠道号：</label>
                            <label class="col-sm-7 control-label no-padding-right align-left blue">
                                <?php if ($businessinfo !== null) echo $businessinfo['channel']; ?>
                            </label>
                        </div>
                    </div>
                    <div class="form-group no-margin-bottom">
                        <div class="form-group col-sm-6 no-padding no-margin-left no-margin-right">
                            <label class="col-sm-1 control-label no-padding-right titlelabel"
                                   for="businessAccountMng_businessinfo_businessname">B户名称：</label>
                            <div class="col-sm-7">
                                <div class="col-sm-6 no-padding-left">
                                    <span class="block input-icon input-icon-right">
                                        <input class="form-control required"
                                               type="text"
                                               id="businessAccountMng_businessinfo_businessname"
                                               name="businessAccountMng_businessinfo_businessname"
                                               required placeholder="名称"
                                               maxlength="40"
                                               value="<?php if ($businessinfo !== null) echo $businessinfo['businessname']; ?>"/>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-sm-6 no-padding no-margin-left no-margin-right">
                            <label class="col-sm-1 control-label no-padding-right titlelabel">账务平台：</label>
                            <label class="col-sm-7 control-label no-padding-right align-left blue">
                                <?php
                                if ($businessinfo !== null && $businessinfo['isdefault'] == '0') {
                                    echo '否';
                                } else {
                                    echo '是';
                                }
                                ?>
                            </label>
                        </div>
                    </div>
                    <div class="form-group no-margin-bottom">
                        <div class="form-group no-padding no-margin-left no-margin-right">
                            <label class="col-sm-1 control-label no-padding-right titlelabel"
                                   for="businessAccountMng_businessinfo_regionname">行政区域：</label>
                            <div class="col-sm-9">
                                <div class="col-sm-9 no-padding-left">
                                    <span class="block input-icon input-icon-right">
                                        <input class="form-control required" style="cursor: pointer"
                                               type="text" readonly
                                               id="businessAccountMng_businessinfo_regionname"
                                               name="businessAccountMng_businessinfo_regionname"
                                               required placeholder="点击选择行政区域"
                                               value="<?php if ($businessinfo !== null) echo $businessinfo['regionname']; ?>"/>
                                        <input type="hidden"
                                               id="businessAccountMng_businessinfo_regioncode"
                                               name="businessAccountMng_businessinfo_regioncode"
                                               required
                                               value="<?php if ($businessinfo !== null) echo $businessinfo['regioncode']; ?>"/>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group no-margin-bottom">
                        <div class="form-group no-padding no-margin-left no-margin-right">
                            <label class="col-sm-1 control-label no-padding-right titlelabel"
                                   for="businessAccountMng_businessinfo_industryname">国家行业分类：</label>
                            <div class="col-sm-9">
                                <div class="col-sm-9 no-padding-left">
                                    <span class="block input-icon input-icon-right">
                                        <input class="form-control required" style="cursor: pointer"
                                               type="text" readonly
                                               id="businessAccountMng_businessinfo_industryname"
                                               name="businessAccountMng_businessinfo_industryname"
                                               required placeholder="点击选择国家行业分类"
                                               value="<?php if ($businessinfo !== null) echo $businessinfo['industryname']; ?>"/>
                                        <input type="hidden"
                                               id="businessAccountMng_businessinfo_industrycode"
                                               name="businessAccountMng_businessinfo_industrycode"
                                               required
                                               value="<?php if ($businessinfo !== null) echo $businessinfo['industrycode']; ?>"/>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="hr-14"/>
                    <div class="form-group no-margin-bottom">
                        <div class="form-group col-sm-6 no-padding no-margin-left no-margin-right">
                            <label class="col-sm-1 control-label no-padding-right titlelabel"
                                   for="businessAccountMng_businessinfo_name">法人姓名：</label>
                            <div class="form-group col-sm-9 no-padding no-margin-left no-margin-right">
                                <div class="col-sm-12">
                                    <div class="col-sm-9 no-padding-left">
                                        <span class="block input-icon input-icon-right">
                                            <input class="form-control required"
                                                   type="text"
                                                   id="businessAccountMng_businessinfo_name"
                                                   name="businessAccountMng_businessinfo_name"
                                                   required placeholder="法人姓名"
                                                   value="<?php if ($businessinfo !== null) echo $businessinfo['name']; ?>"/>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-sm-6 no-padding no-margin-left no-margin-right">
                            <label class="col-sm-1 control-label no-padding-right titlelabel"
                                   for="businessAccountMng_businessinfo_certtype">法人证件类型：</label>
                            <div class="form-group col-sm-9 no-padding no-margin-left no-margin-right">
                                <div class="col-sm-12">
                                    <select class="form-control required selectcerttype"
                                            id="businessAccountMng_businessinfo_certtype"
                                            name="businessAccountMng_businessinfo_certtype"
                                            data-placeholder=" ">
                                        <?php
                                        foreach ($certtype as $cert) {
                                            echo '<option ' . $cert['selected'] . ' value="' . $cert['code'] . '">' . $cert['name'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group no-margin-bottom">
                        <div class="form-group col-sm-6 no-padding no-margin-left no-margin-right">
                            <label class="col-sm-1 control-label no-padding-right titlelabel"
                                   for="businessAccountMng_businessinfo_certno">法人证件号码：</label>
                            <div class="form-group col-sm-9 no-padding no-margin-left no-margin-right">
                                <div class="col-sm-12">
                                    <div class="col-sm-9 no-padding-left">
                                        <span class="block input-icon input-icon-right">
                                            <input class="form-control required"
                                                   type="text"
                                                   id="businessAccountMng_businessinfo_certno"
                                                   name="businessAccountMng_businessinfo_certno"
                                                   required placeholder="法人证件号码"
                                                   value="<?php if ($businessinfo !== null) echo $businessinfo['certno']; ?>"/>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-sm-6 no-padding no-margin-left no-margin-right">
                            <label class="col-sm-1 control-label no-padding-right titlelabel"
                                   for="businessAccountMng_businessinfo_email">邮箱：</label>
                            <div class="form-group col-sm-9 no-padding no-margin-left no-margin-right">
                                <div class="col-sm-12">
                                    <div class="col-sm-9 no-padding-left">
                                        <span class="block input-icon input-icon-right">
                                            <input class="form-control required"
                                                   type="text"
                                                   id="businessAccountMng_businessinfo_email"
                                                   name="businessAccountMng_businessinfo_email"
                                                   required placeholder="邮箱"
                                                   value="<?php if ($businessinfo !== null) echo $businessinfo['email']; ?>"/>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="hr-14"/>
                    <div class="form-group no-margin-bottom">
                        <div class="form-group col-sm-6 no-padding no-margin-left no-margin-right">
                            <label class="col-sm-1 control-label no-padding-right titlelabel"
                                   for="businessAccountMng_businessinfo_bankaccount">对公账户号：</label>
                            <div class="col-sm-7" style="padding-right:30px;">
                                <input class="form-control"
                                       type="text"
                                       id="businessAccountMng_businessinfo_bankaccount"
                                       name="businessAccountMng_businessinfo_bankaccount"
                                       placeholder="对公账户号"
                                       maxlength="40"
                                       value="<?php if ($businessinfo !== null) echo $businessinfo['bankaccount']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group col-sm-6 no-padding no-margin-left no-margin-right">
                            <label class="col-sm-1 control-label no-padding-right titlelabel"
                                   for="businessAccountMng_businessinfo_accountname">对公账户名称：</label>
                            <div class="col-sm-7" style="padding-right:30px;">
                                <input class="form-control"
                                       type="text"
                                       id="businessAccountMng_businessinfo_accountname"
                                       name="businessAccountMng_businessinfo_accountname"
                                       placeholder="对公账户名称"
                                       maxlength="40"
                                       value="<?php if ($businessinfo !== null) echo $businessinfo['accountname']; ?>"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group no-margin-bottom">
                        <div class="form-group col-sm-6 no-padding no-margin-left no-margin-right">
                            <label class="col-sm-1 control-label no-padding-right titlelabel"
                                   for="businessAccountMng_businessinfo_bank">开户行：</label>
                            <div class="col-sm-7" style="padding-right:30px;">
                                <input class="form-control"
                                       type="text"
                                       id="businessAccountMng_businessinfo_bank"
                                       name="businessAccountMng_businessinfo_bank"
                                       placeholder="开户行"
                                       value="<?php if ($businessinfo !== null) echo $businessinfo['bank']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group col-sm-6 no-padding no-margin-left no-margin-right">
                            <label class="col-sm-1 control-label no-padding-right titlelabel"
                                   for="businessAccountMng_businessinfo_telephone">预留电话号码：</label>
                            <div class="col-sm-7" style="padding-right:30px;">
                                <div class="col-sm-9 no-padding-left" style="width:180px">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ace-icon fa fa-phone"></i>
                                        </span>
                                        <span class="block input-icon input-icon-right">
                                            <input class="required form-control"
                                                   type="text"
                                                   id="businessAccountMng_businessinfo_telephone"
                                                   name="businessAccountMng_businessinfo_telephone"
                                                   required placeholder="预留电话号码"
                                                   maxlength="11"
                                                   value="<?php if ($businessinfo !== null) echo $businessinfo['telephone']; ?>"/>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group no-margin-bottom">
                        <div class="form-group col-sm-6 no-padding no-margin-left no-margin-right">
                            <label class="col-sm-1 control-label no-padding-right titlelabel"
                                   for="businessAccountMng_businessinfo_settlementtype">结算类型：</label>
                            <div class="col-sm-7" style="padding-right:30px;">
                                <select class="form-control required"
                                        id="businessAccountMng_businessinfo_settlementtype"
                                        name="businessAccountMng_businessinfo_settlementtype">
                                    <?php
                                    $bindtypes_b = $commonTools->getDatasBySQL("select name,code from acc_dic_b_bindtype where status=1");
                                    foreach ($bindtypes_b as $bindtype_b) {
                                        ?>
                                        <option <?php if ($businessinfo !== null && $businessinfo['settlementtype'] == $bindtype_b['code']) echo 'selected'; ?>
                                                value="<?php echo $bindtype_b['code']; ?>"> <?php echo $bindtype_b['name']; ?>
                                        </option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-sm-6 no-padding no-margin-left no-margin-right">
                            <label class="col-sm-1 control-label no-padding-right titlelabel"
                                   for="businessAccountMng_businessinfo_status">账户状态：</label>
                            <div class="col-sm-7" style="padding-right:30px;">
                                <select class="form-control selectclass"
                                        id="businessAccountMng_businessinfo_status"
                                        name="businessAccountMng_businessinfo_status">
                                    <option <?php if ($businessinfo !== null && $businessinfo['status'] == '1') echo 'selected'; ?>
                                            value="1"> 激活
                                    </option>
                                    <option <?php if ($businessinfo !== null && $businessinfo['status'] == '0') echo 'selected'; ?>
                                            value="0"> 禁用
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group no-margin-bottom">
                        <div class="form-group no-padding no-margin-left no-margin-right">
                            <label class="col-sm-1 control-label no-padding-right titlelabel">客户id：</label>
                            <label class="col-sm-10 control-label no-padding-right align-left blue"
                                   id="businessAccountMng_businessinfo_id"><?php if ($businessinfo !== null) echo $businessinfo['id']; ?>
                            </label>
                        </div>
                    </div>
                    <div class="form-group no-margin-bottom">
                        <div class="form-group no-padding no-margin-left no-margin-right">
                            <label class="col-sm-1 control-label no-padding-right titlelabel">安全校验key：</label>
                            <label class="col-sm-10 control-label no-padding-right align-left blue"
                                   id="businessAccountMng_businessinfo_key"><?php if ($businessinfo !== null) echo $businessinfo['businesskey']; ?>
                            </label>
                        </div>
                    </div>
                    <div class="form-actions center no-margin">
                        <?php
                        if ($id !== "") {
                            echo '<button type="button" class="btn btn-white btn-info btn-bold btn-round" id="businessAccountMng_businessinfo_rpw_btn"><i class="ace-icon fa fa-key bigger-120 blue"></i> 重置登录密码</button> &nbsp; &nbsp;';
                            echo '<button type="button" class="btn btn-white btn-info btn-bold btn-round" id="businessAccountMng_businessinfo_rkey_btn"><i class="ace-icon fa fa-key bigger-120 blue"></i> 重新生成安全校验key</button> &nbsp;&nbsp;';
                        }
                        ?>
                        <button type="reset"
                                class="btn btn-white btn-warning btn-bold btn-round"
                                id="businessAccountMng_businessinfo_reset_btn">
                            <i class="ace-icon fa fa-undo bigger-120 orange2"></i> 撤销
                        </button>
                        &nbsp;&nbsp;
                        <button type="button"
                                class="btn btn-white btn-success btn-bold btn-round"
                                id="businessAccountMng_businessinfo_save_btn">
                            <i class="ace-icon fa fa-floppy-o bigger-120 green"></i> 保存
                        </button>
                        &nbsp;&nbsp;
                        <button type="button"
                                class="btn btn-white btn-danger btn-bold btn-round"
                                id="businessAccountMng_businessinfo_cancle_btn">
                            <i class="ace-icon fa fa-times bigger-120 red2"></i> 取消
                        </button>
                    </div>
                </div>
                <div id="businessAccountMng_businessinfo_edit_image" class="tab-pane">
                    <div class="form-group no-margin-bottom">
                        <div class="form-group col-sm-12 no-padding no-margin-left no-margin-right">
                            <div class="col-sm-12" id="businessAccountMng_businessinfo_businesslicense_div"></div>
                        </div>
                    </div>
                    <div class="form-group no-margin-bottom">
                        <div class="form-group col-sm-12 no-padding no-margin-left no-margin-right">
                            <div class="col-sm-12" id="businessAccountMng_businessinfo_certpicture_div"></div>
                        </div>
                    </div>
                </div>
                <div id="businessAccountMng_businessinfo_edit_subaccount" class="tab-pane">
                    <input class="hidden" id="businessAccountMng_businessinfo_subaccount_type_select"
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
                            <table id="businessAccountMng_businessinfo_subaccount_grid_table"></table>
                            <div id="businessAccountMng_businessinfo_subaccount_grid_pager"></div>
                        </div>
                    </div>
                </div>
                <div id="businessAccountMng_businessinfo_edit_inneraccount" class="tab-pane">
                    <div class="form-group no-margin-bottom no-margin-left no-margin-right">
                        <div class="col-sm-12 no-padding">
                            <table id="businessAccountMng_businessinfo_inneraccount_grid_table"></table>
                            <div id="businessAccountMng_businessinfo_inneraccount_grid_pager"></div>
                        </div>
                    </div>
                </div>
                <div id="businessAccountMng_businessinfo_edit_bindinfo" class="tab-pane">
                    <div class="form-group no-margin-bottom no-margin-left no-margin-right">
                        <div class="col-sm-12 no-padding">
                            <div class="form-group align-right no-margin-left no-margin-right">
                                <button type="button" class="btn btn-sm btn-info"
                                        id="businessAccountMng_businessinfo_edit_bindinfo_add">
                                    <i class="ace-icon fa fa-plus bigger-120"></i> 新建
                                </button>
                            </div>
                            <div id="businessAccountMng_businessinfo_edit_bindinfo_accordion"
                                 class="accordion-style1 panel-group">
                                <?php
                                $bindtypes_b = $commonTools->getDatasBySQL("select b.code,b.name,(select count(bb.id) from acc_business_bindinfo bb where bb.businessid='" . $businessinfo['businessid'] . "' and bb.type=b.code) as typecount from acc_dic_b_bindtype b where b.status=1 order by b.code");
                                $index = 0;
                                foreach ($bindtypes_b as $bindtype_b) {
                                    $typecount = intval($bindtype_b['typecount']);
                                    ?>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a class="accordion-toggle <?php if ($index == 0 && $typecount > 0) echo 'collapsed'; ?>"
                                                   data-toggle="collapse"
                                                   data-parent="#businessAccountMng_businessinfo_edit_bindinfo_accordion"
                                                   href="#businessAccountMng_businessinfo_edit_bindinfo_<?php echo $bindtype_b['code']; ?>">
                                                    <i class="ace-icon fa <?php if ($index == 0 && $typecount > 0) echo 'fa-angle-down'; else echo 'fa-angle-right'; ?> bigger-110"
                                                       data-icon-hide="ace-icon fa fa-angle-down"
                                                       data-icon-show="ace-icon fa fa-angle-right"></i>
                                                    &nbsp;<?php echo $bindtype_b['name'] . ' （' . $bindtype_b['code'] . '）'; ?>
                                                    <span class="badge"
                                                          style="background-color: #ff892a !important">0</span>
                                                    <span id="businessAccountMng_businessinfo_edit_bindinfo_<?php
                                                    echo $bindtype_b['code']; ?>_default"
                                                          class="red hidden">默认</span>
                                                </a>
                                            </h4>
                                        </div>
                                        <div class="panel-collapse collapse <?php if ($index == 0 && $typecount > 0) {
                                            echo 'in';
                                            $index++;
                                        } ?>"
                                             id="businessAccountMng_businessinfo_edit_bindinfo_<?php echo $bindtype_b['code']; ?>">
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
<?php } else { ?>
    <div class="widget-box">
        <div class="widget-header widget-header-blue widget-header-flat">
            <h4 class="widget-title lighter">B户注册</h4>
        </div>
        <div class="widget-body">
            <div class="widget-main">
                <div id="businessAccountMng_businessinfo_wizard_container">
                    <div>
                        <ul class="steps">
                            <li data-step="1" <?php if ($initflag === 1) echo 'class="active"'; ?>>
                                <span class="step">1</span>
                                <span class="title">基础信息录入</span>
                            </li>
                            <li data-step="2" <?php if ($initflag === 2) echo 'class="active"'; ?>>
                                <span class="step">2</span>
                                <span class="title">图片上传</span>
                            </li>
                            <li data-step="3" <?php if ($initflag === 3) echo 'class="active"'; ?>>
                                <span class="step">3</span>
                                <span class="title">信息复核</span>
                            </li>
                            <li data-step="4">
                                <span class="step">4</span>
                                <span class="title">注册成功</span>
                            </li>
                        </ul>
                    </div>
                    <hr/>
                    <div class="step-content pos-rel">
                        <div class="step-pane <?php if ($initflag === 1) echo 'active'; ?>" data-step="1">
                            <div class="center">
                                <h3 class="lighter block green">录入B类账户基础信息</h3><h5 class="lighter block red">
                                    （红色部分为必填项）</h5>
                            </div>
                            <form class="form-horizontal" id="businessAccountMng_businessinfo_form">
                                <div class="form-group no-margin-bottom">
                                    <label class="col-sm-3 control-label no-padding-right"
                                           for="businessAccountMng_businessinfo_businessname">B户名称</label>
                                    <div class="form-group col-sm-9 no-padding no-margin-left no-margin-right">
                                        <div class="col-sm-12">
                                            <div class="col-sm-9 no-padding-left">
                                                <span class="block input-icon input-icon-right">
                                                    <input class="form-control required"
                                                           type="text"
                                                           id="businessAccountMng_businessinfo_businessname"
                                                           name="businessAccountMng_businessinfo_businessname"
                                                           required placeholder="名称"
                                                           value="<?php if ($businessinfo !== null) echo $businessinfo['businessname']; ?>"/>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group no-margin-bottom">
                                    <label class="col-sm-3 control-label no-padding-right"
                                           for="businessAccountMng_businessinfo_regionname">行政区域</label>
                                    <div class="form-group col-sm-9 no-padding no-margin-left no-margin-right">
                                        <div class="col-sm-12">
                                            <div class="col-sm-9 no-padding-left">
                                                <span class="block input-icon input-icon-right">
                                                    <input class="form-control required" style="cursor: pointer"
                                                           type="text" readonly
                                                           id="businessAccountMng_businessinfo_regionname"
                                                           name="businessAccountMng_businessinfo_regionname"
                                                           required placeholder="点击选择行政区域"
                                                           value="<?php if ($businessinfo !== null) echo $businessinfo['regionname']; ?>"/>
                                                    <input type="hidden"
                                                           id="businessAccountMng_businessinfo_regioncode"
                                                           name="businessAccountMng_businessinfo_regioncode"
                                                           required
                                                           value="<?php if ($businessinfo !== null) echo $businessinfo['regioncode']; ?>"/>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group no-margin-bottom">
                                    <label class="col-sm-3 control-label no-padding-right"
                                           for="businessAccountMng_businessinfo_industryname">国家行业分类</label>
                                    <div class="form-group col-sm-9 no-padding no-margin-left no-margin-right">
                                        <div class="col-sm-12">
                                            <div class="col-sm-9 no-padding-left">
                                                <span class="block input-icon input-icon-right">
                                                    <input class="form-control required" style="cursor: pointer"
                                                           type="text" readonly
                                                           id="businessAccountMng_businessinfo_industryname"
                                                           name="businessAccountMng_businessinfo_industryname"
                                                           required placeholder="点击选择国家行业分类"
                                                           value="<?php if ($businessinfo !== null) echo $businessinfo['industryname']; ?>"/>
                                                    <input type="hidden"
                                                           id="businessAccountMng_businessinfo_industrycode"
                                                           name="businessAccountMng_businessinfo_industrycode"
                                                           required
                                                           value="<?php if ($businessinfo !== null) echo $businessinfo['industrycode']; ?>"/>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group no-margin-bottom <?php echo $showIsDefault; ?>">
                                    <label class="col-sm-3 control-label no-padding-right"
                                           for="businessAccountMng_businessinfo_isdefault">账务平台</label>
                                    <div class="form-group col-sm-9 no-padding no-margin-left no-margin-right">
                                        <div class="col-sm-12">
                                            <select class="form-control required selectclass"
                                                    id="businessAccountMng_businessinfo_isdefault"
                                                    name="businessAccountMng_businessinfo_isdefault">
                                                <option <?php if ($businessinfo == null || ($businessinfo !== null && $businessinfo['isdefault'] == '0')) echo 'selected'; ?>
                                                        value="0"> 否
                                                </option>
                                                <option <?php if ($businessinfo !== null && $businessinfo['isdefault'] == '1') echo 'selected'; ?>
                                                        value="1"> 是
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group no-margin-bottom">
                                    <label class="col-sm-3 control-label no-padding-right"
                                           for="businessAccountMng_businessinfo_name">法人姓名</label>
                                    <div class="form-group col-sm-9 no-padding no-margin-left no-margin-right">
                                        <div class="col-sm-12">
                                            <div class="col-sm-9 no-padding-left">
                                                <span class="block input-icon input-icon-right">
                                                    <input class="form-control required"
                                                           type="text"
                                                           id="businessAccountMng_businessinfo_name"
                                                           name="businessAccountMng_businessinfo_name"
                                                           required placeholder="法人姓名"
                                                           value="<?php if ($businessinfo !== null) echo $businessinfo['name']; ?>"/>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group no-margin-bottom">
                                    <label class="col-sm-3 control-label no-padding-right"
                                           for="businessAccountMng_businessinfo_certtype">法人证件类型</label>
                                    <div class="form-group col-sm-9 no-padding no-margin-left no-margin-right">
                                        <div class="col-sm-12">
                                            <select class="form-control required selectcerttype"
                                                    id="businessAccountMng_businessinfo_certtype"
                                                    name="businessAccountMng_businessinfo_certtype"
                                                    data-placeholder=" ">
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
                                    <label class="col-sm-3 control-label no-padding-right"
                                           for="businessAccountMng_businessinfo_certno">法人证件号码</label>
                                    <div class="form-group col-sm-9 no-padding no-margin-left no-margin-right">
                                        <div class="col-sm-12">
                                            <div class="col-sm-9 no-padding-left">
                                                <span class="block input-icon input-icon-right">
                                                    <input class="form-control required"
                                                           type="text"
                                                           id="businessAccountMng_businessinfo_certno"
                                                           name="businessAccountMng_businessinfo_certno"
                                                           required placeholder="法人证件号码"
                                                           value="<?php if ($businessinfo !== null) echo $businessinfo['certno']; ?>"/>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group no-margin-bottom">
                                    <label class="col-sm-3 control-label no-padding-right"
                                           for="businessAccountMng_businessinfo_telephone">预留电话号码</label>
                                    <div class="form-group col-sm-9 no-padding no-margin-left no-margin-right">
                                        <div class="col-sm-12">
                                            <div class="col-sm-9 no-padding-left" style="width:180px">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="ace-icon fa fa-phone"></i>
                                                    </span>
                                                    <span class="block input-icon input-icon-right">
                                                        <input class="required form-control"
                                                               type="text"
                                                               id="businessAccountMng_businessinfo_telephone"
                                                               name="businessAccountMng_businessinfo_telephone"
                                                               required placeholder="预留电话号码"
                                                               maxlength="11"
                                                               value="<?php if ($businessinfo !== null) echo $businessinfo['telephone']; ?>"/>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group no-margin-bottom">
                                    <label class="col-sm-3 control-label no-padding-right"
                                           for="businessAccountMng_businessinfo_settlementtype">结算类型</label>
                                    <div class="form-group col-sm-9 no-padding no-margin-left no-margin-right">
                                        <div class="col-sm-12">
                                            <select class="form-control required selectcerttype"
                                                    id="businessAccountMng_businessinfo_settlementtype"
                                                    name="businessAccountMng_businessinfo_settlementtype"
                                                    data-placeholder=" ">
                                                <?php
                                                $bindtypes_b = $commonTools->getDatasBySQL("select name,code from acc_dic_b_bindtype where status=1");
                                                foreach ($bindtypes_b as $bindtype_b) {
                                                    ?>
                                                    <option <?php if ($businessinfo !== null && $businessinfo['settlementtype'] == $bindtype_b['code']) echo 'selected'; ?>
                                                            value="<?php echo $bindtype_b['code']; ?>"> <?php echo $bindtype_b['name']; ?>
                                                    </option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group no-margin-bottom">
                                    <label class="col-sm-3 control-label no-padding-right"
                                           for="businessAccountMng_businessinfo_email">邮箱</label>
                                    <div class="form-group col-sm-9 no-padding no-margin-left no-margin-right">
                                        <div class="col-sm-12">
                                            <div class="col-sm-9 no-padding-left">
                                                <span class="block input-icon input-icon-right">
                                                    <input class="form-control required"
                                                           type="text"
                                                           id="businessAccountMng_businessinfo_email"
                                                           name="businessAccountMng_businessinfo_email"
                                                           required placeholder="邮箱"
                                                           value="<?php if ($businessinfo !== null) echo $businessinfo['email']; ?>"/>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group no-margin-bottom">
                                    <label class="col-sm-3 control-label no-padding-right"
                                           for="businessAccountMng_businessinfo_bankaccount">对公账户号</label>
                                    <div class="form-group col-sm-9 no-padding no-margin-left no-margin-right">
                                        <div class="col-sm-12">
                                            <div class="col-sm-9 no-padding-left">
                                                <input class="form-control"
                                                       type="text"
                                                       id="businessAccountMng_businessinfo_bankaccount"
                                                       name="businessAccountMng_businessinfo_bankaccount"
                                                       placeholder="对公账户号"
                                                       value="<?php if ($businessinfo !== null) echo $businessinfo['bankaccount']; ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group no-margin-bottom">
                                    <label class="col-sm-3 control-label no-padding-right"
                                           for="businessAccountMng_businessinfo_accountname">对公账户名称</label>
                                    <div class="form-group col-sm-9 no-padding no-margin-left no-margin-right">
                                        <div class="col-sm-12">
                                            <div class="col-sm-9 no-padding-left">
                                                <input class="form-control"
                                                       type="text"
                                                       id="businessAccountMng_businessinfo_accountname"
                                                       name="businessAccountMng_businessinfo_accountname"
                                                       placeholder="对公账户名称"
                                                       value="<?php if ($businessinfo !== null) echo $businessinfo['accountname']; ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group no-margin-bottom">
                                    <label class="col-sm-3 control-label no-padding-right"
                                           for="businessAccountMng_businessinfo_bank">开户行</label>
                                    <div class="form-group col-sm-9 no-padding no-margin-left no-margin-right">
                                        <div class="col-sm-12">
                                            <div class="col-sm-9 no-padding-left">
                                                <input class="form-control"
                                                       type="text"
                                                       id="businessAccountMng_businessinfo_bank"
                                                       name="businessAccountMng_businessinfo_bank"
                                                       placeholder="开户行"
                                                       value="<?php if ($businessinfo !== null) echo $businessinfo['bank']; ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="step-pane <?php if ($initflag === 2) echo 'active'; ?>" data-step="2">
                            <form class="form-horizontal">
                                <div class="form-group no-margin-bottom">
                                    <div class="col-sm-12">
                                        <div id="businessAccountMng_businessinfo_businesslicense_div"></div>
                                    </div>
                                </div>
                                <div class="form-group no-margin-bottom">
                                    <div class="col-sm-12">
                                        <div id="businessAccountMng_businessinfo_certpicture_div"></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="step-pane <?php if ($initflag === 3) echo 'active'; ?>" data-step="3">
                            <h1 class="grey lighter smaller center" style="margin-bottom: 50px">
                                <span class="green bigger-125">
                                    点击“下一步”正式注册B类账户 <i class="ace-icon fa fa-arrow-right"></i>
                                </span>
                            </h1>
                            <form class="form-horizontal">
                                <div class="form-group">
                                    <label class="col-sm-12 block clearfix center">
                                        <img id="businessAccountMng_businessinfo_yzm_img"
                                             class="yzm-img"
                                             src="<?php echo $GLOBALS['webroot'] . '/view/common/yzm?' . time() ?>"/>
                                    </label>
                                </div>
                                <div class="form-group no-margin-bottom">
                                    <label class="col-sm-6 control-label no-padding-right"
                                           for="businessAccountMng_businessinfo_yzm">输入上图验证码</label>
                                    <div class="col-sm-6">
                                        <span class="input-icon input-icon-right">
                                            <input class="input-medium" id="businessAccountMng_businessinfo_yzm"
                                                   name="businessAccountMng_businessinfo_yzm"
                                                   type="text" placeholder="输入验证码"/>
                                            <i class="ace-icon fa fa-qrcode"></i>
                                        </span>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="step-pane" data-step="4">
                            <div class="form-horizontal">
                                <div class="form-group">
                                    <div class="col-sm-10 col-sm-offset-1">
                                        <div
                                                class="col-sm-12 label label-info label-xlg label-success arrowed-in arrowed-in-right center no-padding-right">
                                            <b>B类账户注册成功</b>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-10 col-sm-offset-1">
                                        <div class="col-sm-12">
                                            <ul class="list-unstyled spaced bigger-125">
                                                <li>
                                                    <i class="ace-icon fa fa-caret-right green"></i>客户名称：<span
                                                            class="blue"
                                                            id="businessAccountMng_businessinfo_result_businessname"></span>
                                                </li>
                                                <li>
                                                    <i class="ace-icon fa fa-caret-right green"></i>客户号：<span
                                                            class="blue"
                                                            id="businessAccountMng_businessinfo_result_businessid"></span>
                                                </li>
                                                <li>
                                                    <i class="ace-icon fa fa-caret-right green"></i>渠道号：<span
                                                            class="blue"
                                                            id="businessAccountMng_businessinfo_result_channel"></span>
                                                </li>
                                                <li>
                                                    <i class="ace-icon fa fa-caret-right green"></i>B户客户id：<span
                                                            class="blue"
                                                            id="businessAccountMng_businessinfo_result_id"></span>
                                                </li>
                                                <li>
                                                    <i class="ace-icon fa fa-caret-right green"></i>B户安全校验key：<span
                                                            class="blue"
                                                            id="businessAccountMng_businessinfo_result_businesskey"></span>
                                                </li>
                                                <li>
                                                    <i class="ace-icon fa fa-caret-right green"></i>登录账号：<span
                                                            class="blue"
                                                            id="businessAccountMng_businessinfo_result_loginno"></span>
                                                </li>
                                                <li>
                                                    <i class="ace-icon fa fa-caret-right green"></i>登录密码：<span
                                                            class="blue"
                                                            id="businessAccountMng_businessinfo_result_password"></span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-10 col-sm-offset-1">
                                        <div class="col-sm-12">
                                            <table class="table table-striped table-bordered">
                                                <thead>
                                                <tr>
                                                    <th class="center">序号</th>
                                                    <th class="center">虚拟账户类型</th>
                                                    <th class="center hidden-xs">虚拟账户编码</th>
                                                    <th class="center">可用余额</th>
                                                    <th class="center">折算金额</th>
                                                    <th class="center hidden-480">创建时间</th>
                                                </tr>
                                                </thead>
                                                <tbody id="businessAccountMng_businessinfo_result_subaccountbody">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr/>
                <div class="wizard-actions">
                    <button class="btn btn-prev">
                        <i class="ace-icon fa fa-arrow-left"></i> 上一步
                    </button>
                    <button class="btn btn-success btn-next" data-last="注册成功">
                        下一步 <i class="ace-icon fa fa-arrow-right icon-on-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php require $_SERVER['DOCUMENT_ROOT'] . $GLOBALS['webroot'] . '/view/common/foot.php'; ?>
<script type="text/javascript" defer async="async"
        charset="<?php echo $GLOBALS['charset']; ?>"
        src="<?php echo $GLOBALS['webroot'] . '/script/page/account/businessAccountInfo.js?v=1.0.0'; ?>"></script>
</body>
</html>