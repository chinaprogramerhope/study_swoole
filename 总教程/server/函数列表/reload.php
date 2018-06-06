swoole_server->reload

重启所有worker进程。
bool swoole_server->reload(bool $only_reload_taskworker = false);

$only_reload_taskworkrer 是否仅重启task进程

一台繁忙的后端服务器随时都在处理请求，如果管理员通过kill进程方式来终止/重启服务器程序，可能导致刚好代码执行到一半终止。

这种情况下会产生数据的不一致。如交易系统中，支付逻辑的下一段是发货，假设在支付逻辑之后进程被终止了。会导致用户支付了货币，但并没有发货，后果非常严重。

Swoole提供了柔性终止/重启的机制，管理员只需要向SwooleServer发送特定的信号，Server的worker进程可以安全的结束。

SIGTERM: 向主进程/管理进程发送此信号服务器将安全终止
在PHP代码中可以调用$serv->shutdown()完成此操作
SIGUSR1: 向主进程/管理进程发送SIGUSR1信号，将平稳地restart所有worker进程
在PHP代码中可以调用$serv->reload()完成此操作
swoole的reload有保护机制，当一次reload正在进行时，收到新的重启信号会丢弃
如果设置了user/group，Worker进程可能没有权限向master进程发送信息，这种情况下必须使用root账户，在shell中执行kill指令进行重启
reload指令对addProcess添加的用户进程无效

#重启所有worker进程
kill -USR1 主进程PID

1.7.7版本增加了仅重启task_worker的功能。只需向服务器发送SIGUSR2即可。
#仅重启task进程
kill -USR2 主进程PID

平滑重启只对onWorkerStart或onReceive等在Worker进程中include/require的PHP文件有效，Server启动前就已经include/require的PHP文件，不能通过平滑重启重新加载
对于Server的配置即$serv->set()中传入的参数设置，必须关闭/重启整个Server才可以重新加载
Server可以监听一个内网端口，然后可以接收远程的控制命令，去重启所有worker

Process模式
在Process模式下，来自客户端的TCP连接是在Master进程内维持的，worker进程的重启和异常退出，不会影响连接本身。

Reload有效范围
Reload操作只能重新载入Worker进程启动后加载的PHP文件，建议使用get_included_files函数来列出哪些文件是在WorkerStart之前就加载的PHP文件，在此列表中的PHP文件，即使进行了reload操作也无法重新载入。比如要关闭服务器重新启动才能生效。
$serv->on('WorkerStart', function ($serv, $workerId) {
    var_dump(get_included_files()); // 此数组中的文件表示进程启动前就加载了，所以无法reload
});

APC/OpCache

如果PHP开启了APC/OpCache，reload重载入时会受到影响，有2种解决方案

打开APC/OpCache的stat检测，如果发现文件更新APC/OpCache会自动更新OpCode
在onWorkerStart中执行apc_clear_cache或opcache_reset刷新OpCode缓存

参考

附录：Linux信号列表

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/6
 * Time: 11:57
 */