多端口监听的使用

Swoole提供了多端口监听的机制，这样可以同时监听UDP和TCP，同时监听内网地址和外网地址。内网地址和端口用于管理，外网地址用于对外服务。

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/7
 * Time: 16:21
 */
$serv = new swoole_server('0.0.0.0', 9501);
// 这里监听一个udp端口用来做内网管理
$serv->addListener('127.0.0.1', 9502, SWOOLE_SOCK_UDP);
$serv->on('connect', function ($serv, $fd) {
    echo "Client:Connect.\n";
});
$serv->on('receive', function ($serv, $fd, $from_id, $data) {
    $info = $serv->connection_info($fd, $from_id);

    if ($info['server_port'] == 9502) { // 来自9502的内网管理端口
        $serv->send($fd, "welcome admin\n");
    } else { // 来自外网
        $serv->send($fd, 'Swoole: ' . $data);
    }
});

$serv->on('close', function ($serv, $fd) {
    echo "Client: Close.\n";
});
$serv->start();
?>

<?php
// Web层只需向此UDP端口发送管理的指令即可
$client = new swoole_client(SWOOLE_SOCK_UDP, SWOOLE_SOCK_SYNC);
$client->connect('127.0.0.1', 9502);
$client->send('admin');
echo $client->recv();
