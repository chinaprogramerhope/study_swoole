onPacket

接收到UDP数据包时回调此函数，发生在worker进程中。函数原型：
function onPacket(swoole_server $server, string $data, array $client_info);

$server，swoole_server对象
$data，收到的数据内容，可能是文本或者二进制内容
$client_info，客户端信息包括address/port/server_socket 3项数据

服务器同时监听TCP/UDP端口时，收到TCP协议的数据会回调onReceive，收到UDP数据包回调onPacket，服务器设置的EOF或Length协议对UDP端口是不生效的，因为UDP包本身存在消息边界，不需要额外的协议处理。
onPacket事件回调在1.7.18以上版本可用
如果未设置onPacket回调函数，收到UDP数据包默认会回调onReceive函数

数据转换
onPacket回调可以通过计算得到onReceive的$fd和$reactor_id参数值。计算方法如下：
$fd = unpack('L', pack('N', ip2long($addr['address'])))[1];
$reactor_id = ($addr['server_socket'] << 16) + $addr['port'];

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/7
 * Time: 15:24
 */