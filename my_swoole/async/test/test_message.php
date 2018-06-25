<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/25
 * Time: 11:41
 */
require_once '../spl_autoload_register.php';

$url = 'http://127.0.0.1:9401';

$params = [
    'class_name' => 'svcMessage',
    'func_name' => 'send_message',
    'param' => [
        'u_kkid' => 'xx',
        'phone_number' => '18301805881'
    ],
];

Http::curl_post($url, $params);