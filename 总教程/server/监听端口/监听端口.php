监听端口

Swoole-1.8.0新增了对多端口混合协议的支持。Server可以监听多个端口，每个端口都可以设置不同的协议处理方式(set)和回调函数(on)。SSL/TLS传输加密也可以只对特定的端口启用。

未调用set方法，设置协议处理选项的监听端口，默认继承主服务器的设置
未调用on方法，设置回调函数的监听端口，默认使用主服务器的回调函数
监听端口返回的对象类型为swoole_server_port
监听端口的swoole_server_port对象，可以调用set和on方法，使用方法与swoole_server完全一致
监听端口只能设置少量特定的选项，只能设置数据收发的相关事件回调函数
不同监听端口的回调函数，仍然是相同的Worker进程空间内执行

主服务器是WebSocket或Http协议，新监听的TCP端口默认会继承主Server的协议设置。必须单独调用set方法设置新的协议才会启用新协议

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/7
 * Time: 12:04
 */
// 监听新端口
$port1 = $server->listen('127.0.0.1', 9501, SWOOLE_SOCK_TCP);
$port2 = $server->listen('127.0.0.1', 9502, SWOOLE_SOCK_UDP);
$port3 = $server->listen('127.0.0.1', 9503, SWOOLE_SOCK_TCP | SWOOLE_SSL);

// 设置网络协议
$port1->set([
    'open_length_check' => true,
    'package_length_type' => 'N',
    'package_length_offset' => 0,
    'package_max_length' => 800000,
]);

$port3->set([
    'open_eof_split' => true,
    'package_eof' => "\r\n",
    'ssl_cert_file' => 'ssl.cert',
    'ssl_key_file' => 'ssl.key',
]);

// 设置回调函数
$port1->on('connect', function ($serv, $fd) {
    echo "Client: Connect.\n";
});

$port1->on('receive', function ($serv, $fd, $from_id, $data) {
    $serv->send($fd, 'Swoole: ' . $data);
    $serv->close($fd);
});

$port1->on('close', function ($serv, $fd) {
    echo "Client: Close.\n";
});

$port1->on('packet', function ($serv, $data, $addr) {
    var_dump($data, $addr);
});
?>


swoole_http_server和swoole_websocket_server因为是使用继承子类实现的，无法通过调用swoole_server实例的listen来方法创建Http/WebSocket服务器。如果服务器的主要功能为RPC，但希望提供一个简单的Web管理界面。
在这样的场景中，可以先创建Http/WebSocket服务器，然后再进行listen监听RPC服务器的端口。
<?php
// 实例
$http_server = new swoole_http_server('0.0.0.0', 9998);
$http_server->set([
    'daemonize' => false
]);
$http_server->on('request', 'request');
// ......设置各个回调......
// 多监听一个tcp端口, 对外开启tcp服务, 并设置tcp服务器的回调
$tcp_server = $http_server->addListener('0.0.0.0', 9999, SWOOLE_SOCK_TCP);
// 默认新监听的端口9999会继承主服务器的设置, 也是http协议
// 需要调用set方法覆盖主服务器的设置
$tcp_server->set([]);
$tcp_server->on('receive', function ($serv, $fd, $threadId, $data) {
    echo $data;
});
?>
通过这样的代码，我们便可以建立一个同时对外提供http服务，又同时对外提供tcp服务的server，具体更加的优雅代码组合则由你自己来实现。


<?php
// TCP、Http、WebSocket 多协议端口复合设置
$port1 = $server->listen('127.0.0.1', 9501, SWOOLE_SOCK_TCP);
$port1->set([
    'open_websocket_protocol' => true, // 设置使得这个端口支持websocket协议
]);

$port1 = $server->listen('127.0.0.1', 9501, SWOOLE_SOCK_TCP);
$port1->set([
    'open_http_protocol' => false, // 设置这个端口关闭http协议功能
]);
?>
同理还有： open_http_protocol、open_http2_protocol、open_mqtt_protocol 等参数
