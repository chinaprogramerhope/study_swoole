TCP客户端异步连接

通过使用on方法注册异步回调函数。多个swoole_client可以嵌套回调。异步模式仅可用于cli模式，如在swoole_process或swoole_server中。

<?php
// 示例
$client = new swoole_client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_ASYNC); // 异步非阻塞

$client->on('connect', function ($cli) {
    echo "connected\n";
    $cli->send("hello world\n");
});

$client->on('receive', function ($cli, $data) {
    if (empty($data)) {
        $cli->close();
        echo "closed\n";
    } else {
        echo "received: $data\n";
        sleep(1);
        $cli->send("hello\n");
    }
});

$client->on('error', function ($cli) {
    exit("error\n");
});

$client->on('close', function ($cli) {
    echo "connection is closed\n";
});

$client->connect('127.0.0.1', 9501, 0.5);