task进程有别于worker进程，worker进程内有EventLoop，所以即可同步阻塞，又可以异步非阻塞。但task进程设计之初就是仅仅支持同步阻塞模式的。

而swoole的毫秒定时器是使用timerfd实现的异步定时器。所以在1.7.4之前，task进程中是无法使用定时器的。1.7.4专门对task进程进行了优化，实现了同步的信号触发式定时器。

swoole并不是在信号回调函数中执行定时器代码，所以不存在安全问题。

使用方法与普通的worker进程相同。

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/5
 * Time: 16:13
 */
function onWorkerStart($serv, $worker_id) {
    if ($worker_id >= $serv->setting['worker_num']) { // 超过worker_num, 表示这是一个task进程
        $serv->tick(1000); // 1s
        $serv->after(200); // 200ms
    }
}