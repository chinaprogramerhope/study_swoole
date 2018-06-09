onPipeMessage

当工作进程收到由 sendMessage 发送的管道消息时会触发onPipeMessage事件。worker/task进程都可能会触发onPipeMessage事件。函数原型：
void onPipeMessage(swoole_server $server, int $src_worker_id, mixed $message);

$src_worker_id消息来自哪个Worker进程
$message消息内容，可以是任意PHP类型

onPipeMessage在1.7.9以上版本可用


<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/7
 * Time: 15:41
 */