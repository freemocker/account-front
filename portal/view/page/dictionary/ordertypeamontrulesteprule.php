<?php
/**
 * Created by PhpStorm.
 * User: zhangbin
 * Date: 2016/10/25
 * Time: 20:10
 */
require dirname(__FILE__) . '/../../common/pageHead.php';
?>
<html <?php echo $GLOBALS['html_attr'] ?>>
<head>
    <title>订单发生额阶梯分解规则</title>
    <?php require $_SERVER['DOCUMENT_ROOT'] . $GLOBALS['webroot'] . '/view/common/head.php'; ?>
</head>
<body class="<?php echo $GLOBALS['body_class']; ?>">
<input type="hidden" id="dic_ordertype_amontrule_steprule_amontruleid" value="<?php echo $_GET['amontruleid']; ?>"/>
<div class="page-content no-padding-top">
    <div class="row">
        <table id="dic_ordertype_amontrule_steprule_grid_table"></table>
        <div id="dic_ordertype_amontrule_steprule_grid_pager"></div>
    </div>
</div>
<?php require $_SERVER['DOCUMENT_ROOT'] . $GLOBALS['webroot'] . '/view/common/foot.php'; ?>
<script type="text/javascript" defer async="async"
        charset="<?php echo $GLOBALS['charset']; ?>"
        src="<?php echo $GLOBALS['webroot'] . '/script/page/dictionary/ordertypeamontrulesteprule.js?v=1.0.0'; ?>"></script>
</body>
</html>