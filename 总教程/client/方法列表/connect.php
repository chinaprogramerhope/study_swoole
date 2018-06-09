swoole_client->connect

连接到远程服务器，函数原型：
bool $swoole_client->connect(string $host, int $port, float $timeout = 0.5, int $flat = 0);

connect方法接受4个参数：

$host是远程服务器的地址，1.10.0或更高版本已支持自动异步解析域名，$host可直接传入域名
$port是远程服务器端口
$timeout是网络IO的超时，包括connect/send/recv，单位是s，支持浮点数。默认为0.5s，即500ms
$flag参数在UDP类型时表示是否启用udp_connect 设定此选项后将绑定$host与$port，此UDP将会丢弃非指定host/port的数据包。
$flag参数在TCP类型,$flag=1表示设置为非阻塞socket，connect会立即返回。如果将$flag设置为1，那么在send/recv前必须使用swoole_client_select来检测是否完成了连接

$timeout超时设置基于底层操作系统SOCKET参数，对异步客户端无效



同步模式

connect方法会阻塞，直到连接成功并返回true。这时候就可以向服务器端发送数据或者收取数据了。
<?php
if ($cli->connect('127.0.0.1', 9501)) {
    $cli->send('data');
} else {
    echo 'connect failed.';
}
?>
如果连接失败，会返回false
同步TCP客户端在执行close后，可以再次发起Connect创建新连接到服务器



异步模式

connect会立即返回true。但实际上连接并未建立。所以不能在connect后使用send。通过isConnected()判断也是false。当连接成功后，系统会自动回调onConnect。这时才可以使用send向服务器发送数据。

异步客户端执行connect时会增加一次引用计数，当连接关闭时会减少引用计数
低于1.9.11的版本，$timeout超时设置$timeout在异步客户端中是无效的，应用层需要用Timer::after自行添加定时器来实现异步客户端的链接超时控制
1.9.11或更高版本，底层会自动添加定时器，在规定的时间内未连接成功，底层会触发onError连接失败事件，错误码为ETIMEOUT(110)




失败重连

connect失败后如果希望重连一次，必须先进行close关闭旧的socket，否则会返回EINPROCESS错误，因为当前的socket正在连接服务器，客户端并不知道是否连接成功，所以无法再次执行connect。调用close会关闭当前的socket，底层重新创建新的socket来进行连接。

启用SWOOLE_KEEP长连接后，close调用的第一个参数要设置为true表示强行销毁长连接socket
<?php
if ($socket->connect('127.0.0.1', 9502) === false) {
    $socket->close(true);
    $socket->connect('127.0.0.1', 9502);
}
?>





UDP Connect

默认底层并不会启用udp connect，一个UDP客户端执行connect时，底层在创建socket后会立即返回成功。这时此socket绑定的地址是0.0.0.0，任何其他对端均可向此端口发送数据包。

如$client->connect('192.168.1.100', 9502)，这时操作系统为客户端socket随机分配了一个端口58232，其他机器，如192.168.1.101也可以向这个端口发送数据包。

未开启udp connect，调用getsockname返回的host项为0.0.0.0

将第4项参数设置为1，启用udp connect，$client->connect('192.168.1.100', 9502, 1, 1)。这时将会绑定客户端和服务器端，底层会根据服务器端的地址来绑定socket绑定的地址。如连接了192.168.1.100，当前socket会被绑定到192.168.1.*的本机地址上。启用udp connect后，客户端将不再接收其他主机向此端口发送的数据包。
