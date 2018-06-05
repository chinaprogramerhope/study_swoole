1.9.17版本重构了底层WorkerStop的机制，实现了异步安全重启的特性。包括stop、reload、max_request 3个特性全部复用了一套代码。都支持了异步安全重启。

之前的版本 Worker进程收到SIGTERM、达到max_request时，会立即停止服务，这时Worker进程内可能仍然有事件监听，这些异步任务将会被丢弃。新版本中会先创建新的Worker，旧的Worker在完成所有事件之后自行退出。为了防止某些Worker一直不退出，底层还增加了一个30秒的定时器，在约定的时间内旧Worker没有退出，底层会强行终止。

可设置server->max_wait_time修改Worker进程最大等待时间，默认为30秒

实现原理

Worker进程收到SIGTERM、达到max_request时，移除管道监听，立即回调onWorkerStop，并通知Manager进程。这时当前的Worker不会再收到任何客户端请求数据
Worker进程会设置一个30秒的超时定时器，实现退出超时
Manager进程收到Worker进程的消息后，创建新的Worker
新的Worker继续处理客户端请求数据
旧的Worker会持续触发onWorkerExit事件，PHP代码可以此事件回调函数中实现清理逻辑
旧的Worker会持续检测EventLoop中的socket数量，在没有任何事件监听后退出进程
旧的Worker在30秒内仍然没有完成异步IO任务，底层强制终止运行，退出进程

进程退出事件

为了支持异步重启特性，底层新增了一个onWorkerExit事件，当旧的Worker即将退出时，会持续触发onWorkerExit事件，在此事件回调函数中，应用层可以尝试清理某些长连接Socket

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/5
 * Time: 17:00
 */
$serv->on('WorkerExit', function (swoole_server $serv, $worker_id) {
    $redisState = $serv->redis->getState();
    if ($redisState == Swoole\Redis::STATE_READY or $redisState == Swoole\Redis::STATE_SUBSCRIBE) {
        $serv->redis->close();
    }
});
?>

设置等待时间
<?php
$serv->set([
    'max_wait_time' => 60
]);
?>

开启方式
onWorkerExit 回调功能需要设置 reload_async = true 才能开启
<?php
$serv->set([
    'reload_async' => true
]);
