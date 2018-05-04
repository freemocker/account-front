<?php
require $_SERVER['DOCUMENT_ROOT'] . '/view/common/pageHead.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/view/common/include.php';
echo date('Y-m-d H:i:s.') . floor(explode(" ", microtime())[0] * 1000);
phpinfo();
$tools = new service\tools\ToolsClass();

$key = 'OW9puTMy5WcC9lgp';
$text = "/file/param/secret_key";
$encrypt = $tools->encryptAES($text, $key);
echo 'AES加密解密测试：<br/>';
echo '密文：' . $encrypt . '<br/>';
echo '明文：' . $tools->decryptAES($encrypt, $key) . '<br/>';

$sourcestr = "RSA加密测试明文";
$encrypttext = $tools->encryptRSA_public($sourcestr);
echo '<br/>RSA加密解密测试：<br/>';
echo '密文：' . $encrypttext . '<br/>';
echo '明文：' . $tools->decryptRSA_private($encrypttext);

$sourcestr = "RSA加密测试明文";
$encrypttext = $tools->encryptRSA_private($sourcestr);
echo '<br/>RSA加密解密测试：<br/>';
echo '私钥加密密文：' . $encrypttext . '<br/>';
echo '公钥解密明文：' . $tools->decryptRSA_public($encrypttext);

var_dump(\service\tools\security\RSAUtilsClass::_getpublickeydetail());

var_dump($tools->getDatasBySQL("select * from t_user"));
?>