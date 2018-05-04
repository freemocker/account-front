<?php
/**
 * Created by PhpStorm.
 * User: zhangbin
 * Date: 2016/10/17
 * Time: 10:36
 */
require dirname(__FILE__) . '/../../../common/pageHead.php';
?>
<html <?php echo $GLOBALS['html_attr'] ?>>
<head>
    <title>订单详情</title>
    <?php
    require $_SERVER['DOCUMENT_ROOT'] . $GLOBALS['webroot'] . '/view/common/head.php';
    $diccommonTools = new \service\tools\ToolsClass();
    $commonTools = new \service\tools\ToolsClass(2);
    $orderno = $_REQUEST['orderno'];
    $tableyear = $_REQUEST['tableyear'];
    $orderInfo = $commonTools->getDatasBySQL("select o.* from acc_order_base_$tableyear o where o.orderno='" . $orderno . "'");
    ?>
</head>
<body class="<?php echo $GLOBALS['body_class']; ?>">
<div class="page-content no-padding-top">
    <?php if (count($orderInfo) == 0) { ?>
        <div class="col-sm-8 col-sm-offset-2 form-horizontal">
            <div class="form-group">
                <div class="col-xs-12 red">找不到订单信息</div>
            </div>
        </div>
    <?php } else {
        $orderInfo = $orderInfo[0];
        $ordertype = $diccommonTools->getDatasBySQL("select * from acc_dic_ordertype where code='" . $orderInfo['ordertype'] . "'");
        $orderInfo['ordertypename'] = $ordertype['name'];
        $orderInfo['tablename'] = $ordertype['field1'] . '_' . $tableyear;
        $orderstatus = $diccommonTools->getDatasBySQL("select * from acc_dic_orderstatus where code='" . $orderInfo['status'] . "'");
        $orderInfo['statusname'] = $ordertype['name'];
        $businessaccount = $diccommonTools->getDatasBySQL("select * from acc_business_account where channel='" . $orderInfo['channel'] . "'");
        $orderInfo['businesschannelname'] = $ordertype['businessname'];
        ?>
        <div class="col-sm-8 col-sm-offset-2" style="padding-top: 20px;">
            <input type="hidden" id="his_orderSearch_orderinfo_orderno"
                   value="<?php echo $orderno; ?>"/>
            <div class="infotable">
                <div class="infotable-caption bigger-120">订单信息</div>
                <div class="infotable-row">
                    <div class="infotable-cell title">订单号</div>
                    <div class="infotable-cell info">
                        <span class="editable-click infocontent">
                            <?php echo $orderInfo['orderno']; ?></span>
                    </div>
                </div>
                <div class="infotable-row">
                    <div class="infotable-cell title">订单类型</div>
                    <div class="infotable-cell info">
                        <span class="editable-click infocontent">
                            <?php echo $orderInfo['ordertypename']; ?></span>
                    </div>
                </div>
                <div class="infotable-row">
                    <div class="infotable-cell title">商户交易号</div>
                    <div class="infotable-cell info">
                        <span class="editable-click infocontent">
                            <?php echo $orderInfo['businesstradeno']; ?></span>
                    </div>
                </div>
                <div class="infotable-row">
                    <div class="infotable-cell title">B户客户号</div>
                    <div class="infotable-cell info">
                        <span class="editable-click infocontent">
                            <?php echo $orderInfo['businessid']; ?></span>
                    </div>
                </div>
                <div class="infotable-row">
                    <div class="infotable-cell title">C户客户号</div>
                    <div class="infotable-cell info">
                        <span class="editable-click infocontent">
                            <?php echo $orderInfo['custid']; ?></span>
                    </div>
                </div>
                <div class="infotable-row">
                    <div class="infotable-cell title">支付方式</div>
                    <div class="infotable-cell info">
                        <span class="editable-click infocontent">
                            <?php echo $orderInfo['paytypename']; ?></span>
                    </div>
                </div>
                <div class="infotable-row">
                    <div class="infotable-cell title">交易渠道号</div>
                    <div class="infotable-cell info">
                    <span class="editable-click infocontent">
                            <?php echo $orderInfo['channel']; ?></span>
                    </div>
                </div>
                <div class="infotable-row">
                    <div class="infotable-cell title">渠道名称</div>
                    <div class="infotable-cell info">
                    <span class="editable-click infocontent">
                            <?php echo $orderInfo['businesschannelname']; ?></span>
                    </div>
                </div>
                <div class="infotable-row">
                    <div class="infotable-cell title">订单额</div>
                    <div class="infotable-cell info">
                    <span class="editable-click infocontent blue">
                            <?php echo $orderInfo['amont']; ?></span>
                    </div>
                </div>
                <div class="infotable-row">
                    <div class="infotable-cell title">实际交易额比例</div>
                    <div class="infotable-cell info">
                    <span class="editable-click infocontent blue">
                            <?php echo $orderInfo['ratio']; ?></span>
                    </div>
                </div>
                <div class="infotable-row">
                    <div class="infotable-cell title">交易金额</div>
                    <div class="infotable-cell info">
                    <span class="editable-click infocontent blue">
                            <?php echo $orderInfo['actamont']; ?></span>
                    </div>
                </div>
                <div class="infotable-row">
                    <div class="infotable-cell title">会计日期</div>
                    <div class="infotable-cell info">
                    <span class="editable-click infocontent">
                            <?php echo $orderInfo['accountdate']; ?></span>
                    </div>
                </div>
                <div class="infotable-row">
                    <div class="infotable-cell title">会计出账日期</div>
                    <div class="infotable-cell info">
                    <span class="editable-click infocontent">
                            <?php echo $orderInfo['statementdate']; ?></span>
                    </div>
                </div>
                <div class="infotable-row">
                    <div class="infotable-cell title">会计扎账日期</div>
                    <div class="infotable-cell info">
                    <span class="editable-click infocontent">
                            <?php echo $orderInfo['bindaccountdate']; ?></span>
                    </div>
                </div>
                <div class="infotable-row">
                    <div class="infotable-cell title">下单时间</div>
                    <div class="infotable-cell info">
                    <span class="editable-click infocontent">
                            <?php echo $orderInfo['createdate']; ?></span>
                    </div>
                </div>
                <div class="infotable-row">
                    <div class="infotable-cell title">订单描述</div>
                    <div class="infotable-cell info">
                    <span class="editable-click infocontent">
                            <?php echo $orderInfo['description']; ?></span>
                    </div>
                </div>
                <div class="infotable-row">
                    <div class="infotable-cell title">订单状态</div>
                    <div class="infotable-cell info">
                    <span class="editable-click infocontent
                    <?php if (preg_match("/3$/i", $orderInfo['status']) == 1) {
                        echo "green";
                    } else if (preg_match("/0|1|2$/i", $orderInfo['status']) == 1) {
                        echo "blue";
                    } else {
                        echo "red";
                    } ?>">
                        <?php echo $orderInfo['statusname']; ?></span>
                    </div>
                </div>
                <div class="infotable-row">
                    <div class="infotable-cell title">第三方交易号</div>
                    <div class="infotable-cell info">
                    <span class="editable-click infocontent">
                            <?php echo $orderInfo['tradeno']; ?></span>
                    </div>
                </div>
                <div class="infotable-row">
                    <div class="infotable-cell title">第三方交易状态</div>
                    <div class="infotable-cell info">
                    <span class="editable-click infocontent">
                            <?php echo $orderInfo['tradestatus']; ?></span>
                    </div>
                </div>
                <div class="infotable-row">
                    <div class="infotable-cell title">第三方通知时间</div>
                    <div class="infotable-cell info">
                    <span class="editable-click infocontent">
                            <?php echo $orderInfo['notifydate']; ?></span>
                    </div>
                </div>
                <div class="infotable-row">
                    <div class="infotable-cell title">最后修改时间</div>
                    <div class="infotable-cell info">
                    <span class="editable-click infocontent">
                            <?php echo $orderInfo['lastmodifydate']; ?></span>
                    </div>
                </div>
                <div class="infotable-row">
                    <div class="infotable-cell title">已退额</div>
                    <div class="infotable-cell info">
                    <span class="editable-click infocontent red">
                            <?php echo $orderInfo['refundamont']; ?></span>
                    </div>
                </div>
                <div class="infotable-row">
                    <div class="infotable-cell title">已退金额</div>
                    <div class="infotable-cell info">
                    <span class="editable-click infocontent red">
                            <?php echo $orderInfo['refundactamont']; ?></span>
                    </div>
                </div>
                <?php
                for ($i = 1; $i <= 10; $i++) {
                    ?>
                    <div class="infotable-row">
                        <div class="infotable-cell title">扩展额<?php echo $i; ?></div>
                        <div class="infotable-cell info">
                    <span class="editable-click infocontent blue">
                            <?php echo $orderInfo['extamont' . $i]; ?></span>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
            <div class="infotable">
                <?php
                $tablename = $orderInfo['tablename'];
                $customerInfo = $commonTools->getDatasBySQL("select * from " . $tablename . " where orderno='" . $orderno . "'");
                if (count($customerInfo) > 0) {
                    $customerInfo = $customerInfo[0];
                    if (preg_match("/^1[0-9]{2}$/i", $orderInfo['ordertype']) == 1) {//余额订单
                        echo '<div class="infotable-caption bigger-120">余额信息</div>';
                        ?>
                        <div class="infotable-row">
                            <div class="infotable-cell title">订单发生前余额</div>
                            <div class="infotable-cell info">
                                <span class="editable-click infocontent blue">
                                    <?php echo $customerInfo['beforebalance']; ?></span>
                            </div>
                        </div>
                        <div class="infotable-row">
                            <div class="infotable-cell title">订单发生后余额</div>
                            <div class="infotable-cell info">
                                <span class="editable-click infocontent blue">
                                    <?php echo $customerInfo['afterbalance']; ?></span>
                            </div>
                        </div>
                        <?php
                        if ($orderInfo['ordertype'] == '101') {
                            ?>
                            <div class="infotable-row">
                                <div class="infotable-cell title">B户收款前余额</div>
                                <div class="infotable-cell info">
                                <span class="editable-click infocontent blue">
                                    <?php echo $customerInfo['recebeforebalance']; ?></span>
                                </div>
                            </div>
                            <div class="infotable-row">
                                <div class="infotable-cell title">B户收款后余额</div>
                                <div class="infotable-cell info">
                                <span class="editable-click infocontent blue">
                                    <?php echo $customerInfo['receafterbalance']; ?></span>
                                </div>
                            </div>
                            <?php
                        } else if ($orderInfo['ordertype'] == '102') {
                            ?>
                            <div class="infotable-row">
                                <div class="infotable-cell title">原支付订单号</div>
                                <div class="infotable-cell info">
                                    <span class="editable-click infocontent">
                                        <?php echo $customerInfo['origorderno']; ?></span>
                                </div>
                            </div>
                            <div class="infotable-row">
                                <div class="infotable-cell title">原支付订单状态</div>
                                <div class="infotable-cell info">
                                    <span class="editable-click infocontent">
                                        <?php echo $commonTools->getDatasBySQL("select name from acc_dic_orderstatus where code='" . $customerInfo['origstatus'] . "'")[0]['name']; ?></span>
                                </div>
                            </div>
                            <div class="infotable-row">
                                <div class="infotable-cell title">退款时间</div>
                                <div class="infotable-cell info">
                                    <span class="editable-click infocontent">
                                        <?php echo $customerInfo['refunddate']; ?></span>
                                </div>
                            </div>
                            <div class="infotable-row">
                                <div class="infotable-cell title">退款原因</div>
                                <div class="infotable-cell info">
                                    <span class="editable-click infocontent">
                                        <?php echo $customerInfo['reason']; ?></span>
                                </div>
                            </div>
                            <div class="infotable-row">
                                <div class="infotable-cell title">B户退款前余额</div>
                                <div class="infotable-cell info">
                                <span class="editable-click infocontent blue">
                                    <?php echo $customerInfo['recebeforebalance']; ?></span>
                                </div>
                            </div>
                            <div class="infotable-row">
                                <div class="infotable-cell title">B户退款后余额</div>
                                <div class="infotable-cell info">
                                <span class="editable-click infocontent blue">
                                    <?php echo $customerInfo['receafterbalance']; ?></span>
                                </div>
                            </div>
                            <?php
                        } else if ($orderInfo['ordertype'] == '103') {
                            ?>
                            <div class="infotable-row">
                                <div class="infotable-cell title">第三方id</div>
                                <div class="infotable-cell info">
                                    <span class="editable-click infocontent">
                                        <?php echo $customerInfo['buyerid']; ?></span>
                                </div>
                            </div>
                            <div class="infotable-row">
                                <div class="infotable-cell title">银行卡开户名称</div>
                                <div class="infotable-cell info">
                                    <span class="editable-click infocontent">
                                        <?php echo $customerInfo['buyername']; ?></span>
                                </div>
                            </div>
                            <div class="infotable-row">
                                <div class="infotable-cell title">第三方账号名</div>
                                <div class="infotable-cell info">
                                    <span class="editable-click infocontent">
                                        <?php echo $customerInfo['buyeraccount']; ?></span>
                                </div>
                            </div>
                            <div class="infotable-row">
                                <div class="infotable-cell title">支付时间</div>
                                <div class="infotable-cell info">
                                    <span class="editable-click infocontent">
                                        <?php echo $customerInfo['paydate']; ?></span>
                                </div>
                            </div>
                            <?php
                        } else if ($orderInfo['ordertype'] == '104') {
                            ?>
                            <div class="infotable-row">
                                <div class="infotable-cell title">收款方客户号</div>
                                <div class="infotable-cell info">
                                    <span class="editable-click infocontent">
                                        <?php echo $customerInfo['rececustid']; ?></span>
                                </div>
                            </div>
                            <div class="infotable-row">
                                <div class="infotable-cell title">收款前余额</div>
                                <div class="infotable-cell info">
                                    <span class="editable-click infocontent blue">
                                        <?php echo $customerInfo['recebeforebalance']; ?></span>
                                </div>
                            </div>
                            <div class="infotable-row">
                                <div class="infotable-cell title">收款后余额</div>
                                <div class="infotable-cell info">
                                    <span class="editable-click infocontent blue">
                                        <?php echo $customerInfo['receafterbalance']; ?></span>
                                </div>
                            </div>
                            <div class="infotable-row">
                                <div class="infotable-cell title">转账时间</div>
                                <div class="infotable-cell info">
                                    <span class="editable-click infocontent">
                                        <?php echo $customerInfo['transferdate']; ?></span>
                                </div>
                            </div>
                            <?php
                        } else if ($orderInfo['ordertype'] == '105') {
                            ?>
                            <div class="infotable-row">
                                <div class="infotable-cell title">账户类型</div>
                                <div class="infotable-cell info">
                                    <span class="editable-click infocontent blue">
                                        <?php echo $commonTools->getDatasBySQL("select name from acc_dic_c_bindtype where code='" . $customerInfo['cbindtype'] . "'")[0]['name']; ?></span>
                                </div>
                            </div>
                            <?php
                            if ($customerInfo['cbindtype'] == 'BANKCARD') { ?>
                                <div class="infotable-row">
                                    <div class="infotable-cell title">开户行</div>
                                    <div class="infotable-cell info">
                                    <span class="editable-click infocontent red">
                                        <?php echo $customerInfo['buyerbankname']; ?></span>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="infotable-row">
                                <div class="infotable-cell title">账户名称</div>
                                <div class="infotable-cell info">
                                    <span class="editable-click infocontent red">
                                        <?php echo $customerInfo['buyername']; ?></span>
                                </div>
                            </div>
                            <div class="infotable-row">
                                <div class="infotable-cell title">账号</div>
                                <div class="infotable-cell info">
                                    <span class="editable-click infocontent red">
                                        <?php echo $customerInfo['buyeraccount']; ?></span>
                                </div>
                            </div>
                            <div class="infotable-row">
                                <div class="infotable-cell title">提现时间</div>
                                <div class="infotable-cell info">
                                    <span class="editable-click infocontent">
                                        <?php echo $customerInfo['cashdate']; ?></span>
                                </div>
                            </div>
                            <div class="infotable-row">
                                <div class="infotable-cell title">附加说明</div>
                                <div class="infotable-cell info">
                                    <span class="editable-click infocontent">
                                        <?php echo $customerInfo['remark']; ?></span>
                                </div>
                            </div>
                            <?php
                        } else if ($orderInfo['ordertype'] == '106') {
                            ?>
                            <div class="infotable-row">
                                <div class="infotable-cell title">账户类型</div>
                                <div class="infotable-cell info">
                                    <span class="editable-click infocontent blue">
                                        <?php echo $commonTools->getDatasBySQL("select name from acc_dic_b_bindtype where code='" . $customerInfo['bbindtype'] . "'")[0]['name']; ?></span>
                                </div>
                            </div>
                            <?php
                            if ($customerInfo['bbindtype'] == 'BANKCARD') { ?>
                                <div class="infotable-row">
                                    <div class="infotable-cell title">开户行</div>
                                    <div class="infotable-cell info">
                                    <span class="editable-click infocontent red">
                                        <?php echo $customerInfo['buyerbankname']; ?></span>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="infotable-row">
                                <div class="infotable-cell title">账户名称</div>
                                <div class="infotable-cell info">
                                    <span class="editable-click infocontent red">
                                        <?php echo $customerInfo['buyername']; ?></span>
                                </div>
                            </div>
                            <div class="infotable-row">
                                <div class="infotable-cell title">账号</div>
                                <div class="infotable-cell info">
                                    <span class="editable-click infocontent red">
                                        <?php echo $customerInfo['buyeraccount']; ?></span>
                                </div>
                            </div>
                            <div class="infotable-row">
                                <div class="infotable-cell title">结算时间</div>
                                <div class="infotable-cell info">
                                    <span class="editable-click infocontent">
                                        <?php echo $customerInfo['settlementdate']; ?></span>
                                </div>
                            </div>
                            <div class="infotable-row">
                                <div class="infotable-cell title">附加说明</div>
                                <div class="infotable-cell info">
                                    <span class="editable-click infocontent">
                                        <?php echo $customerInfo['remark']; ?></span>
                                </div>
                            </div>
                            <?php
                        }
                    } else if (preg_match("/^2[0-9]{2}$/i", $orderInfo['ordertype']) == 1) {//非余额订单
                        echo '<div class="infotable-caption bigger-120">第三方信息</div>';
                        ?>
                        <div class="infotable-row">
                            <div class="infotable-cell title">第三方id</div>
                            <div class="infotable-cell info">
                                    <span class="editable-click infocontent">
                                        <?php echo $customerInfo['buyerid']; ?></span>
                            </div>
                        </div>
                        <div class="infotable-row">
                            <div class="infotable-cell title">银行卡开户名称</div>
                            <div class="infotable-cell info">
                                    <span class="editable-click infocontent">
                                        <?php echo $customerInfo['buyername']; ?></span>
                            </div>
                        </div>
                        <div class="infotable-row">
                            <div class="infotable-cell title">第三方账号名</div>
                            <div class="infotable-cell info">
                                    <span class="editable-click infocontent">
                                        <?php echo $customerInfo['buyeraccount']; ?></span>
                            </div>
                        </div>
                        <?php
                        if ($orderInfo['ordertype'] == '201') {
                            ?>
                            <div class="infotable-row">
                                <div class="infotable-cell title">支付时间</div>
                                <div class="infotable-cell info">
                                    <span class="editable-click infocontent">
                                        <?php echo $customerInfo['paydate']; ?></span>
                                </div>
                            </div>
                            <?php
                        } else if ($orderInfo['ordertype'] == '202') {
                            ?>
                            <div class="infotable-row">
                                <div class="infotable-cell title">原支付订单号</div>
                                <div class="infotable-cell info">
                                    <span class="editable-click infocontent">
                                        <?php echo $customerInfo['origorderno']; ?></span>
                                </div>
                            </div>
                            <div class="infotable-row">
                                <div class="infotable-cell title">原支付订单状态</div>
                                <div class="infotable-cell info">
                                    <span class="editable-click infocontent">
                                        <?php echo $commonTools->getDatasBySQL("select name from acc_dic_orderstatus where code='" . $customerInfo['origstatus'] . "'")[0]['name']; ?></span>
                                </div>
                            </div>
                            <div class="infotable-row">
                                <div class="infotable-cell title">退款时间</div>
                                <div class="infotable-cell info">
                                    <span class="editable-click infocontent">
                                        <?php echo $customerInfo['refunddate']; ?></span>
                                </div>
                            </div>
                            <div class="infotable-row">
                                <div class="infotable-cell title">退款原因</div>
                                <div class="infotable-cell info">
                                    <span class="editable-click infocontent">
                                        <?php echo $customerInfo['reason']; ?></span>
                                </div>
                            </div>
                            <?php
                        } else if ($orderInfo['ordertype'] == '204') {
                            ?>
                            <div class="infotable-row">
                                <div class="infotable-cell title">收款人账户类型</div>
                                <div class="infotable-cell info">
                                    <span class="editable-click infocontent blue">
                                        <?php echo $commonTools->getDatasBySQL("select name from acc_dic_c_bindtype where code='" . $customerInfo['recetype'] . "'")[0]['name']; ?></span>
                                </div>
                            </div>
                            <div class="infotable-row">
                                <div class="infotable-cell title">收款人id</div>
                                <div class="infotable-cell info">
                                    <span class="editable-click infocontent">
                                        <?php echo $customerInfo['recebankname']; ?></span>
                                </div>
                            </div>
                            <div class="infotable-row">
                                <div class="infotable-cell title">银行卡开户名称</div>
                                <div class="infotable-cell info">
                                    <span class="editable-click infocontent">
                                        <?php echo $customerInfo['recename']; ?></span>
                                </div>
                            </div>
                            <div class="infotable-row">
                                <div class="infotable-cell title">收款人账号名</div>
                                <div class="infotable-cell info">
                                    <span class="editable-click infocontent">
                                        <?php echo $customerInfo['receaccount']; ?></span>
                                </div>
                            </div>
                            <div class="infotable-row">
                                <div class="infotable-cell title">转账时间</div>
                                <div class="infotable-cell info">
                                    <span class="editable-click infocontent">
                                        <?php echo $customerInfo['transferdate']; ?></span>
                                </div>
                            </div>
                            <?php
                        }
                    } else if (preg_match("/^3[0-9]{2}$/i", $orderInfo['ordertype']) == 1) {//积分订单
                        echo '<div class="infotable-caption bigger-120">积分信息</div>';
                        ?>
                        <div class="infotable-row">
                            <div class="infotable-cell title">订单发生前积分</div>
                            <div class="infotable-cell info">
                                <span class="editable-click infocontent blue">
                                    <?php echo $customerInfo['beforebalance']; ?></span>
                            </div>
                        </div>
                        <div class="infotable-row">
                            <div class="infotable-cell title">订单发生后积分</div>
                            <div class="infotable-cell info">
                                <span class="editable-click infocontent blue">
                                    <?php echo $customerInfo['afterbalance']; ?></span>
                            </div>
                        </div>
                        <?php
                        if ($orderInfo['ordertype'] == '301') {
                            ?>
                            <div class="infotable-row">
                                <div class="infotable-cell title">折算比例</div>
                                <div class="infotable-cell info">
                                    <span class="editable-click infocontent red">
                                        <?php echo $orderInfo['ratio']; ?></span>
                                </div>
                            </div>
                            <div class="infotable-row">
                                <div class="infotable-cell title">折算金额</div>
                                <div class="infotable-cell info">
                                    <span class="editable-click infocontent red">
                                        <?php echo $orderInfo['actamont']; ?></span>
                                </div>
                            </div>
                            <div class="infotable-row">
                                <div class="infotable-cell title">B户收款前余额</div>
                                <div class="infotable-cell info">
                                <span class="editable-click infocontent blue">
                                    <?php echo $customerInfo['recebeforebalance']; ?></span>
                                </div>
                            </div>
                            <div class="infotable-row">
                                <div class="infotable-cell title">B户收款后余额</div>
                                <div class="infotable-cell info">
                                <span class="editable-click infocontent blue">
                                    <?php echo $customerInfo['receafterbalance']; ?></span>
                                </div>
                            </div>
                            <div class="infotable-row">
                                <div class="infotable-cell title">消费时间</div>
                                <div class="infotable-cell info">
                                    <span class="editable-click infocontent">
                                        <?php echo $customerInfo['paydate']; ?></span>
                                </div>
                            </div>
                            <?php
                        } else if ($orderInfo['ordertype'] == '302') {
                            ?>
                            <div class="infotable-row">
                                <div class="infotable-cell title">原支付订单号</div>
                                <div class="infotable-cell info">
                                    <span class="editable-click infocontent">
                                        <?php echo $customerInfo['origorderno']; ?></span>
                                </div>
                            </div>
                            <div class="infotable-row">
                                <div class="infotable-cell title">原支付订单状态</div>
                                <div class="infotable-cell info">
                                    <span class="editable-click infocontent">
                                        <?php echo $commonTools->getDatasBySQL("select name from acc_dic_orderstatus where code='" . $customerInfo['origstatus'] . "'")[0]['name']; ?></span>
                                </div>
                            </div>
                            <div class="infotable-row">
                                <div class="infotable-cell title">折算比例</div>
                                <div class="infotable-cell info">
                                    <span class="editable-click infocontent red">
                                        <?php echo $orderInfo['ratio']; ?></span>
                                </div>
                            </div>
                            <div class="infotable-row">
                                <div class="infotable-cell title">折算金额</div>
                                <div class="infotable-cell info">
                                    <span class="editable-click infocontent red">
                                        <?php echo $orderInfo['actamont']; ?></span>
                                </div>
                            </div>
                            <div class="infotable-row">
                                <div class="infotable-cell title">退款时间</div>
                                <div class="infotable-cell info">
                                    <span class="editable-click infocontent">
                                        <?php echo $customerInfo['refunddate']; ?></span>
                                </div>
                            </div>
                            <div class="infotable-row">
                                <div class="infotable-cell title">退款原因</div>
                                <div class="infotable-cell info">
                                    <span class="editable-click infocontent">
                                        <?php echo $customerInfo['reason']; ?></span>
                                </div>
                            </div>
                            <div class="infotable-row">
                                <div class="infotable-cell title">B户退款前余额</div>
                                <div class="infotable-cell info">
                                <span class="editable-click infocontent blue">
                                    <?php echo $customerInfo['recebeforebalance']; ?></span>
                                </div>
                            </div>
                            <div class="infotable-row">
                                <div class="infotable-cell title">B户退款后余额</div>
                                <div class="infotable-cell info">
                                <span class="editable-click infocontent blue">
                                    <?php echo $customerInfo['receafterbalance']; ?></span>
                                </div>
                            </div>
                            <?php
                        } else if ($orderInfo['ordertype'] == '303') {
                            ?>
                            <div class="infotable-row">
                                <div class="infotable-cell title">积分获取时间</div>
                                <div class="infotable-cell info">
                                    <span class="editable-click infocontent">
                                        <?php echo $customerInfo['rechargedate']; ?></span>
                                </div>
                            </div>
                            <?php
                        } else if ($orderInfo['ordertype'] == '306') {
                            ?>
                            <div class="infotable-row">
                                <div class="infotable-cell title">账户类型</div>
                                <div class="infotable-cell info">
                                    <span class="editable-click infocontent blue">
                                        <?php echo $commonTools->getDatasBySQL("select name from acc_dic_b_bindtype where code='" . $customerInfo['bbindtype'] . "'")[0]['name']; ?></span>
                                </div>
                            </div>
                            <?php
                            if ($customerInfo['bbindtype'] == 'BANKCARD') { ?>
                                <div class="infotable-row">
                                    <div class="infotable-cell title">开户行</div>
                                    <div class="infotable-cell info">
                                    <span class="editable-click infocontent red">
                                        <?php echo $customerInfo['buyerbankname']; ?></span>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="infotable-row">
                                <div class="infotable-cell title">账户名称</div>
                                <div class="infotable-cell info">
                                    <span class="editable-click infocontent red">
                                        <?php echo $customerInfo['buyername']; ?></span>
                                </div>
                            </div>
                            <div class="infotable-row">
                                <div class="infotable-cell title">账号</div>
                                <div class="infotable-cell info">
                                    <span class="editable-click infocontent red">
                                        <?php echo $customerInfo['buyeraccount']; ?></span>
                                </div>
                            </div>
                            <div class="infotable-row">
                                <div class="infotable-cell title">结算金额</div>
                                <div class="infotable-cell info">
                                    <span class="editable-click infocontent red">
                                        <?php echo $customerInfo['money']; ?></span>
                                </div>
                            </div>
                            <div class="infotable-row">
                                <div class="infotable-cell title">结算时间</div>
                                <div class="infotable-cell info">
                                    <span class="editable-click infocontent">
                                        <?php echo $customerInfo['settlementdate']; ?></span>
                                </div>
                            </div>
                            <div class="infotable-row">
                                <div class="infotable-cell title">附加说明</div>
                                <div class="infotable-cell info">
                                    <span class="editable-click infocontent">
                                        <?php echo $customerInfo['remark']; ?></span>
                                </div>
                            </div>
                            <?php
                        }
                    } else if (preg_match("/^4[0-9]{2}$/i", $orderInfo['ordertype']) == 1) {//电子券订单
                        echo '<div class="infotable-caption bigger-120">电子券信息</div>';
                        ?>
                        <div class="infotable-row">
                            <div class="infotable-cell title">名称</div>
                            <div class="infotable-cell info">
                                <span class="editable-click infocontent blue">
                                    <?php echo $customerInfo['currencyname']; ?></span>
                            </div>
                        </div>
                        <?php
                        if ($orderInfo['ordertype'] == '401') {
                            ?>
                            <div class="infotable-row">
                                <div class="infotable-cell title">消费时间</div>
                                <div class="infotable-cell info">
                                    <span class="editable-click infocontent">
                                        <?php echo $customerInfo['paydate']; ?></span>
                                </div>
                            </div>
                            <?php
                        } else if ($orderInfo['ordertype'] == '402') {
                            ?>
                            <div class="infotable-row">
                                <div class="infotable-cell title">原支付订单号</div>
                                <div class="infotable-cell info">
                                    <span class="editable-click infocontent">
                                        <?php echo $customerInfo['origorderno']; ?></span>
                                </div>
                            </div>
                            <div class="infotable-row">
                                <div class="infotable-cell title">原支付订单状态</div>
                                <div class="infotable-cell info">
                                    <span class="editable-click infocontent">
                                        <?php echo $commonTools->getDatasBySQL("select name from acc_dic_orderstatus where code='" . $customerInfo['origstatus'] . "'")[0]['name']; ?></span>
                                </div>
                            </div>
                            <div class="infotable-row">
                                <div class="infotable-cell title">退款时间</div>
                                <div class="infotable-cell info">
                                    <span class="editable-click infocontent">
                                        <?php echo $customerInfo['refunddate']; ?></span>
                                </div>
                            </div>
                            <div class="infotable-row">
                                <div class="infotable-cell title">退款原因</div>
                                <div class="infotable-cell info">
                                    <span class="editable-click infocontent">
                                        <?php echo $customerInfo['reason']; ?></span>
                                </div>
                            </div>
                            <?php
                        } else if ($orderInfo['ordertype'] == '403') {
                            ?>
                            <div class="infotable-row">
                                <div class="infotable-cell title">入账时间</div>
                                <div class="infotable-cell info">
                                    <span class="editable-click infocontent">
                                        <?php echo $customerInfo['paydate']; ?></span>
                                </div>
                            </div>
                            <?php
                        }
                    } else if (preg_match("/^5[0-9]{2}$/i", $orderInfo['ordertype']) == 1) {//二级商户订单
                        echo '<div class="infotable-caption bigger-120">二级商户信息</div>';
                        ?>
                        <div class="infotable-row">
                            <div class="infotable-cell title">商户编号</div>
                            <div class="infotable-cell info">
                                <span class="editable-click infocontent blue">
                                    <?php echo $customerInfo['shopno']; ?></span>
                            </div>
                        </div>
                        <?php
                        if ($orderInfo['ordertype'] == '506') {
                            ?>
                            <div class="infotable-row">
                                <div class="infotable-cell title">结算账户类型</div>
                                <div class="infotable-cell info">
                                    <span class="editable-click infocontent">
                                        <?php echo $customerInfo['accounttype']; ?></span>
                                </div>
                            </div>
                            <div class="infotable-row">
                                <div class="infotable-cell title">开户行名称</div>
                                <div class="infotable-cell info">
                                    <span class="editable-click infocontent">
                                        <?php echo $customerInfo['bankname']; ?></span>
                                </div>
                            </div>
                            <div class="infotable-row">
                                <div class="infotable-cell title">客户名称</div>
                                <div class="infotable-cell info">
                                    <span class="editable-click infocontent">
                                        <?php echo $customerInfo['accountname']; ?></span>
                                </div>
                            </div>
                            <div class="infotable-row">
                                <div class="infotable-cell title">客户账号</div>
                                <div class="infotable-cell info">
                                    <span class="editable-click infocontent">
                                        <?php echo $customerInfo['account']; ?></span>
                                </div>
                            </div>
                            <div class="infotable-row">
                                <div class="infotable-cell title">费率</div>
                                <div class="infotable-cell info">
                                    <span class="editable-click infocontent red">
                                        <?php echo $customerInfo['rate']; ?></span>
                                </div>
                            </div>
                            <div class="infotable-row">
                                <div class="infotable-cell title">商户计划结算时间</div>
                                <div class="infotable-cell info">
                                    <span class="editable-click infocontent">
                                        <?php echo $customerInfo['plansettlementdate']; ?></span>
                                </div>
                            </div>
                            <div class="infotable-row">
                                <div class="infotable-cell title">结算时间</div>
                                <div class="infotable-cell info">
                                    <span class="editable-click infocontent">
                                        <?php echo $customerInfo['settlementdate']; ?></span>
                                </div>
                            </div>
                            <div class="infotable-row">
                                <div class="infotable-cell title">附加说明</div>
                                <div class="infotable-cell info">
                                    <span class="editable-click infocontent">
                                        <?php echo $customerInfo['remark']; ?></span>
                                </div>
                            </div>
                            <?php
                        }
                    } else if (preg_match("/^80[0-9]{2}$/i", $orderInfo['ordertype']) == 1) {//通用记账订单
                        echo '<div class="infotable-caption bigger-120">通用记账信息</div>';
                        if ($orderInfo['ordertype'] == '8099') {//B户通用记账
                            ?>
                            <div class="infotable-row">
                                <div class="infotable-cell title">二级商户编号</div>
                                <div class="infotable-cell info">
                                <span class="editable-click infocontent blue">
                                    <?php echo $customerInfo['shopno']; ?></span>
                                </div>
                            </div>
                            <div class="infotable-row">
                                <div class="infotable-cell title">交易描述</div>
                                <div class="infotable-cell info">
                                    <span class="editable-click infocontent">
                                        <?php echo $customerInfo['tradedescription']; ?></span>
                                </div>
                            </div>
                            <?php
                            for ($i = 1; $i <= 20; $i++) {
                                ?>
                                <div class="infotable-row">
                                    <div class="infotable-cell title">扩展字段<?php echo $i; ?></div>
                                    <div class="infotable-cell info">
                                        <span class="editable-click infocontent blue">
                                            <?php echo $orderInfo['reserve' . $i]; ?></span>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                    } else if (preg_match("/^9[0-9]{3}$/i", $orderInfo['ordertype']) == 1) {//内部特殊交易
                        echo '<div class="infotable-caption bigger-120">特殊交易信息</div>';
                        ?>
                        <div class="infotable-row">
                            <div class="infotable-cell title">交易类型</div>
                            <div class="infotable-cell info">
                                <span class="editable-click infocontent blue">
                                    <?php echo $customerInfo['tradetypename']; ?></span>
                            </div>
                        </div>
                        <div class="infotable-row">
                            <div class="infotable-cell title">交易描述</div>
                            <div class="infotable-cell info">
                                    <span class="editable-click infocontent">
                                        <?php echo $customerInfo['tradedescription']; ?></span>
                            </div>
                        </div>
                        <div class="infotable-row">
                            <div class="infotable-cell title">原订单号</div>
                            <div class="infotable-cell info">
                                    <span class="editable-click infocontent">
                                        <?php echo $customerInfo['origorderno']; ?></span>
                            </div>
                        </div>
                        <div class="infotable-row">
                            <div class="infotable-cell title">原订单类型</div>
                            <div class="infotable-cell info">
                                <span class="editable-click infocontent">
                                    <?php echo $commonTools->getDatasBySQL("select name from acc_dic_ordertype where code='" . $customerInfo['origordertype'] . "'")[0]['name']; ?></span>
                            </div>
                        </div>
                        <div class="infotable-row">
                            <div class="infotable-cell title">原订单状态</div>
                            <div class="infotable-cell info">
                                <span class="editable-click infocontent">
                                    <?php echo $commonTools->getDatasBySQL("select name from acc_dic_orderstatus where code='" . $customerInfo['origstatus'] . "'")[0]['name']; ?></span>
                            </div>
                        </div>
                        <?php
                        for ($i = 1; $i <= 10; $i++) {
                            ?>
                            <div class="infotable-row">
                                <div class="infotable-cell title">扩展字段<?php echo $i; ?></div>
                                <div class="infotable-cell info">
                                        <span class="editable-click infocontent blue">
                                            <?php echo $orderInfo['reserve' . $i]; ?></span>
                                </div>
                            </div>
                            <?php
                        }
                    }
                } else {
                    ?>
                    <div class="col-sm-8 col-sm-offset-2 form-horizontal">
                        <div class="form-group">
                            <div class="col-xs-12 red">找不到订单信息</div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
            <?php
            $itemflows = $commonTools->getDatasBySQL("select * from acc_entry_itemflow_" . $tableyear . " where orderno='" . $orderno . "' order by balancedirect asc,businessid,createdate desc");
            if (count($itemflows) > 0) {
                ?>
                <hr>
                <div class="infotable-horizontal" style="margin-bottom: 20px">
                    <div class="infotable-caption bigger-120">科目流水</div>
                    <div class="infotable-row">
                        <div class="infotable-cell title">B户客户号</div>
                        <div class="infotable-cell title">科目名称</div>
                        <div class="infotable-cell title">科目账户</div>
                        <div class="infotable-cell title">借贷方向</div>
                        <div class="infotable-cell title">发生额</div>
                        <div class="infotable-cell title">创建时间</div>
                    </div>
                    <?php foreach ($itemflows as $itemflow) { ?>
                        <div class="infotable-row">
                            <div class="infotable-cell info">
                                <span class="editable-click infocontent">
                                    <?php echo $itemflow['businessid']; ?></span>
                            </div>
                            <div class="infotable-cell info">
                                <span class="editable-click infocontent">
                                    <?php echo $itemflow['accountitemthirdname']; ?></span>
                            </div>
                            <div class="infotable-cell info">
                                <span class="editable-click infocontent">
                                    <?php echo $itemflow['accountsubitemname']; ?></span>
                            </div>
                            <div class="infotable-cell info align-center">
                                <?php echo $itemflow['balancedirect'] == '1' ? '<span class="editable-click infocontent green">借</span>' : '<span class="editable-click infocontent red">贷</span>'; ?>
                            </div>
                            <div class="infotable-cell info align-center">
                                <span class="editable-click infocontent">
                                    <?php echo $itemflow['amont']; ?></span>
                            </div>
                            <div class="infotable-cell info align-center">
                                <span class="editable-click infocontent">
                                    <?php echo $itemflow['createdate']; ?></span>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <?php
            }
            $reviewRecords = $commonTools->getDatasBySQL("select * from acc_order_reviewrecord_" . $tableyear . " where orderno='" . $orderno . "' order by reviewdate desc");
            if (count($reviewRecords) > 0) {
                ?>
                <hr>
                <div class="infotable-horizontal" style="margin-bottom: 20px">
                    <div class="infotable-caption bigger-120">审核记录</div>
                    <div class="infotable-row">
                        <div class="infotable-cell title">审核结果</div>
                        <div class="infotable-cell title">审核内容</div>
                        <div class="infotable-cell title">审核人</div>
                        <div class="infotable-cell title">审核时间</div>
                    </div>
                    <?php foreach ($reviewRecords as $reviewRecord) { ?>
                        <div class="infotable-row">
                            <div class="infotable-cell info align-center">
                                <?php echo $reviewRecord['result'] == '1' ? '<span class="editable-click infocontent green">通过</span>' : '<span class="editable-click infocontent red">不通过</span>'; ?>
                            </div>
                            <div class="infotable-cell info">
                                <span class="editable-click infocontent">
                                    <?php echo $reviewRecord['content']; ?></span>
                            </div>
                            <div class="infotable-cell info align-center">
                                <span class="editable-click infocontent">
                                    <?php echo $reviewRecord['username']; ?></span>
                            </div>
                            <div class="infotable-cell info align-center">
                                <span class="editable-click infocontent">
                                    <?php echo $reviewRecord['reviewdate']; ?></span>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <?php
            }
            ?>
        </div>
    <?php } ?>
</div>
<?php require $_SERVER['DOCUMENT_ROOT'] . $GLOBALS['webroot'] . '/view/common/foot.php'; ?>
<script type="text/javascript" defer async="async"
        charset="<?php echo $GLOBALS['charset']; ?>"
        src="<?php echo $GLOBALS['webroot'] . '/script/page/query/history/orderinfo.js?v=1.0.0'; ?>"></script>
</body>
</html>