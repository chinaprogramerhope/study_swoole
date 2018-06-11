swoole_process::__construct

创建子进程

swoole_process::__construct(callable $function, $redirect_stdin_stdout = false, $create_pipe = true);

// 启用命名空间
Swoole\Process::__construct(callable $function, $redirect_stdin_stdout = false, $create_pipe = true);

    $function，子进程创建成功后要执行的函数，底层会自动将函数保存到对象的callback属性上。如果希望更改执行的函数，可赋值新的函数到对象的callback属性
    $redirect_stdin_stdout，重定向子进程的标准输入和输出。启用此选项后，在子进程内输出内容将不是打印屏幕，而是写入到主进程管道。读取键盘输入将变为从管道中读取数据。默认为阻塞读取。
    $create_pipe，是否创建管道，启用$redirect_stdin_stdout后，此选项将忽略用户参数，强制为true。如果子进程内没有进程间通信，可以设置为 false
====



create_pipe参数

自 1.7.22 版本起参数$create_pipe为int类型且允许设置管道的类型，其默认值为2，默认使用DGRAM管道。

    参数 $create_pipe 小于等于0或为 false 时，不创建管道
    参数 $create_pipe 为1或为 true 时，管道类型将设置为 SOCK_STREAM
    参数$create_pipe为2时，管道类型将设置为SOCK_DGRAM
    启用$redirect_stdin_stdout 后，此选项将忽略用户参数，强制为1

    自 1.9.6 版本以后，参数 $create_pipe 默认值为 2，启用$redirect_stdin_and_stdout （即 redirect_stdin_and_stdout 为 true）后强制为 1
    1.8.3 ~ 1.9.5 版本，参数 $create_pipe 默认值为 2，启用 $redirect_stdin_and_stdout （即 redirect_stdin_and_stdout 为 true）后强制为 2
    1.7.22 ~ 1.8.2 版本，参数$create_pipe 默认值为1，启用 $redirect_stdin_and_stdout （即 redirect_stdin_and_stdout 为 true）后强制为 1
    swoole_process ( 或 Swoole\Process) 对象在销毁时会自动关闭管道，子进程内如果监听了管道会收到CLOSE事件
    使用swoole_process作为监控父进程，创建管理子process时，父类必须注册信号SIGCHLD对退出的进程执行wait，否则子process一旦被kill会引起父process exit
====



在子进程中创建swoole_server

例 1：

可以在 swoole_process 创建的子进程中使用 swoole_server，但为了安全必须在$process->start 创建进程后，调用 $worker->exec() 执行。代码如下：
<?php
$process = new swoole_process('callback_function', false);

$pid = $process->start();

function callback_function(swoole_process $worker) {
    $worker->exec('/usr/local/bin/php', [__DIR__ . '/swoole_server.php']);
}

swoole_process::wait();
?>

例 2：使用匿名函数作为进程逻辑，并实现了一个简单的父子进程通讯
<?php
$process = new swoole_process(function (swoole_process $process) {
    $process->write('hello');
}, true);

$process->start();
usleep(100);

echo $process->read(); // 输出hello
?>
====



io线程池问题
由于Swoole的异步文件IO使用了线程池，在使用了这些API之后再创建Process可能会出现非常复杂的带线程fork问题。因此请勿在使用异步文件IO函数后创建Process。

    2.1.4/1.10.4或更高版本已经禁止了这种行为，底层检测到已创建线程池再执行new Process会抛出致命错误
