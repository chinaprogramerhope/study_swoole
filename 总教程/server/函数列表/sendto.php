swoole_server->sendto

向任意的客户端IP:PORT发送UDP数据包。

函数原型：
bool swoole_server->sendto(string $ip, int $port, string $data, int $server_socket = -1);

$ip为IPv4字符串，如192.168.1.102。如果IP不合法会返回错误
$port为 1-65535的网络端口号，如果端口错误发送会失败
$data要发送的数据内容，可以是文本或者二进制内容
$server_socket 服务器可能会同时监听多个UDP端口，此参数可以指定使用哪个端口发送数据包

示例：


<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/6
 * Time: 14:28
 */
// 向IP地址为220.181.57.216主机的9502端口发送一个hello world字符串。
$server->sendto('220.181.57.216', 9502, 'hello world');
// 向IPv6服务器发送UDP数据包
$server->sendto('2600:3c00:f03c:91ff:fe73:e98f', 9501, 'hello world');
?>

swoole_server->sendto 在1.7.10+版本可用
server必须监听了UDP的端口，才可以使用swoole_server->sendto
server必须监听了UDP6的端口，才可以使用swoole_server->sendto向IPv6地址发送数据
