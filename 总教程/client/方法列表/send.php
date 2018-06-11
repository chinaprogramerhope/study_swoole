swoole_client->send 

发送数据到远程服务器, 必须在建立连接后, 才可向server发送数据, 函数原型:
int $swoole_client->send(string $data);

    $data参数为字符串，支持二进制数据
    成功发送返回的已发数据长度
    失败返回false，并设置$swoole_client->errCode

异步模式下如果SOCKET缓存区已满，Swoole的处理逻辑请参考 swoole_event_write

    如果未执行connect，调用send会触发PHP警告


同步客户端

发送的数据没有长度限制
发送的数据太大Socket缓存区塞满，底层会阻塞等待可写

异步客户端

发送数据长度受到socket_buffer_size限制
