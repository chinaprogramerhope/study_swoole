swoole_process->setBlocking 

设置管道是否为阻塞模式, 默认Process的管道为同步阻塞.
function swoole_process->setBlocking(bool $blocking = true);

$blocking布尔型, 默认为true, 设置为false时管道为非阻塞模式
需要1.10.3/2.1.2或更高版本
====


非阻塞模式

在异步程序中使用swoole_event_add添加管道事件监听时底层会自动将管道设置为非阻塞
在异步程序中使用swoole_event_write异步写入数据时底层会自动将管道设置为非阻塞
====


<?php
// 使用实例
$serv->on('WorkerStart', function () use ($process) {
    // 设置为阻塞模式
    $process->setBlocking(true);
    while (true) {
        $process->write("hello");
        $msg = $process->read();
    }
});