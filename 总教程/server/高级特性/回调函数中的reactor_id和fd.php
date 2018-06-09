回调函数中的 reactor_id 和 fd

服务器的onConnect、onReceive、onClose回调函数中会携带reactor_id和fd两个参数。

$reactor_id是来自于哪个reactor线程
$fd是TCP客户端连接的标识符，在Server程序中是唯一的
fd 是一个自增数字，范围是1 ～ 1600万，fd超过1600万后会自动从1开始进行复用
$fd是复用的，当连接关闭后fd会被新进入的连接复用
正在维持的TCP连接fd不会被复用

调用swoole_server->send/swoole_server->close函数需要传入$fd参数才能被正确的处理。如果业务中需要发送广播，需要用apc、redis、MySQL、memcache、swoole_table将fd的值保存起来。

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/7
 * Time: 16:06
 */
function my_onReceive($serv, $fd, $reactor_id, $data) {
    // 想connection发送数据
    $serv->send($fd, 'Swoole: ' . $data);

    // 关闭connection
    $serv->close($fd);
}
?>

fd 为什么使用整型

$fd使用整型而不是使用对象，主要原因是swoole是多进程的模型，在Worker进程/Task进程中随时可能要访问某一个客户端连接，如果使用对象，那就需要进行Serialize/Unserialize。增加了额外的性能开销。$fd 如果是整数那就可以直接存储传输被使用。

在PHP层可以也客户端连接可以封装成对象。面向对象的好处是可读性更好，对连接的操作可以封装到方法中。如
$connection->send($data);
$connection->close();

