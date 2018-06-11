常量

swoole_client::MSG_WAITALL
用于swoole_client->recv方法的第二个参数，阻塞等待直到收到指定长度的数据后返回。
$client->recv(8192, swoole_client::MSG_PEEK | swoole_client::MSG_DONTWAIT);



swoole_client::MSG_DONTWAIT
非阻塞接收数据，无论是否有数据都会立即返回。


swoole_client::MSG_PEEK
窥视socket缓存区中的数据。设置MSG_PEEK参数后，recv读取数据不会修改指针，因此下一次调用recv仍然会从上一次的位置起返回数据。


swoole_client::MSG_OOB
读取带外数据.