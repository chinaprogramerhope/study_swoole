<?php
require_once '../spl_autoload_register.php';

$url = 'http://127.0.0.1:9401';
$param = [
'to' => '18301805881@163.com',
'subject' => 'test_mail',
'body' => 'gagaga',
];

$params = [
'class_name' => 'svcMail',
'func_name' => 'send_verify_mail',
'param' => $param,
];

Http::curl_post($url, $params);