onReceive

接收到数据时回调此函数，发生在worker进程中。函数原型：
function onReceive(swoole_server $server, int $fd, int $reactor_id, string $data);

$server，swoole_server对象
$fd，TCP客户端连接的唯一标识符
$reactor_id，TCP连接所在的Reactor线程ID
$data，收到的数据内容，可能是文本或者二进制内容

关于$fd和$reactor_id 详细的解释
未开启swoole的自动协议选项，onReceive回调函数单次收到的数据最大为64K
Swoole支持二进制格式，$data可能是二进制数据


协议相关说明
UDP协议，onReceive可以保证总是收到一个完整的包，最大长度不超过64K
UDP协议下，$fd参数是对应客户端的IP，$reactor_id是客户端的端口和来源端口； 客户端ip等于long2ip(unpack('N',pack('L',$fd))[1])；
TCP协议是流式的，onReceive无法保证数据包的完整性，可能会同时收到多个请求包，也可能只收到一个请求包的一部分数据
swoole只负责底层通信，$data是通过网络接收到的原始数据。对数据解包打包需要在PHP代码中自行实现
如果开启了eof_check/length_check/http_protocol，$data的长度可能会超过64K，但最大不超过$server->setting['package_max_length']
注意，onReceive回调不再支持UDP Server


关于TCP协议下包完整性
使用swoole提供的open_eof_check/open_length_check/open_http_protocol，可以保证数据包的完整性
不使用swoole的协议处理，在onReceive后PHP代码中自行对数据分析，合并/拆分数据包。
例如：代码中可以增加一个 $buffer = array()，使用$fd作为key，来保存上下文数据。 每次收到数据进行字符串拼接，$buffer[$fd] .= $data，然后在判断$buffer[$fd]字符串是否为一个完整的数据包。
默认情况下，同一个fd会被分配到同一个worker中，所以数据可以拼接起来。使用dispatch_mode = 3时。
请求数据是抢占式的，同一个fd发来的数据可能会被分到不同的进程。所以无法使用上述的数据包拼接方法
关于粘包问题，如SMTP协议，客户端可能会同时发出2条指令。在swoole中可能是一次性收到的，这时应用层需要自行拆包。smtp是通过\r\n来分包的，所以业务代码中需要 explode("\r\n", $data)来拆分数据包。
如果是请求应答式的服务，无需考虑粘包问题。原因是客户端在发起一次请求后，必须等到服务器端返回当前请求的响应数据，才会发起第二次请求，不会同时发送2个请求。


多端口监听
当主服务器设置了协议后，额外监听的端口默认会继承主服务器的设置。需要显式调用set方法来重新设置端口的协议。

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/7
 * Time: 15:13
 */
$serv = new swoole_http_server('127.0.0.1', 9501);
$port2 = $serv->listen('127.0.0.1', 9502, SWOOLE_SOCK_TCP);
$port2->on('receive', function (swoole_server $serv, $fd, $reactor_id, $data) {
    echo "[#" . $serv->worker_id . "]\tClient[$fd]: $data\n";
});
?>
这里虽然调用了on方法注册了onReceive回调函数，但由于没有调用set方法覆盖主服务器的协议，新监听的9502端口依然使用Http协议。使用telnet客户端连接9502端口发送字符串时服务器不会触发onReceive。
