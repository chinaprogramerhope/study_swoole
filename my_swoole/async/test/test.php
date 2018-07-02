<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/27
 * Time: 17:38
 */

require_once '../spl_autoload_register.php';

//// 发邮件
//$url = 'http://127.0.0.1:9401';
//$param = [
//    'to' => '18301805881@163.com',
//    'subject' => 'test_mail',
//    'body' => 'gagaga',
//];
//$params = [
//    'class_name' => 'svcMail',
//    'func_name' => 'send_mail',
//    'param' => $param,
//];
//Http::curl_post($url, $params);

//// 发短信
//$url = 'http://127.0.0.1:9401';
//$params = [
//    'class_name' => 'svcMessage',
//    'func_name' => 'send_message',
//    'param' => [
//        'u_kkid' => 'xx',
//        'phone_number' => '18301805881'
//    ],
//];
//Http::curl_post($url, $params);

//// 发小程序推送消息
//$url = 'http://127.0.0.1:9401';
//$params = [
//    'class_name' => 'svcPush',
//    'func_name' => 'mp_tmp',
//    'param' => [
//        'touser' => , // 接收者（用户）的 openid - 必填
//        'template_id' => , // 所需下发的模板消息的id - 必填
//        'from_id' => , // 表单提交场景下，为 submit 事件带上的 formId；支付场景下，为本次支付的 prepay_id - 必填
//        'data' => , // 模板内容，不填则下发空模板 - 必填
//    ],
//];
//Http::curl_post($url, $params);

//// 测试post  json
//$url = 'http://127.0.0.1:9401';
//$params = [
//    'class_name' => 'svcTest',
//    'func_name' => 'post',
//    'param' => []
//];
//$ret = Http::curl_post($url, $params, true);
//echo 'type = ' . gettype($ret);


$url = 'http://127.0.0.1:9401';
$params = [
    'class_name' => 'svcTimer',
    'func_name' => 'timer_after',
    'param' => [
        'timer_name' => 'test'
    ]
];
$ret = Http::curl_post($url, $params);
echo 'type = ' . gettype($ret) . ', ret = ' . json_encode($ret) . "\n";