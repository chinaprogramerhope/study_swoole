swoole_process->start

执行fork系统调用, 启动进程.
function swoole_process->start() : int 

创建成功返回紫禁城的pid, 创建失败返回false. 可使用swoole_errno和swoole_strerror得到错误码和错误信息.

$process->pid属性为紫禁城的pid
$process->pipe属性为管道的文件描述符
子进程会继承父进程的内存和文件句柄
子进程在启动时会清除从父进程继承的EventLoop, Signal, Timer

执行后子进程会保持父进程的内存和资源, 如父进程内创建了一个redis连接, 
那么在子进程会保留此对象, 所有操作都是对同一个连接进行的.

<?php
// 实例
$redis = new $redis;
$redis->connect('127.0.0.1', 6379);

function callback_function() {
    swoole_timer_after(10000, function () {
        echo "hello world";
    });
    global $redis;
}

swoole_timer_tick(1000, function () {
    echo "parent timer\n";
});

swoole_process::signal(SIGCHLD, function ($sig) {
    while ($ret = Swoole\Process::wait(false)) {
        // create a new child process
        $p = new Swoole\Process('callback_function');
        $p->start();
    }
});

// create a new child process
$p = new Swoole\Process('callback_function');

swoole_event_add($p->pipe, function ($pipe) use ($p) {
    echo $p->read();
});

$p->start();
?>

子进程启动后会自动清除父进程中swoole_timer_tick创建的定时器, swoole_process::signal监听的信号和
swoole_event_add添加的事件监听.

子进程会继承父进程创建的$redis连接对象, 父子进程使用的连接是同一个.