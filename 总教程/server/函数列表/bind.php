swoole_server->bind

将连接绑定一个用户定义的UID，可以设置dispatch_mode=5设置以此值进行hash固定分配。可以保证某一个UID的连接全部会分配到同一个Worker进程。

在默认的dispatch_mode=2设置下，server会按照socket fd来分配连接数据到不同的Worker进程。因为fd是不稳定的，一个客户端断开后重新连接，fd会发生改变。这样这个客户端的数据就会被分配到别的Worker。使用bind之后就可以按照用户定义的UID进行分配。即使断线重连，相同UID的TCP连接数据会被分配相同的Worker进程。
bool swoole_server::bind(int $fd, int $uid);

$fd 连接的文件描述符
$uid 指定UID
未绑定UID时默认使用fd取模进行分配

同一个连接只能被bind一次，如果已经绑定了UID，再次调用bind会返回false
可以使用$serv->connection_info($fd) 查看连接所绑定UID的值

时序问题

客户端连接服务器后，连续发送多个包，可能会存在时序问题。在bind操作时，后续的包可能已经dispatch，这些数据包仍然会按照fd取模分配到当前进程。只有在bind之后新收到的数据包才会按照UID取模分配。

因此如果要使用bind机制，网络通信协议需要设计握手步骤。客户端连接成功后，先发一个握手请求，之后客户端不要发任何包。在服务器bind完后，并回应之后。客户端再发送新的请求。

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/6
 * Time: 15:00
 */