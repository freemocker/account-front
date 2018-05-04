<?php
/**
 * Created by PhpStorm.
 * User: zhangbin
 * Date: 2016/10/25
 * Time: 18:54
 */
require dirname(__FILE__) . '/../../common/pageHead.php';
?>
<html <?php echo $GLOBALS['html_attr'] ?>>
<head>
    <title>订单发生额分解规则</title>
    <?php require $_SERVER['DOCUMENT_ROOT'] . $GLOBALS['webroot'] . '/view/common/head.php'; ?>
</head>
<body class="<?php echo $GLOBALS['body_class']; ?>">
<input type="hidden" id="dic_ordertype_amontrule_typeid" value="<?php echo $_GET['typeid']; ?>"/>
<input type="hidden" id="dic_ordertype_amontrule_typecode" value="<?php echo $_GET['typecode']; ?>"/>
<div class="page-content no-padding-top">
    <div class="form-group">
        <div class="bigger-120 red"><?php echo $_REQUEST['typename'] . '——' . $_REQUEST['typecode']; ?></div>
    </div>
    <div class="row">
        <table id="dic_ordertype_amontrule_grid_table"></table>
        <div id="dic_ordertype_amontrule_grid_pager"></div>
    </div>
</div>
<?php require $_SERVER['DOCUMENT_ROOT'] . $GLOBALS['webroot'] . '/view/common/foot.php'; ?>
<script type="text/javascript" defer async="async"
        charset="<?php echo $GLOBALS['charset']; ?>"
        src="<?php echo $GLOBALS['webroot'] . '/script/page/dictionary/ordertypeamontrule.js?v=1.0.0'; ?>"></script>
</body>
</html>