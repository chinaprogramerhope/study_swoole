<?php
/**
 * Created by PhpStorm.
 * User: ftd20
 * Date: 2018/6/5
 * Time: 6:33
 */
// udp_server.php

// 创建server对象, 监听127.0.0.1:9502端口, 类型为SWOOLE_SOCK_UDP
$serv = new swoole_server('127.0.0.1', 9502, SWOOLE_PROCESS, SWOOLE_SOCK_UDP);

// 监听数据接收事件
$serv->on('Packet', function ($serv, $data, $clientInfo) {
    $serv->sendto($clientInfo['address'], $clientInfo['port'], "server " . $data);
    var_dump($clientInfo);
});

// 启动服务器
$serv->start();

?>

UDP服务器与TCP服务器不同，UDP没有连接的概念。启动Server后，客户端无需Connect，直接可以向Server监听的9502端口发送数据包。对应的事件为onPacket。

$clientInfo是客户端的相关信息，是一个数组，有客户端的IP和端口等内容
调用 $server->sendto 方法向客户端发送数据

启动服务

php udp_server.php

UDP服务器可以使用netcat -u 来连接测试

netcat -u 127.0.0.1 9502
hello
Server: hello

