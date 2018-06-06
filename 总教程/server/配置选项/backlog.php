backlog

Listen队列长度，如backlog => 128，此参数将决定最多同时有多少个等待accept的连接。
关于tcp的backlog

我们知道tcp有三次握手的过程，客户端syn=>服务端syn+ack=>客户端ack，当服务器收到客户端的ack后会将连接放到一个叫做accept queue的队列里面（注1），队列的大小由backlog参数和配置somaxconn 的最小值决定，我们可以通过ss -lt命令查看最终的accept queue队列大小，swoole的主进程调用accept（注2）从accept queue里面取走。 当accept queue满了之后连接有可能成功（注4），也有可能失败，失败后客户端的表现就是连接被重置（注3）或者连接超时，而服务端会记录失败的记录，可以通过 netstat -s|grep 'times the listen queue of a socket overflowed'来查看日志。如果出现了上述现象，你就应该调大该值了。 幸运的是swoole与php-fpm/apache等软件不同，并不依赖backlog来解决连接排队的问题。所以基本不会遇到上述现象。

注1:linux2.2之后握手过程分为syn queue和accept queue两个队列, syn queue长度由tcp_max_syn_backlog决定。
注2:高版本内核调用的是accept4，为了节省一次set no block系统调用。
注3:客户端收到syn+ack包就认为连接成功了，实际上服务端还处于半连接状态，有可能发送rst包给客户端，客户端的表现就是Connection reset by peer。
注4:成功是通过tcp的重传机制，相关的配置有tcp_synack_retries和tcp_abort_on_overflow。


<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/6
 * Time: 20:10
 */