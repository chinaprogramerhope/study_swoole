
swoole_server的两种运行模式介绍
单线程模式（SWOOLE_BASE）

这种模式就是传统的异步非阻塞Server。在Reactor内直接回调PHP的函数。如果回调函数中有阻塞操作会导致Server退化为同步模式。worker_num参数对与BASE模式仍然有效，swoole会启动多个Reactor进程。

BASE模式下Reactor和Worker是同一个角色

BASE模式的优点：

BASE模式没有IPC开销，性能更好
BASE模式代码更简单，不容易出错

BASE模式的缺点：

TCP连接是在Worker进程中维持的，所以当某个Worker进程挂掉时，此Worker内的所有连接都将被关闭
少量TCP长连接无法利用到所有Worker进程
TCP连接与Worker是绑定的，长连接应用中某些连接的数据量大，这些连接所在的Worker进程负载会非常高。但某些连接数据量小，所以在Worker进程的负载会非常低，不同的Worker进程无法实现均衡。

BASE模式的适用场景：

如果客户端连接之间不需要交互，可以使用BASE模式。如Memcache、Http服务器等。
进程模式（SWOOLE_PROCESS）

多进程模式是最复杂的方式，用了大量的进程间通信、进程管理机制。适合业务逻辑非常复杂的场景。Swoole提供了完善的进程管理、内存保护机制。 在业务逻辑非常复杂的情况下，也可以长期稳定运行。

Swoole在Reactor线程中提供了Buffer的功能，可以应对大量慢速连接和逐字节的恶意客户端。另外也提供了CPU亲和设置选项，使程序运行的效率更好。

进程模式的优点：

连接与数据请求发送是分离的，不会因为某些连接数据量大某些连接数据量小导致Worker进程不均衡
Worker进程发送致命错误时，连接并不会被切断
可实现单连接并发，仅保持少量TCP连接，请求可以并发地在多个Worker进程中处理

进程模式的缺点：

存在2次IPC的开销，master进程与worker进程需要使用UnixSocket进行通信
不支持某些高级功能，如sendwait、pause、resume等操作



<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/7
 * Time: 16:37
 */