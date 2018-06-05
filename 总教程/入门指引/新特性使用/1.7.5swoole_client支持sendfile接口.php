1.7.5增加了swoole_client->sendfile接口，在客户端中也可以直接发送一个文件到服务器。使用方法

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/5
 * Time: 16:20
 */
$client = new swoole_client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_SYNC); // 同步阻塞
if (!$client->connect('127.0.0.1', 9501, -1)) {
    exit("connect failed. error: {$client->errCode}\n");
}
if ($client->sendfile(__DIR__ . '/test.txt') === false) {
    echo "send failed. error: {$client->errCode}\n";
    break;
}
$data = $client->recv(7000);
if ($data === false) {
    echo "recv failed. error: {$client->errCode}\n";
    break;
}
var_dump($data);
$client->close();
?>

sendfile只需要传入文件名即可发送到服务器。当文件不存在时会返回false。
