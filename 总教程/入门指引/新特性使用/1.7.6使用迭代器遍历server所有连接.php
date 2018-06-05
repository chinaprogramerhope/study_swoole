swoole-1.7.16版本增加了客户端连接迭代器接口，可以非常轻松实现遍历当前服务器的所有连接。

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/5
 * Time: 16:32
 */
// 遍历连接并广播
foreach ($server->connections as $fd) {
    $server->send($fd, "hello world\n");
}

// 获取连接总数
echo count($server->connections);