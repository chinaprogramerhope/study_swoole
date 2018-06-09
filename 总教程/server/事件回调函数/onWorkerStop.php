onWorkerStop

此事件在worker进程终止时发生。在此函数中可以回收worker进程申请的各类资源。原型：
function onWorkerStop(swoole_server $server, int $worker_id);


$worker_id是一个从0-$worker_num之间的数字，表示这个worker进程的ID
$worker_id和进程PID没有任何关系
进程异常结束，如被强制kill、致命错误、core dump 时无法执行onWorkerStop回调函数

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/7
 * Time: 15:06
 */