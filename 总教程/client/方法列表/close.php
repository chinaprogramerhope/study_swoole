swoole_client->close 

关闭连接, 函数原型为:
bool $swoole_client->close(bool $force = false);

操作成功返回 true。当一个swoole_client连接被close后不要再次发起connect。正确的做法是销毁当前的swoole_client，重新创建一个swoole_client并发起新的连接。
    第一个参数设置为true表示强制关闭连接，可用于关闭SWOOLE_KEEP长连接
    swoole_client对象在析构时会自动close


异步客户端

客户端close会立即关闭连接，如果发送队列中仍然有待数据，底层会丢弃。
请勿在大量发送数据后，立即close，否则发送的数据未必能真正到达服务器端。

<?php
// 错误示例
$client = new swoole_client(SWOOLE_TCP | SWOOLE_ASYNC);
$client->on('connect', function (swoole_client $cli) {

});
$client->on('receive', function (swoole_client $cli, $data) {
    $cli->send(str_repeat('A', 1024 * 1024 * 4) . "\n");
    $cli->close();
});
$clinet->on('error', function (swoole_client $cli) {
    echo "error\n";
});
$client->on('close', function (swoole_client $cli) {
    echo "connection close\n";
});
$client->connect('127.0.0.1', 9501);
?>
客户端发送了4M数据，实际传输可能需要一段时间。
这时立即进行了close操作，可能只有小部分数据传输成功。大部分数据在发送队列中排队等待发送，close时会丢弃这些数据。


解决方案

配合使用onBufferEmpty，等待发送队列为空时进行close操作
协议设计为onReceive收到数据后主动关闭连接，发送数据时对端主动关闭连接
<?php
$client = new swoole_client(SWOOLE_TCP | SWOOLE_ASYNC);
$client->on('connect', function (swoole_client $cli) {

});
$client->on('receive', function (swoole_client $cli, $data) {
    $cli->send(str_repeat('A', 1024 * 1024 * 4) . "\n");
});
$client->on('error', function (swoole_client $cli) {
    echo "error\n";
});
$client->on('close', function (swoole_client $cli) {
    echo "connection close\n";
});
$clinet->on('bufferEmpty', function (swoole_client $cli) {
    $cli->close();
});
$client->connect('127.0.0.1', 9501);