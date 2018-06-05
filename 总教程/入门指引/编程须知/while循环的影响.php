异步程序如果遇到死循环，事件将无法触发。异步IO程序使用Reactor模型，运行过程中必须在reactor->wait处轮询。如果遇到死循环，那么程序的控制权就在while中了，reactor无法得到控制权，无法检测事件，所以IO事件回调函数也将无法触发。

密集运算的代码没有任何IO操作，所以不能称为阻塞

实例程序

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/5
 * Time: 14:23
 */
$serv = new swoole_server('127.0.0.1', 9501);
$serv->set([
    'worker_num' => 1
]);
$serv->on('receive', function ($serv, $fd, $reactorId, $data) {
    while (1) {
        $i++;
    }
    $serv->send($fd, 'swoole: ' . $data);
});
$serv->start();
?>

onReceive事件中执行了死循环，server无法再收到任何客户端请求，必须等待循环结束才能继续处理新的事件。
