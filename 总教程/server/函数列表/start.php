swoole_server->start

启动server，监听所有TCP/UDP端口，函数原型：
bool swoole_server->start();

启动成功后会创建worker_num+2个进程。Master进程+Manager进程+serv->worker_num个Worker进程。
启动失败会立即返回false
启动成功后将进入事件循环，等待客户端连接请求。start方法之后的代码不会执行
服务器关闭后，start函数返回true，并继续向下执行

设置了task_worker_num会增加相应数量的Task进程
函数列表中start之前的方法仅可在start调用前使用，在start之后的方法仅可在onWorkerStart、onReceive等事件回调函数中使用

主进程

主进程内有多个Reactor线程，基于epoll/kqueue进行网络事件轮询。收到数据后转发到worker进程去处理
Manager进程

对所有worker进程进行管理，worker进程生命周期结束或者发生异常时自动回收，并创建新的worker进程
worker进程

对收到的数据进行处理，包括协议解析和响应请求。

启动失败扩展内会抛出致命错误，请检查php error_log的相关信息。errno={number}是标准的Linux Errno，可参考相关文档。
如果开启了log_file设置，信息会打印到指定的Log文件中。

如果想要在开机启动时，自动运行你的Server，可以在/etc/rc.local文件中加入

/usr/bin/php /data/webroot/www.swoole.com/server.php

常见的错误有：

bind端口失败,原因是其他进程已占用了此端口
未设置必选回调函数，启动失败
php有代码致命错误，请检查php的错误信息php_err.log
执行ulimit -c unlimited，打开core dump，查看是否有段错误
关闭daemonize，关闭log，使错误信息可以打印到屏幕

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/6
 * Time: 11:53
 */