创建一个异步服务器程序，支持TCP、UDP、UnixSocket 3种协议，支持IPv4和IPv6，支持SSL/TLS单向双向证书的隧道加密。使用者无需关注底层实现细节，仅需要设置网络事件的回调函数即可。

请勿在使用swoole_server之前调用其他异步IO的API，否则将无法创建swoole_server。可以在Server启动后，onWorkerStart回调函数中使用。

swoole_server只能用于php-cli环境，否则会抛出致命错误

构建Server对象
$serv = new swoole_server('0.0.0.0', 9501, SWOOLE_BASE, SWOOLE_SOCK_TCP);

设置运行时参数
$serv->set([
    'worker_num' => 4,
    'daemonize' => true,
    'backlog' => 128,
]);

注册事件回调函数
$serv->on('Connect', 'my_onConnect');
$serv->on('Receive', 'my_onReceive');
$serv->on('Close', 'my_onClose');
PHP中可以使用4种回调函数的风格

启动服务器
$serv->start();

属性列表
$serv->manager_pid; // 管理进程的PID，通过向管理进程发送SIGUSR1信号可实现柔性重启
$serv->master_pid; // 主进程的PID，通过向主进程发送SIGTERM信号可安全关闭服务器
$serv->connections; // 当前服务器的客户端连接，可使用foreach遍历所有连接

<?php
/**
 * Created by PhpStorm.
 * User: ftd20
 * Date: 2018/6/6
 * Time: 8:38
 */