sleep/usleep的影响
在异步IO的程序中，不得使用sleep/usleep/time_sleep_until/time_nanosleep。（下文中使用sleep泛指所有睡眠函数）

sleep函数会使进程陷入睡眠阻塞
直到指定的时间后操作系统才会重新唤醒当前的进程
sleep过程中，只有信号可以打断
由于Swoole的信号处理是基于signalfd实现的，所以即使发送信号也无法中断sleep

Swoole提供的swoole_event_add、swoole_timer_tick、swoole_timer_after、swoole_process::signal、异步swoole_client 在进程sleep后会停止工作。swoole_server也无法再处理新的请求。
实例程序

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/5
 * Time: 14:16
 */
$serv = new swoole_server('127.0.0.1', 9501);
$serv->set([
    'worker_num' => 1
]);
$serv->on('receive', function ($serv, $fd, $from_id, $data) {
    sleep(100);
    $serv->send($fd, 'swoole: ' . $data);
});
$serv->start();
?>

onReceive事件中执行了sleep函数，server在100秒内无法再收到任何客户端请求。
