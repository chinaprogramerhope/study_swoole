swoole_client->sendto

向任意IP:PORT的主机发送UDP数据包，仅支持SWOOLE_SOCK_UDP/SWOOLE_SOCK_UDP6类型的swoole_client对象。
bool swoole_client->sendto(string $ip, int $port, string $data);

    $ip，目标主机的IP地址，支持IPv4/IPv6
    $port，目标主机端口
    $data，要发送的数据内容，不得超过64K

