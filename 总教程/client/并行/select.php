swoole_client_select

swoole_client的并行处理中用了select来做IO事件循环。
函数原型：
int swoole_client_select(array &$read, array &$write, array &$error, float $timeout);

    swoole_client_select接受4个参数，$read, $write, $error 分别是可读/可写/错误的文件描述符。
    这3个参数必须是数组变量的引用。数组的元素必须为swoole_client对象。 1.8.6或更高版本可以支持swoole_process对象
    此方法基于select系统调用，最大支持1024个socket
    $timeout参数是select系统调用的超时时间，单位为秒，接受浮点数

调用成功后，会返回事件的数量，并修改$read/$write/$error数组。使用foreach遍历数组，然后执行$item->recv/$item->send来收发数据。或者调用$item->close()或unset($item)来关闭socket。

swoole_client_select返回0表示在规定的时间内，没有任何IO可用，select调用已超时。

    此函数可以用于Apache/PHP-fpm环境


<?php
// swoole_client用法
$clients = [];

for ($i = 0; $i < 20; $i++) {
    $client = new swoole_client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_SYNC); // 同步阻塞
    $ret = $client->connect('127.0.0.1', 9501, 0.5, 0);
    if (!$ret) {
        echo "connect server fail.errCode = " . $client->errCode;
    } else {
        $client->send("HELLO WORLD\n");
        $clients[$client->sock] = $client;
    }
}

while (!empty($clients)) {
    $write = $error = [];
    $read = array_values($clients);
    $n = swoole_client_select($read, $write, $error, 0.6);
    if ($n > 0) {
        foreach ($read as $index => $c) {
            echo "recv #{$c->sock}: " . $c->recv() . "\n";
            unset($clients[$c->sock]);
        }
    }
}


// swoole_process用法
$process = new swoole_process(function (swoole_process $worker) {
    echo "worker: start. PID = " . $worker->pid . "\n";
    sleep(2);
    $worker->write("hello master\n");
    $worker->exit(0);
}, false);

$pid = $process->start();
$r = [$process];
$write = $error = [];
$ret = swoole_select($r, $write, $error, 1.0); // swoole_select是swoole_client_select的别名
var_dump($ret);
var_dump($process->read());