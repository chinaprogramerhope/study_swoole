
并发10万TCP连接的测试

代码在examples/c10k.php中，本测试启动10个子进程，发起长连接到Swoole的TCP Server.

由于单台机器的原因，ip_local_port_range的范围是32000-60000。 运行到28000个长连接时，由于local port不够用，无法再继续连接。

并发测试中使用4台客户端机器同时连接服务器，每台机器与服务器建立2.8W个TCP连接。TCP Server共维持了11.2W长连接。

Swoole使用epoll作为事件轮询，可维持大量TCP连接。只要操作系统的内存足够，就一直可以增加维持的TCP长连接。

swoole_server每个连接所占用的内存为220字节，使用数据缓存，如EOF_CHECK/LENGTH_CHECK后可能会增加到每连接8K。

<?php