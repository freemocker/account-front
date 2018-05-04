<?php
require dirname(__FILE__) . '/../common/pageHead.php';
?>
<html <?php echo $GLOBALS['html_attr'] ?>>
<head>
    <title>首页</title>
    <?php
    require $_SERVER['DOCUMENT_ROOT'] . $GLOBALS['webroot'] . '/view/common/head.php';
    $user = portal\service\tools\ToolsClass::getUser();
    $commonTools = new \service\tools\ToolsClass();
    ?>
</head>
<body class="<?php echo $GLOBALS['body_class']; ?>">
<div class="page-content no-padding-top">
    <!-- 内容 start -->
    <div class="row">
        <div class="col-xs-12">
            <div class="alert alert-block alert-success">
                <button type="button" class="close" data-dismiss="alert">
                    <i class="ace-icon fa fa-times"></i>
                </button>
                <i class="ace-icon fa fa-check green"></i> 欢迎使用 <strong
                    class="green"> <?php if ($GLOBALS['application']->getAppname() != null) {
                        echo $GLOBALS['application']->getAppname();
                    }
                    if ($GLOBALS['application']->getVersion() != null) {
                        echo '<small>(v' . $GLOBALS['application']->getVersion() . ')</small>';
                    } ?>
                </strong>
            </div>
        </div>
    </div>
    <div class="col-xs-12">
        <div class="col-sm-6">
            <div class="widget-box col-xs-12">
                <div class="widget-header widget-header-flat widget-header-small">
                    <h5 class="widget-title">
                        <i class="ace-icon fa fa-bar-chart-o"></i> 在线用户统计
                    </h5>
                    <div class="widget-toolbar">
                        <a href="#" data-action="fullscreen"
                           id="homepage_charts_fullscreen" class="orange2"> <i class="ace-icon fa fa-expand"></i>
                        </a> <a href="javascript:void(0)" data-action
                                id="homepage_charts_reload" style="color: #ACD392"> <i
                                class="ace-icon fa fa-refresh"></i>
                        </a> <a href="javascript:void(0)" data-action="collapse"
                                id="homepage_charts_collapse"> <i class="ace-icon fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="widget-body">
                    <div class="widget-main">
                        <div id="homepage_chart_onlineuser" style="height: 400px"></div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        if (service\user\UserManagerClass::validatePermissions($GLOBALS['application']->getId(), $user->getId(), 'back_cust_cash')
            || service\user\UserManagerClass::validatePermissions($GLOBALS['application']->getId(), $user->getId(), 'back_business_BalanceSettlement')
            || service\user\UserManagerClass::validatePermissions($GLOBALS['application']->getId(), $user->getId(), 'back_business_IntegralSettlement')
        ) {
            ?>
            <div class="col-sm-6">
                <div class="widget-box transparent col-xs-12">
                    <div class="widget-header widget-header-flat widget-header-small">
                        <h5 class="widget-title">
                            <i class="ace-icon fa fa-tasks"></i> 待审核订单
                        </h5>
                        <div class="widget-toolbar">
                            <a href="#" data-action="fullscreen" class="orange2"> <i
                                    class="ace-icon fa fa-expand"></i>
                            </a> <a href="javascript:void(0)" data-action="collapse"> <i
                                    class="ace-icon fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="widget-body">
                        <div class="widget-main">
                            <div id="homepage_tasks_list">
                                <ul class="list-unstyled spaced">
                                    <?php
                                    $revieworder = $commonTools->getDatasBySQL("select * from acc_dic_ordertype where status=1 and type='1'");
                                    foreach ($revieworder as $order) {
                                        ?>
                                        <li>
                                            <i class="ace-icon fa fa-caret-right blue"></i>
                                            <a href="javascript:void(0)"
                                               onclick="portal_tools_obj.gotoMenuPage('<?php echo $order['field2']; ?>')">
                                                <?php
                                                $num = $commonTools->getDatasBySQL("select count(orderno) as num from acc_order_base where ordertype=" . $order['code'] . " and status=12")[0]['num'];
                                                $num = intval($num);
                                                if ($num > 0) {
                                                    ?>
                                                    <i class="ace-icon fa fa-bell icon-animated-bell red"></i>
                                                    <?php
                                                }
                                                echo "&nbsp;" . $order['name'] . "--审核&nbsp;&nbsp;";
                                                if ($num > 0) {
                                                    ?>
                                                    <span class="badge badge-important"
                                                          style="margin-bottom: 2px;"><?php echo "+" . $num; ?></span>
                                                    <?php
                                                }
                                                ?>
                                            </a>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
    <!-- 内容 end -->
</div>
<?php require $_SERVER['DOCUMENT_ROOT'] . $GLOBALS['webroot'] . '/view/common/foot.php'; ?>
<script type="text/javascript" defer async="async"
        charset="<?php echo $GLOBALS['charset']; ?>"
        src="<?php echo $GLOBALS['webroot'] . '/script/home/home.js?v=1.0.0'; ?>"></script>
</body>
</html>