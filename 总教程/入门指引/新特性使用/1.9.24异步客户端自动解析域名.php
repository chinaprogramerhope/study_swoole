在1.9.24之前的版本，如果Client要通过域名连接服务器，需要手工调用swoole_async_dns_lookup函数，否则底层会发生阻塞。在最新的1.9.24中底层支持了自动异步解析域名，不再需要显式调用swoole_async_dns_lookup。
有效范围
Swoole\Client
Swoole\Http\Client
Swoole\Coroutine\Client
Swoole\Coroutine\Http\Client

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/5
 * Time: 17:29
 */
// 旧版本
swoole_async_dns_lookup('www.baidu.com', function ($domain, $ip) {
    $client = new swoole_client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_ASYNC);
    $client->on('connect', function (swoole_client $cli) {
        $cli->send("GET / HTTP1.1\r\n\r\n");
    });
    $client->on('receive', function (swoole_client $cli, $data) {
        echo "receive: $data";
        $cli->send(str_repeat('A', 100) . "\n");
        sleep(1);
    });
    $client->on('error', function (swoole_client $cli) {
        echo "error\n";
    });
    $client->on('close', function (swoole_client $cli) {
        echo "connection close\n";
    });
    $client->connect($ip, 9501);
});

// 新版本
$client = new swoole_client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_ASYNC);
$client->on('connect', function (swoole_client $cli) {
    $cli->send("GET / HTTP/1.1/r/n/r/n");
});
$client->on('receive', function (swoole_client $cli, $data) {
    echo "receive: $data";
    $cli->send(str_repeat('A', 100) . "\n");
    sleep(1);
});
$client->on('error', function (swoole_client $cli) {
    echo "error\n";
});
$client->on('close', function (swoole_client $cli) {
    echo "connection close\n";
});
// 底层会自动进行异步域名解析
$client->connect('www.baidu.com', 9501);