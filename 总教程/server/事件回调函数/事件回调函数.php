事件回调函数

Swoole\Server是事件驱动模式，所有的业务逻辑代码必须写在事件回调函数中。当特定的网络事件发生后，底层会主动回调指定的PHP函数。

共支持13种事件，具体详情请参考各个页面详细页
PHP语言有4种回调函数的写法

事件执行顺序

所有事件回调均在$server->start后发生
服务器关闭程序终止时最后一次事件是onShutdown
服务器启动成功后，onStart/onManagerStart/onWorkerStart会在不同的进程内并发执行
onReceive/onConnect/onClose在Worker进程中触发
Worker/Task进程启动/结束时会分别调用一次onWorkerStart/onWorkerStop
onTask事件仅在task进程中发生
onFinish事件仅在worker进程中发生

onStart/onManagerStart/onWorkerStart 3个事件的执行顺序是不确定的

异常捕获

swoole不支持set_exception_handler函数
如果你的PHP代码有抛出异常逻辑，必须在事件回调函数顶层进行try/catch来捕获异常


<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/7
 * Time: 14:21
 */
$serv->on('Receive', function () {
    try {
        // some code
    } catch (Exception $e) {
        // exception code
    }
});