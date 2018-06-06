Swoole提供了swoole_server::addListener来增加监听的端口。业务代码中可以通过调用swoole_server::connection_info来获取某个连接来自于哪个端口。

函数原型：
function swoole_server->addListener(string $host, int $port, $type = SWOOLE_SOCK_TCP);

监听1024以下的端口需要root权限
1.8.0版本增加了多端口监听的功能，监听成功后会返回Swoole\Server\Port对象
在此对象上可以设置另外的事件回调函数和运行参数
监听失败返回false，可调用getLastError方法获取错误码
主服务器是WebSocket或Http协议，新监听的TCP端口默认会继承主Server的协议设置。必须单独调用set方法设置新的协议才会启用新协议 查看详细说明

swoole支持的Socket类型

SWOOLE_TCP/SWOOLE_SOCK_TCP tcp ipv4 socket
SWOOLE_TCP6/SWOOLE_SOCK_TCP6 tcp ipv6 socket
SWOOLE_UDP/SWOOLE_SOCK_UDP udp ipv4 socket
SWOOLE_UDP6/SWOOLE_SOCK_UDP6 udp ipv6 socket
SWOOLE_UNIX_DGRAM unix socket dgram
SWOOLE_UNIX_STREAM unix socket stream

Unix Socket仅在1.7.1+后可用，此模式下$host参数必须填写可访问的文件路径，$port参数忽略
Unix Socket模式下，客户端$fd将不再是数字，而是一个文件路径的字符串
SWOOLE_TCP等是1.7.0+后提供的简写方式，与1.7.0前的SWOOLE_SOCK_TCP是等同的

您可以混合使用UDP/TCP，同时监听内网和外网端口。 示例：
$serv->addlistener('127.0.0.1', 9502, SWOOLE_SOCK_TCP);
$serv->addistener('192.168.1.100', 9503, SWOOLE_SOCK_TCP);
$serv->addlistener('0.0.0.0', 9504, SWOOLE_SOCK_UDP);
// UnixSocket Stream
$serv->addlistener('/var/run/myserv.sock', 0, SWOOLE_UNIX_STREAM);
// TCP + SSL
$serv->addlistener('127.0.0.1, 9502, SWOOLE_SOCK_TCP | SWOOLE_SSL);

IPv4与IPv6

IPv4使用 127.0.0.1表示监听本机，0.0.0.0表示监听所有地址
IPv6使用::1表示监听本机，:: (0:0:0:0:0:0:0:0) 表示监听所有地址
Linux系统下监听IPv6端口后使用IPv4地址也可以进行连接

随机监听端口

swoole-1.9.6增加了随机监听端口的特性，$port参数可以设置为0，操作系统会随机分配一个可用的端口进行监听。可以读取$listen_port->port获取分配到的端口号。
$port = $serv->addListener('0.0.0.0', 0, SWOOLE_SOCK_TCP);
echo $port->port;

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/6
 * Time: 11:31
 */