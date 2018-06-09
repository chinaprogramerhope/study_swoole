swoole_client::__construct

函数原型:
swoole_client->__construct(int $sock_type, int $is_sync = SWOOLE_SOCK_SYNC, string $key);
可以使用swoole提供的宏来之指定类型，请参考 swoole常量定义

$sock_type表示socket的类型，如TCP/UDP
使用$sock_type | SWOOLE_SSL可以启用SSL加密
$is_sync表示同步阻塞还是异步非阻塞，默认为同步阻塞
$key用于长连接的Key，默认使用IP:PORT作为key。相同key的连接会被复用



在php-fpm/apache中创建长连接
$cli = new swoole_client(SWOOLE_TCP | SWOOLE_KEEP);
加入SWOOLE_KEEP标志后，创建的TCP连接在PHP请求结束或者调用$cli->close时并不会关闭。下一次执行connect调用时会复用上一次创建的连接。长连接保存的方式默认是以ServerHost:ServerPort为key的。可以再第3个参数内指定key。

SWOOLE_KEEP只允许用于同步客户端

swoole_client在unset时会自动调用close方法关闭socket
异步模式unset时会自动关闭socket并从epoll事件轮询中移除
SWOOLE_KEEP长连接模式在1.6.12后可用，长连接的$key参数在1.7.5后增加



在swoole_server中使用swoole_client

必须在事件回调函数中使用swoole_client，不能在swoole_server->start前创建
swoole_server可以用任何语言编写的 socket client来连接。同样swoole_client也可以去连接任何语言编写的socket server

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/7
 * Time: 19:51
 */