1.7.2 swoole增加了多进程管理模块来替代PHP的pcntl，它相比pcntl的不同点是：
swoole_process提供了pcntl没有的进程间通信
swoole_process支持重定向标准输入和输出，在子进程内echo或者读键盘输入可以被重定向为从管道中取数据
子进程可以异步化

进程间通信（IPC）
子进程和父进程之间可以通过管道通信，传递数据。IPC在多进程编程中经常用到，PHP的pcntl模块没有提供IPC的功能，所以功能有局限。而swoole_process提供了这些功能，并且封装了接口。只需调用接口即可完成进程间通信。

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/5
 * Time: 15:29
 */
$worker_num = 8;

for ($i = 0; $i < $worker_num; $i++) {
    $process = new swoole_process('callback_function', $redirect_stdout);
    $pid = $process->start();
    $workers[$pid] = $process;
}

function callback_function(swoole_process $worker) {
//    echo "Worker: start. pid=" . $worker->pid . "\n";
    // recv data from master
    $recv = $worker->read();
    echo "From Master: $recv\n";

    // send data to master
    $worker->write("hello master\n");

    sleep(2);
    $worker->exit(0);
}
?>
read/write 2个方法就是向管道内读写数据。主进程内可以通过write/read 向子进程写入，读取数据。


标准输入/输出重定向
swoole_process支持了标准输入输出的重定向，子进程内echo时，会自动写入管道，而不是打印到屏幕。


子进程异步
swoole_process创建的子进程可以是同步的，也可以是异步的。
<?php
function callback_function_async(swoole_process $worker) {
//    echo "worker: start. pid = " . $worker->pid . "\n";
    // recv data from master
    $GLOBALS['worker'] = $worker;
    swoole_event_add($worker->pipe, function ($pipe) {
        $worker = $GLOBALS['worker'];
        $recv = $worker->read();

        echo "from master: $recv\n";

        // send data to master
        $worker->write("hello master\n");

        sleep(2);

        $worker->exit(0);
    });
}
?>

可以将管道加入到swoole_event中即可实现异步的进程间通信，另外子进程内可以使用swoole_timer/swoole_client/swoole_async这些异步的API。或者使用swoole_event_add直接操作swoole的EventLoop。
其他

swoole_process 1.7.3 还会加入进程CPU亲和设置、守护进程化、使用消息队列/共享内存Channel等特性。
