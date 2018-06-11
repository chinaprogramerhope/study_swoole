swoole_client->isConnected

返回swoole_client的连接状态
bool swoole_client->isConnected()
返回fasle, 表示当前未链接到服务器
返回true, 表示当前已连接到服务器

此函数在1.7.5版本以上可用


注意事项
isConnected方法返回的是应用层状态，只表示Client执行了connect并成功连接到了Server，并且没有执行close关闭连接。
Client可以执行send、recv、close等操作，但不能再次执行connect。

这不代表连接一定是可用的，当执行send或recv时仍然有可能返回错误，因为应用层无法获得底层TCP连接的状态，
执行send或recv时应用层与内核发生交互，才能得到真实的连接可用状态。