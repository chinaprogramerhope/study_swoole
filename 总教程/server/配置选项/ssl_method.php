ssl_method

设置OpenSSL隧道加密的算法。Server与Client使用的算法必须一致，否则SSL/TLS握手会失败，连接会被切断。 默认算法为 SWOOLE_SSLv23_METHOD

$server->set([
    'ssl_method' => SWOOLE_SSLv3_CLIENT_METHOD,
]);
此配置在1.7.20或更高版本可用
支持的类型请参考 预定义常量

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/7
 * Time: 11:23
 */