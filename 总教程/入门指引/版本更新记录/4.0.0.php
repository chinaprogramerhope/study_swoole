全新协程内核
新版本4.0基于微信开源的libco实现了全新的协程内核。在保存PHP函数调用栈的基础上，增加了C栈的上下文存储。实现了对所有PHP语法的支持。现在在任意PHP的函数，包括call_user_func、反射、魔术方法、array_map中均可使用协程。

全局变量隔离
新版本中底层对全局变量进行了隔离，现在可以使用Swoole\Process创建多个Swoole\Server实例了。
<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/5
 * Time: 14:37
 */
for ($i = 0; $i < 2; $i++) {
    $p = new swoole_process(function () use ($i) {
        $port = 9501 + $i;
        $http = new swoole_http_server('127.0.0.1', $port);

        $http->on('start', function ($server) use ($port) {
            echo "swoole http server is started at http://127.0.0.1:{$port}\n";
        });

        $http->on('request', function ($request, $response) {
            $response->header('Content-Type', 'text/plain');
            $response->end("hello world\n");
        });

        $http->start();
    }, false, false);
    $p->start();
}
?>

其他更新

修复http2服务器无法向Chrome浏览器客户端发送超过16K数据的问题
增加Channel->peek方法，用于窥视数据
修复Server->pause/resume在SWOOLE_PROCESS下无法使用的问题
移除Linux AIO，现在无论如何设置都使用线程池实现异步文件IO
支持MySQL存储过程

