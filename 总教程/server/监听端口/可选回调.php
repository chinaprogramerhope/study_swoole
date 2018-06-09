
可选回调

监听端口使用on方法可以设置部分回调函数。
TCP服务器

onConnect
onClose
onReceive
onBufferFull
onBufferEmpty

UDP服务器

onPacket
onReceive

Http服务器

onRequest

WebSocket服务器

onMessage
onOpen

不可用回调

以下事件回调函数是Server级别的，只能在swoole_server对象上设置。

onStart
onShutdown
onWorkerStart
onWorkerStop
onManagerStart
onManagerStop
onTask
onFinish
onPipeMessage
onWorkerError


<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/7
 * Time: 14:10
 */