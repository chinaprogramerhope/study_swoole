max_request

设置worker进程的最大任务数，默认为0，一个worker进程在处理完超过此数值的任务后将自动退出，进程退出后会释放所有内存和资源。

这个参数的主要作用是解决PHP进程内存溢出问题。PHP应用程序有缓慢的内存泄漏，但无法定位到具体原因、无法解决，可以通过设置max_request解决。

max_request只能用于同步阻塞、无状态的请求响应式服务器程序
在swoole中真正维持客户端TCP连接的是master进程，worker进程仅处理客户端发送来的请求，因为客户端是不需要感知Worker进程重启的
纯异步的Server不应当设置max_request
使用Base模式时max_request是无效的

当worker进程内发生致命错误或者人工执行exit时，进程会自动退出。master进程会重新启动一个新的worker进程来继续处理请求

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/6
 * Time: 18:19
 */
// 实例代码

// 创建一个swoole tcp server，我们开启两个worker进程，dispatch mode设置为3(抢占模式)，文件名保存为server.php，代码如下：
$serv = new swoole_server('127.0.0.1', 9501);
$serv->set([
    'worker_num' => 2, // 开启2个worker进程
    'max_request' => 3, // 每个worker进程max request设置为3次
    'dispatch_mode' => 3
]);
// 监听数据接收事件
$serv->on('receive', function ($serv, $fd, $from_id, $data) {
    $serv->send($fd, "Server: " . $data);
});
// 启动服务器
$serv->start();
?>

使用php server.php开启服务后，首先使用 ps aux | grep server.php 看下一下进程PID，一共有四个进程，如图所示：

其中8430和8431分别是master进程和manager进程，剩下两个8434和8435则是两个worker进程。 按照预想，如果我们执行5次请求，那么必然会有一个worker进程会退出并被重新拉起一个新的，结果如下图所示：

注意pid为8434的worker进程已经没有了，新出现的则是pid为8457的worker进程

