onReceive

客户端收到来自于服务器端的数据时会回调此函数
function onReceive(swoole_client $client, string $data);

    $data 是服务器端发送的数据，可以为文本或者二进制内容
    swoole_client启用了eof/length检测后，onReceive一定会收到一个完整的数据包

