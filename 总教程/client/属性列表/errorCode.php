swoole_client->errCode 

类型为int型。当connect/send/recv/close失败时，会自动设置$swoole_client->errCode的值。
errCode的值等于Linux errno。可使用socket_strerror将错误码转为错误信息。
echo socket_strerror($client->errCode);

附录：Linux的errno定义