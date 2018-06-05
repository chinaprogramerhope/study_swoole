早期的Swoole客户端不支持连接超时检测，即使在connect方法中传入了超时时间在异步客户端中也是无效的。所以需要客户端自行添加定时器来检测连接是否超时。1.9.14版本底层增加了超时机制，应用不再需要添加定时器。
TCP客户端

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/5
 * Time: 16:47
 */
$client = new Swoole\Client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_ASYNC);
// 设置事件回调函数
$client->on('connect', function ($cli) {
    $cli->send("hello world\n");
});
$client->on('receive', function ($cli, $data) {
    echo "received: " . $data . "\n";
});
$client->on('error', function ($cli) {
    echo "connect failed\n";
});
$client->on('close', function ($cli) {
    echo "connection close\n";
});
// 发起网络连接
$client->connect('127.0.0.1', 9501, 0.5);
?>
connect方法的第三个参数就表示设置超时时间，如果在约定的时间内服务器没有响应，底层将自动close并回调onError事件
onError回调中可以使用$client->errCode获取错误码，连接超时的错误码为ETIMEOUT


Http客户端
除了连接超时外，某些请求响应式的异步客户端，如HttpClient，还支持了请求超时设置。当HttpClient发送了Request后服务器未能在规定的时间内返回Response，这时底层会自动close，并回调。HttpClient的状态码将设置为-2
<?php
$cli = new Swoole\Http\Client('127.0.0.1', 80);
$cli->set([
    'timeout' => 3.0 // 设置连接和请求的超时时间为3秒
]);
$cli->setHeaders([
    'User-Agent' => 'swoole-http-client'
]);
$cli->setCookies([
    'test' => 'value'
]);

$cli->post('/dump.php', [
    'test' => 'abc'
], function ($cli) {
    if (empty($cli->body)) {
        if ($cli->statusCode == -1) {
            echo "连接服务器超时\n";
        } else if ($cli->statusCode == -2) {
            echo "服务器响应超时\n";
        }
    } else {
        echo "请求成功: HTML=" . $cli->body;
    }
});