swoole_client->getSocket

调用此方法可以得到底层的socket句柄, 返回的对象为sockets资源句柄


使用socket_set_option函数可以设置更底层的一些socket参数。
<?php
$socket = $client->getSocket();
if (!socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, 1)) {
    echo "unable to set option on socket: " . socket_strerror(socket_last_error()) . PHP_EOL;
}