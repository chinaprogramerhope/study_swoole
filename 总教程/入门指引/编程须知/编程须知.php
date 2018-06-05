编程须知

这个频道内会详细介绍异步编程与同步编程的不同之处以及需要注意的事项。
注意事项

不要在代码中执行sleep以及其他睡眠函数，这样会导致整个进程阻塞
exit/die是危险的，会导致Worker进程退出
可通过register_shutdown_function来捕获致命错误，在进程异常退出时做一些清理工作，具体参考 /wiki/page/305.html
PHP代码中如果有异常抛出，必须在回调函数中进行try/catch捕获异常，否则会导致工作进程退出
不支持set_exception_handler，必须使用try/catch方式处理异常
Worker进程不得共用同一个Redis或MySQL等网络服务客户端，Redis/MySQL创建连接的相关代码可以放到onWorkerStart回调函数中，具体参考 /wiki/page/325.html

异步编程

异步程序要求代码中不得包含任何同步阻塞操作
异步与同步代码不能混用，一旦应用程序使用了任何同步阻塞的代码，程序即退化为同步模式

协程编程

使用Coroutine特性，请认真阅读 协程编程须知
类/函数重复定义

新手非常容易犯这个错误，由于Swoole是常驻内存的，所以加载类/函数定义的文件后不会释放。因此引入类/函数的php文件时必须要使用include_once或require_once，否会发生cannot redeclare function/class 的致命错误。
内存管理

PHP守护进程与普通Web程序的变量生命周期、内存管理方式完全不同。请参考 swoole_server内存管理 页面。编写swoole_server或其他常驻进程时需要特别注意。
进程隔离

进程隔离也是很多新手经常遇到的问题。修改了全局变量的值，为什么不生效，原因就是全局变量在不同的进程，内存空间是隔离的，所以无效。所以使用Swoole开发Server程序需要了解进程隔离问题。

不同的进程中PHP变量不是共享，即使是全局变量，在A进程内修改了它的值，在B进程内是无效的
如果需要在不同的Worker进程内共享数据，可以用Redis、MySQL、文件、Swoole\Table、APCu、shmget等工具实现
不同进程的文件句柄是隔离的，所以在A进程创建的Socket连接或打开的文件，在B进程内是无效，即使是将它的fd发送到B进程也是不可用的

实例：
<?php
$server = new Swoole\Http\Server('127.0.0.1', 9500);

$i = 1;

$server->on('Request', function ($request, $response) {
    global $i;
    $response->end($i++);
});

$server->start();
?>

在多进程的服务器中，$i变量虽然是全局变量(global)，但由于进程隔离的原因。假设有4个工作进程，在进程1中进行$i++，实际上只有进程1中的$i变成2了，其他另外3个进程内$i变量的值还是1。

正确的做法是使用Swoole提供的Swoole\Atomic或Swoole\Table数据结构来保存数据。如上述代码可以使用Swoole\Atomic实现。

<?php
$server = new swoole\Http\Server('127.0.0.1', 9500);

$atomic = new Swoole\Atomic(1);

$server->on('Request', function ($request, $response) use ($atomic) {
    $response->end($atomic->add(1));
});

$server->start();
?>

Swoole\Atomic数据是建立在共享内存之上的，使用add方法加1时，在其他工作进程内也是有效的































