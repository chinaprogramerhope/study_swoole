swoole_client->getPeerName

获取对端socket的IP地址和端口，仅支持SWOOLE_SOCK_UDP/SWOOLE_SOCK_UDP6类型的swoole_client对象。
bool swoole_client->getpeername();


UDP协议通信客户端向一台服务器发送数据包后，可能并非由此服务器向客户端发送响应。可以使用getpeername方法获取实际响应的服务器IP:PORT。
此函数必须在$client->recv() 之后调用
