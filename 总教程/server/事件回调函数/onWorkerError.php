onWorkerError

当worker/task_worker进程发生异常后会在Manager进程内回调此函数。
void onWorkerError(swoole_server $serv, int $worker_id, int $worker_id, int $exit_code, int $signal);

$worker_id 是异常进程的编号
$worker_pid 是异常进程的ID
$exit_code 退出的状态码，范围是 1 ～255
$signal 进程退出的信号

此函数主要用于报警和监控，一旦发现Worker进程异常退出，那么很有可能是遇到了致命错误或者进程CoreDump。通过记录日志或者发送报警的信息来提示开发者进行相应的处理。

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/7
 * Time: 15:43
 */