<?php
/**
 * Created by PhpStorm.
 * User: ftd20
 * Date: 2018/6/5
 * Time: 6:40
 */
// ws_server.php

// 创建websocket服务器对象, 监听0.0.0.0:9502端口
$ws = new swoole_websocket_server('0.0.0.0', 9502);

// 监听websocket连接打开事件
$ws->on('open', function ($ws, $request) {
    var_dump($request->fd, $request->get, $request->server);
    $ws->push($request->fd, "hello, welcome\n");
});

// 监听websocket消息事件
$ws->on('message', function ($ws, $frame) {
    echo "Message: {$frame->data}\n";
    $ws->push($frame->fd, "server: {$frame->data}");
});

// 监听websocket连接关闭事件
$ws->on('close', function ($ws, $fd) {
    echo "client-{$fd} is closed\n";
});

$ws->start();
?>

运行程序

php ws_server.php

可以使用Chrome浏览器进行测试，JS代码为：
var wsServer = 'ws://127.0.0.1:9502';
var webSocket = new WebSocket(wsServer);
webSocket.onopen = function (evt) {
    console.log("connected to websocket server.");
};

webSocket.onclose = function (evt) {
    console.log("disconnected");
};

webSocket.onmessage = function (evt) {
    console.log("retrieved data from server: " + evt.data);
};

webSocket.onerror = function (evt, e) {
    console.log("error occured: " + evt.data);
};


不能直接使用swoole_client与websocket服务器通信，swoole_client是TCP客户端
必须实现WebSocket协议才能和WebSocket服务器通信，可以使用swoole/framework提供的PHP WebSocket客户端

Comet

WebSocket服务器除了提供WebSocket功能之外，实际上也可以处理Http长连接。只需要增加onRequest事件监听即可实现Comet方案Http长轮询。