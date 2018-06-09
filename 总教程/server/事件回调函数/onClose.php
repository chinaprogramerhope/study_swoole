onClose

TCP客户端连接关闭后，在worker进程中回调此函数。函数原型：
function onClose(swoole_server $server, int $fd, int $reactorId);


$server 是swoole_server对象
$fd 是连接的文件描述符
$reactorId 来自那个reactor线程

onClose回调函数如果发生了致命错误，会导致连接泄漏。通过netstat命令会看到大量CLOSE_WAIT状态的TCP连接

无论由客户端发起close还是服务器端主动调用$serv->close()关闭连接，都会触发此事件。因此只要连接关闭，就一定会回调此函数
1.7.7+版本以后onClose中依然可以调用connection_info方法获取到连接信息，在onClose回调函数执行完毕后才会调用close关闭TCP连接

注意：这里回调onClose时表示客户端连接已经关闭，所以无需执行$server->close($fd)。代码中执行$serv->close($fd)会抛出PHP错误告警。
主动关闭

swoole-1.9.7版本修改了$reactorId参数，当服务器主动关闭连接时，底层会设置此参数为-1，可以通过判断$reactorId < 0来分辨关闭是由服务器端还是客户端发起的。

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/7
 * Time: 15:27
 */