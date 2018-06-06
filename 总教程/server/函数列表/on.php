注册server的事件回调函数
bool swoole_server->on(string $event, mixed $callback);

第1个参数是回调的名称, 大小写不敏感，具体内容参考回调函数列表，事件名称字符串不要加on
第2个函数是回调的PHP函数，可以是函数名的字符串，类静态方法，对象方法数组，匿名函数。

重复调用on方法时会覆盖上一次的设定

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/6
 * Time: 11:28
 */
$serv = new swoole_server('127.0.0.1', 9501);
$serv->on('connect', function ($serv, $fd) {
    echo "Client: Connect.\n";
});
$serv->on('receive', function ($serv, $fd, $from_id, $data) {
    $serv->send($fd, 'Swoole: ' . $data);
    $serv->close($fd);
});
$serv->on('close', function ($serv, $fd) {
    echo "Client: Close.\n";
});
$serv->start();