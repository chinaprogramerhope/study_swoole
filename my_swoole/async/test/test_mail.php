<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/15
 * Time: 10:58
 */
require_once 'spl_autoload_register.php';

$url = 'http://127.0.0.1:9401';
$param = [
    'port' => 25,
    'user' => 'phphack@163.com',
    'pass' => 'han888',
    'host' => 'smtp.163.com',
    'from' => 'phphack@163.com',
    'to' => '18301805881@163.com',
    'subject' => 'test_mail',
    'body' => 'gagaga',
];

$params = [
    'class_name' => 'Mail',
    'func_name' => 'sendMail',
    'param' => json_encode($param),
];

Http::curl_post($url, $params);
