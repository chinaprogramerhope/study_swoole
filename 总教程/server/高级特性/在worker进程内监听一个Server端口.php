在worker进程内监听一个Server端口

在一些场景下，需要监听额外的端口提供特殊协议处理。如在HttpServer中需要监听8081端口，提供管理Server的功能。在Swoole扩展内置的服务中不支持同时处理2种协议，即使是使用了addlistener添加了多个端口也不能接受2种协议的请求包。

这时候可以使用本地监听来解决此问题，原理是在某一个worker进程内，创建stream_socket_server，并加入到swoole_event中。

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/7
 * Time: 16:58
 */
$serv = new swoole_server('0.0.0.0', 9502);

$serv->on('workerstart', function ($server, $id) {
    // 仅在worker-0中监听管理端口
    if ($id != 0) {
        return;
    }
    $local_listener = stream_socket_server('tcp://127.0.0.1:8081', $errno, $errstr);
    swoole_event_add($local_listener, function ($server) {
        $local_client = stream_socket_accept($server, 0);
        swoole_event_add($local_client, function ($client) {
            echo fread($client, 8192);
            fwrite($client, 'hello');
        });
    });
});