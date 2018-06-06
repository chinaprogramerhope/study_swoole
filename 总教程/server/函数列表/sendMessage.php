swoole_server->sendMessage

此函数可以向任意worker进程或者task进程发送消息。在非主进程和管理进程中可调用。收到消息的进程会触发onPipeMessage事件。
bool swoole_server->sendMessage(mixed $message, int $dst_worker_id);

参数
$message为发送的消息数据内容，没有长度限制，但超过8K时会启动内存临时文件
$dst_worker_id为目标进程的ID，范围是0 ~ (worker_num + task_worker_num - 1)
在Task进程内调用sendMessage是阻塞等待的，发送消息完成后返回
在Worker进程内调用sendMessage是异步的，消息会先存到发送队列，可写时向管道发送此消息
在User进程内调用sendMessage底层会自动判断当前的进程是异步还是同步选择不同的发送方式

返回值

发送成功返回true，失败返回false

sendMessage接口在1.7.9以上版本可用
MacOS/FreeBSD下超过2K就会使用临时文件存储

注意事项

使用sendMessage必须注册onPipeMessage事件回调函数
设置了task_ipc_mode = 3将无法使用sendMessage向特定的task进程发送消息


<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/6
 * Time: 14:34
 */
// 实例
$serv = new swoole_server('0.0.0.0', 9501);
$serv->set([
    'worker_num' => 2,
    'task_worker_num' => 2,
]);
$serv->on('pipeMessage', function ($serv, $src_worker_id, $data) {
    echo "#{$serv->worker_id} message from #$src_worker_id: $data\n";
});
$serv->on('task', function ($serv, $task_id, $from_id, $data) {
    var_dump($task_id, $from_id, $data);
});
$serv->on('finish', function ($serv, $fd, $from_id) {

});
$serv->on('receive', function (swoole_server $serv, $fd, $from_id, $data) {
    if (trim($data) == 'task') {
        $serv->task('async task coming');
    } else {
        $worker_id = 1 - $serv->worker_id;
        $serv->sendMessage('hello task process', $worker_id);
    }
});

$serv->start();