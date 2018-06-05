新版协程

在最新的3.0版本中，我们实现了一个全新的 PHP 内置协程调度器，基于ZendVM 的 EG(vm_interrupt) 机制实现，移除了 setjmp/longjmp 的依赖。使得 Swoole 协程可以应用于任何位置，包括PHP 对象析构函数、魔术方法、反射函数调用 等场景，新的版本号将更改为Swoole 3.0，原计划基于libco的C栈协程，推迟到4.0。

新版协程内核依赖PHP-7.1，因此Swoole对PHP的版本依赖提高至7.1，对gcc的版本依赖提高至4.8。
Socket 模块

3.0版本提供了一个更底层Co\Socket模块，封装了操作系统socket相关API。某些情况下Server和Client无法满足需求，这时可以使用Co\Socket自行实现Server和Client功能。

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/5
 * Time: 14:51
 */
// server端
$socket = new Co\Socket(AF_INET, SOCK_STREAM, 0);
$socket->bind('127.0.0.1', 9601);
$socket->listen(128);

go(function () use ($socket) {
    while (true) {
        echo "accept: \n";
        $client = $socket->accept();

        echo "new coroutine: \n";
        go(function () use ($client) {
            while (true) {
                echo "client rece: \n";
                $data = $client->recv();
                if (empty($data)) {
                    $client->close();
                    break;
                }
                var_dump($client->getsockname());
                var_dump($client->getpeername());
                echo "client send: \n";
                $client->send("server: $data");
            }
        });
    }
});

// client端
$socket = new Cp\Socket(AF_INET, SOCK_STREAM, 0);

go(function () use ($socket) {
    $retval = $socket->connect('localhost', 9601);
    while ($retval) {
        $n = $socket->send('hello');
        var_dump($n);

        $data = $socket->recv();
        var_dump($data);

        if (empty($data)) {
            $socket->close();
            break;
        }
        co::sleep(1.0);
    }
    var_dump($retval, $socket->errCode);
});
?>

支持 C/C++ 混合开发

从3.0版本开始，我们使用了C++作为主要的开发语言。新增的模块基于C++ 11进行开发。以降低开发成本，提升效率。

编译3.0版本，需要gcc-4.8或更高版本。另外，3.0还引入了PHP-X，某些模块将会基于PHP-X进行开发。
其他更新

增加Http\Response->detach和Http\Response::create方法
增加Http\Response->redirect方法
增加Runtime::enableStrictMode方法，可禁用PHP提供的同步阻塞函数和类
修复Co\Redis连接失败时发生内存泄漏的问题
修复SOCK_DGRAM类型客户端连接被拒绝时抛出的无效错误日志


























