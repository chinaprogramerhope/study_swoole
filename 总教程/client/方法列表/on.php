swoole_client->on

注册异步事件回调函数，调用on方法会使当前的socket变成非阻塞的。
int swoole_client::on(string $event, mixed $callback);

参数1为事件类型，支持connect/error/receive/close 4种。
参数2为回调函数，可以是函数名字符串、匿名函数、类静态方法、对象方法。
同步阻塞客户端一定不要使用on方法

调用swoole_client->close()时会自动退出事件循环
on方法也可以用在UDP协议上，需要v1.6.3以上版本，UDP协议的connect事件在执行完connect方法后立即被回调 udp没有close事件



v1.6.10

从1.6.10开始，onReceive不再需要调用一次$client->recv()来接收数据，onReceive回调函数的第二个参数就是 收到的数据了。
另外onClose事件，也无需调用$client->close()，swoole内核会自动执行close。

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/7
 * Time: 20:00
 */
// 示例
$client = new swoole_client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_ASYNC); // 异步非阻塞

$client->on('connect', function ($cli) {
    $cli->send("hello world\n");
});

$client->on('receive', function ($cli, $data = '') {
    $data = $cli->recv(); // 1.6.10+ 不需要
    if (empty($data)) {
        $cli->close();
        echo "closed\n";
    } else {
        echo "received: $data\n";
        sleep(1);
        $cli->send("hello\n");
    }
});

$client->on('close', function ($cli) {
    $cli->close(); // 1.6.10+ 不需要
    echo "close\n";
});

$client->on('error', function ($cli) {
    exit("error\n");
});

$client->connect('127.0.0.1', 9501, 0.5);