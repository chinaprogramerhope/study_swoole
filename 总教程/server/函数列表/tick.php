swoole_server->tick

tick定时器，可以自定义回调函数。此函数是swoole_timer_tick的别名。

worker进程结束运行后，所有定时器都会自动销毁
tick/after定时器不能在swoole_server->start之前使用

在onReceive中使用
function onReceive($server, $fd, $from_id $data) {
    $server->tick(1000, function() use ($server, $fd) {
        $server->send($fd, 'hello world');
    });
}

在onWorkerStart中使用

低于1.8.0版本task进程不能使用tick/after定时器，所以需要使用$serv->taskworker进行判断
task进程可以使用addtimer间隔定时器
function onWorkerStart(swoole_server $serv, $worker_id) {
    if (!$serv->taskworker) {
        $serv->tick(1000, function ($id) {
            var_dump($id);
        });
    } else {
        $serv->addtimer(1000);
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/6
 * Time: 12:19
 */