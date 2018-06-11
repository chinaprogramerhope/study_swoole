swoole_client->enableSSL 

动态开启SSL隧道加密。客户端在建立连接时使用明文通信，中途希望改为SSL隧道加密通信，可以使用enableSSL方法来实现。使用enableSSL动态开启SSL隧道加密，需要满足两个条件：

客户端创建时类型必须为非SSL
客户端已与服务器建立了连接

enableSSL方法可同时用于同步和异步客户端，异步客户端需要传入一个回调函数，当SSL握手完成后会回调此函数。同步客户端调用enableSSL会阻塞等待SSL握手完成。



<?php
// 同步客户端
$client = new swoole_client(SWOOLE_SOCK_TCP);
if (!$client->connect('127.0.0.1', 9501, -1)) {
    exit("connect failed, error: {$client->errCode}\n");
}
$client->send("hello world\n");
echo $client->recv();
// 启用ssl隧道加密
if ($client->enableSSL()) {
    // 握手完成, 此时发送和接收的数据是加密的
    $client->send("hello world\n");
    echo $client->recv();
}
$client->close();




// 异步客户端
$client = new swoole_client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_ASYNC);
$client->on('connect', function (swoole_client $cli) {
    $cli->send("hello world\n");
});
$client->on('receive', function (swoole_client $cli, $data) {
    echo "receive: $data";
    $cli->send(str_repeat('A', 10) . "\n");
    // 启用ssl加密
    $cli->enableSSL(function ($client) {
      // 握手完成, 此时发送和接收的数据都是加密的
      $client->send('hello');  
    });
});
$client->on('error', function (swoole_cleint $cli) {
    echo "error\n";
});
$client->on('close', function (swoole_client $cli) {
    echo "connection close\n";
});
$client->connect('127.0.0.1', 9501);