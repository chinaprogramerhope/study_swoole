onStart

Server启动在主进程的主线程回调此函数，函数原型
function onStart(swoole_server $server);

在此事件之前Swoole Server已进行了如下操作

已创建了manager进程
已创建了worker子进程
已监听所有TCP/UDP/UnixSocket端口，但未开始Accept连接和请求
已监听了定时器

接下来要执行

主Reactor开始接收事件，客户端可以connect到Server

onStart回调中，仅允许echo、打印Log、修改进程名称。不得执行其他操作。onWorkerStart和onStart回调是在不同进程中并行执行的，不存在先后顺序。

可以在onStart回调中，将$serv->master_pid和$serv->manager_pid的值保存到一个文件中。这样可以编写脚本，向这两个PID发送信号来实现关闭和重启的操作。

从1.7.5+ Master进程内不再支持定时器，onMasterConnect/onMasterClose2个事件回调也彻底移除。Master进程内不再保留任何PHP的接口。

onStart事件在Master进程的主线程中被调用。

在onStart中创建的全局资源对象不能在worker进程中被使用，因为发生onStart调用时，worker进程已经创建好了。
新创建的对象在主进程内，worker进程无法访问到此内存区域。
因此全局对象创建的代码需要放置在swoole_server_start之前。

安全提示

onStart和onShutdown事件是在master进程的master线程内执行，执行过多异步IO操作可能会带来安全隐患，因此底层关闭了异步IO。

onStart回调在return之前服务器程序不会接受任何客户端连接，因此可以安全地使用CURL等PHP提供的同步IO函数。

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/7
 * Time: 14:21
 */