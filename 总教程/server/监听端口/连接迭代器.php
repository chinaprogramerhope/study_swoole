连接迭代器

1.10.0或更高版本，提供了监听端口迭代器，可以只遍历当前服务器端口所维持的TCP连接，而不是遍历所有端口的连接。

连接迭代器依赖pcre库

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/7
 * Time: 14:12
 */
$server = new swoole_websocket_server('0.0.0.0', 9514, SWOOLE_BASE);
$server->set([
    'enable_static_handler' => true,
    'document_root' => __DIR__ . '/web',
]);

$tcp = $server->listen('0.0.0.0', 9515, SWOOLE_SOCK_TCP);
$tcp->set([
    'open_length_check' => true,
    'package_max_length' => 2 * 1024 * 1024,
    'package_length_type' => 'N',
    'package_body_offset' => 16,
    'package_length_offset' => 0,
]);

$server->on('open', function ($serv, $req) {
    echo "new WebSocket Client, fd={$req->fd}\n";
});

$tcp->on('receive', function ($server, $fd, $reactor_id, $data) {
    $body = substr($data, 16);
    $value = swoole_serialize::unpack($body);
    // 仅遍历9514端口的连接
    $websocket = $server->ports[0];
    foreach ($websocket->connections as $_fd) {
        if ($server->exists($_fd)) {
            $server->push($_fd, json_encode($value));
        }
    }
});

$server->start();