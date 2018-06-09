在php-fpm/apache中使用task功能

AsyncTask是swoole提供一套生产者消费者模型，可以方便地将一个慢速任务投递到队列，由进程池异步地执行。task功能目前只能在swoole_server中使用。1.9.0版本提供了RedisServer框架，可以基于RedisServer和Task实现一个Server程序，在php-fpm或apache中直接调用Redis扩展就可以使用swoole的task功能了。

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/7
 * Time: 17:10
 */
// 创建RedisServer
use Swoole\Redis\Server;

$server = new Server('127.0.0.1', 9501, SWOOLE_BASE);

$server->set([
    'task_worker_num' => 32,
    'worker_num' => 1,
]);

$server->setHandler('LPUSH', function ($fd, $data) use ($server) {
    $taskId = $server->task($data);
    if ($taskId === false) {
        return Server::format(Server::ERROR);
    } else {
        return Server::format(Server::INT, $taskId);
    }
});

$server->on('Finish', function () {

});

$server->on('Task', function ($serv, $taskId, $workerId, $data) {
    // 处理任务
});

$server->start();
?>

如果是本机调用可以监听UnixSocket，局域网内调用需要使用IP:PORT
Task中$data就是客户端投递的数据
其他语言也可以使用Redis客户端投递任务
可以根据Task任务执行的速度调节task_worker_num控制启动的进程数量，这些进程是由swoole底层负责管理的，在发生致命错误或进程退出后底层会重新创建新的任务进程


<?php
// 投递任务
$redis = new Redis;
$redis->connect('127.0.0.1', 9501);
$taskId = $redis->lPush('myqueue', json_encode(['hello', 'swoole']));
?>

注意这个RedisServer并不是一台真正的Redis服务器，它只支持LPUSH一个指令。


