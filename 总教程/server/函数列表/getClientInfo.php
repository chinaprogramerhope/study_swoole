swoole_server->getClientInfo

swoole_server->getClientInfo函数用来获取连接的信息，别名是swoole_server->connection_info
function swoole_server->getClientInfo(int $fd, int $extraData, bool $ignoreError = false);

如果传入的$fd存在，将会返回一个数组
连接不存在或已关闭，返回false
第3个参数表示是否忽略错误，如果设置为true，即使连接关闭也会返回连接的信息

connect_time, last_time 在1.6.10或更高版本可用

$fdinfo = $serv->connection_info($fd);
var_dump($fdinfo);
array(5) {
["reactor_id"]=>
int(3)
["server_fd"]=>
int(14)
["server_port"]=>
int(9501)
["remote_port"]=>
int(19889)
["remote_ip"]=>
string(9) "127.0.0.1"
["connect_time"]=>
int(1390212495)
["last_time"]=>
int(1390212760)
}

$udp_client = $serv->connection_info($fd, $from_id);
var_dump($udp_client);


reactor_id 来自哪个Reactor线程
server_fd 来自哪个监听端口socket，这里不是客户端连接的fd
server_port 来自哪个监听端口
remote_port 客户端连接的端口
remote_ip 客户端连接的IP地址
connect_time 客户端连接到Server的时间，单位秒，由master进程设置
last_time 最后一次收到数据的时间，单位秒，由master进程设置
close_errno 连接关闭的错误码，如果连接异常关闭，close_errno的值是非零，可以参考Linux错误信息列表
websocket_status [可选项] WebSocket连接状态，当服务器是Swoole\WebSocket\Server时会额外增加此项信息
uid [可选项] 使用bind绑定了用户ID时会额外增加此项信息
ssl_client_cert [可选项] 使用SSL隧道加密，并且客户端设置了证书时会额外添加此项信息

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/6
 * Time: 14:48
 */