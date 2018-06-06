swoole_server->task

投递一个异步任务到task_worker池中。此函数是非阻塞的，执行完毕会立即返回。Worker进程可以继续处理新的请求。使用Task功能，必须先设置 task_worker_num，并且必须设置Server的onTask和onFinish事件回调函数。
int swoole_server::task(mixed $data, int $dst_worker_id = -1) {
    $task_id = $serv->task('some data');
    // swoole-1.8.6或更高版本
    $serv->task('taskcallback', -1, function (swoole_server $serv, $task_id, $data) {
        echo "task callback: ";
        var_dump($task_id, $data);
    });
}

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/6
 * Time: 15:09
 */