swoole_server->addProcess

添加一个用户自定义的工作进程。此函数通常用于创建一个特殊的工作进程，用于监控、上报或者其他特殊的任务。
bool swoole_server->addProcess(swoole_process $process);
此函数在swoole-1.7.9以上版本可用

参数
$process 为swoole_process对象，注意不需要执行start。在swoole_server启动时会自动创建进程，并执行指定的子进程函数
创建的子进程可以调用$server对象提供的各个方法，如connection_list/connection_info/stats
在worker/task进程中可以调用$process提供的方法与子进程进行通信
在用户自定义进程中可以调用$server->sendMessage与worker/task进程通信

返回值
添加成功返回true，失败返回false
注意事项

自定义进程会托管到Manager进程，如果发生致命错误，Manager进程会重新创建一个
自定义进程不受reload指令控制，reload时不会向用户进程发送任何信息
在shutdown关闭服务器时，会向自定义进程发送SIGTERM信号
自定义进程内不能使用swoole_server->task/taskwait接口


<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/6
 * Time: 11:37
 */
// 示例程序
$server = new swoole_server('127.0.0.1', 9501);

$process = new swoole_process(function ($process) use ($server) {
    while (true) {
        $msg = $process->read();
        foreach ($server->connections as $conn) {
            $server->send($conn, $msg);
        }
    }
});

$server->addProcess($process);

$server->on('receive', function ($serv, $fd, $from_id, $data) use ($process) {
    // 群发收到的消息
    $process->write($data);
});

$server->start();