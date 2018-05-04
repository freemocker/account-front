<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/view/common/include.php';
$currTools = new \service\tools\ToolsClass();
$params = array();
foreach ($_REQUEST as $key => $value) {
    if ($key == "url" || $key == "comType" || $key == "timeOut" || $key == "charset" || $key == "dataType") {
        continue;
    }
    $params[$key] = $value;
}
$timeout = intval($_REQUEST['timeOut']) / 1000;
$charset = $_REQUEST['charset'];
switch (intval($_REQUEST['comType'])) { // 0 一般请求，1 下载请求
    case 0:
        $business = $currTools->getDatasBySQL("select id,businesskey from acc_business_account where isdefault=1");
        if (count($business) > 0) {
            $business = $business[0];
            $url = $_REQUEST['url'];
            $params['head']['customerid'] = $business['id'];
            ksort($params['head']);
            $validateStr = '';
            foreach ($params['head'] as $key => $value) {
                if (isset($value) && $value != "" && !is_null($value)) {
                    if ($validateStr != '') {
                        $validateStr = $validateStr . '&';
                    }
                    $validateStr = $validateStr . strtolower($key) . '=' . (is_array($value) ? json_encode($value, JSON_UNESCAPED_UNICODE) : $value);
                }
            }
            if ($validateStr != '') {
                $validateStr = $validateStr . '&';
            }
            if (isset($params['body']) && $params['body'] != "" && !is_null($params['body'])) {
                $validateStr = $validateStr . json_encode($params['body'], JSON_UNESCAPED_UNICODE);
            }
            $validateStr = $validateStr . '&' . $business['businesskey'];
            $params['head']['validatecode'] = strtoupper(md5($validateStr));
            $result = $currTools->doHttp($url, $params, "POST", $charset, $timeout, $_REQUEST['dataType']);
            if (empty($result)) {
                $result = \service\tools\ToolsClass::buildJSONErrorStr('请求失败！');
            }
            $result_obj = json_decode($result, true);
            $ret = array();
            if (isset($result_obj['head'])) {
                $status = $result_obj['head']['status'];
                if ($status == 1) {
                    if (isset($result_obj['body'])) {
                        $ret = $result_obj['body'];
                    }
                    $ret['message'] = $result_obj['head']['message'];
                } else {
                    $ret = \service\tools\ToolsClass::buildJSONError($result_obj['head']['message']);
                }
            } else if (isset($result_obj['errmsg'])) {
                $ret = $result_obj;
            } else {
                $ret = \service\tools\ToolsClass::buildJSONError("请求失败，后台服务器异常");
            }
            echo json_encode($ret);
        } else {
            $result = \service\tools\ToolsClass::buildJSONErrorStr("找不到账务平台B类账户");
            echo $result;
        }
        break;
    case 1:
//        $url = $_REQUEST['url'];
//        $filename = $_REQUEST['name'];
//        $result = $currTools->doHttpDownload($url . "download", $params, $filename, $charset, $timeout);
//        if (empty($result)) {
//            $result = \service\tools\ToolsClass::buildJSONErrorStr('请求失败！');
//        }
        $result = \service\tools\ToolsClass::buildJSONErrorStr('请求暂不支持！');
        break;
}