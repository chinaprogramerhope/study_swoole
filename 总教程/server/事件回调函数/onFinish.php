onFinish

当worker进程投递的任务在task_worker中完成时，task进程会通过swoole_server->finish()方法将任务处理的结果发送给worker进程。
void onFinish(swoole_server $serv, int $task_id, string $data);


$task_id是任务的ID
$data是任务处理的结果内容

task进程的onTask事件中没有调用finish方法或者return结果，worker进程不会触发onFinish

执行onFinish逻辑的worker进程与下发task任务的worker进程是同一个进程

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/7
 * Time: 15:39
 */