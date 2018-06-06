swoole_server->shutdown

关闭服务器
void swoole_server->shutdown();

此函数可以用在worker进程内。向主进程发送SIGTERM也可以实现关闭服务器。
kill -15 主进程PID

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/6
 * Time: 12:18
 */