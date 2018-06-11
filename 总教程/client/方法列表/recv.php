swoole_client->recv 

recv方法用于从服务器端接收数据。接受2个参数。函数原型为：
// 低于1.7.22
string $swoole_client->recv(int $size = 65535, bool $waitall = 0);
// 1.7.22或更高
string $swoole_client->recv(int $size = 65535, int $flags = 0);

    $size，接收数据的缓存区最大长度，此参数不要设置过大，否则会占用较大内存
    $waitall，是否等待所有数据到达后返回

    如果设定了$waitall就必须设定准确的$size，否则会一直等待，直到接收的数据长度达到$size
    未设置$waitall=true时，$size最大为64K
    如果设置了错误的$size，会导致recv超时，返回 false

    成功收到数据返回字符串
    连接关闭返回空字符串
    失败返回 false，并设置$client->errCode属性


EOF/Length
客户端启用了EOF/Length检测后，无需设置$size和$waitall参数。扩展层会返回完整的数据包或者返回false。

    当收到错误的包头或包头中长度值超过package_max_length设置时，recv会返回空字符串，PHP代码中应当关闭此连接



Flags

1.7.22版本后，第二个$waitall参数修改为$flags，可以接收一些特殊的SOCKET接收设置。
为了兼容旧的接口，如果$flags=1则表示 $flags = swoole_client::MSG_WAITALL
$client->recv(8192, swoole_client::MSG_PEEK | swoole_client::MSG_WAITALL);



