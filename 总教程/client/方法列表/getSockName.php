swoole_client->getSockName

用于获取客户端socket的本地host:port, 必须在连接之后才可以使用
array swoole_client->getsockname();

调用成功返回一个数组, 如: ['host' => '127.0.0.1', 'port' => 53652]

此函数在1.7.13以上版本可用