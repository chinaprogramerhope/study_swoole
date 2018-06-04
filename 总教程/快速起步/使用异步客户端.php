PHP提供的MySQL、CURL、Redis 等客户端是同步的，会导致服务器程序发生阻塞。Swoole提供了常用的异步客户端组件，来解决此问题。编写纯异步服务器程序时，可以使用这些异步客户端。

异步客户端可以配合使用SplQueue实现连接池，以达到长连接复用的目的。在实际项目中可以使用PHP提供的Yield/Generator语法实现半协程的异步框架。也可以基于Promises简化异步程序的编写

<?php
/**
 * Created by PhpStorm.
 * User: ftd20
 * Date: 2018/6/5
 * Time: 7:30
 */
// mysql
$db = new Swoole\Mysql();
$server = [
    'host' => '127.0.0.1',
    'user' => 'test',
    'password' => 'test',
    'database' => 'test',
];

$db->connect($server, function ($db, $result) {
    $db->query('show tables', function (Swoole\Mysql $db, $result) {
        var_dump($result);
        $db->close();
    });
});
?>
与mysqli和PDO等客户端不同，Swoole\MySQL是异步非阻塞的，连接服务器、执行SQL时，需要传入一个回调函数。connect的结果不在返回值中，而是在回调函数中。query的结果也需要在回调函数中进行处理。


<?php
// redis
$redis = new Swoole\Redis();
$redis->connect('127.0.0.1', 6379, function ($redis, $result) {
    $redis->set('test_key', 'value', function ($redis, $result) {
        $redis->get('test_key', function ($redis, $result) {
            var_dump($result);
        });
    });
});

// http
$cli = new Swoole\Http\Client('127.0.0.1', 80);
$cli->setHeaders([
    'User-Agent' => 'swoole-http-client'
]);
$cli->setCookies([
    'test' => 'value'
]);

$cli->post('/dump.php', ['test' => 'abc'], function ($cli) {
    var_dump($cli->body);
    $cli->get('/index.php', function ($cli) {
        var_dump($cli->cookies);
        var_dump($cli->headers);
    });
});
?>

Swoole\Http\Client的作用与CURL完全一致，它完整实现了Http客户端的相关功能。具体请参考 HttpClient文档
其他客户端

Swoole底层目前只提供了最常用的MySQL、Redis、Http异步客户端，如果你的应用程序中需要实现其他协议客户端，如Kafka、AMQP等协议，可以基于Swoole\Client异步TCP客户端，开发相关协议解析代码，来自行实现。
