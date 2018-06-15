swoole_process->read 

从管道中读取数据.
function swoole_process->read(int $buffer_size = 8192) : string | bool;

$buffer_size是缓冲区的大小, 默认为8192, 最大不超过64k
管道类型为dgram数据包时, read可以读取完整的一个数据包
管道类型为stream时, read时流式的, 需要自行处理包完整性问题
读取成功返回二进制数据字符串, 读取失败返回false

这里是同步阻塞读取的, 可以使用swoole_event_add将管道加入到事件循环中, 变为异步模式

<?php
// 示例
function callback_function_async(swoole_process $worker) {
    $GLOBALS['worker'] = $worker;
    swoole_event_add($worker->pipe, function ($pipe) {
        $worker = $GLOBALS['worker'];
        $recv = $worker->read();

        echo "from master: $recv\n";

        // send data to master
        $worker->write("hello master\n");

        sleep(2);

        $worker->exit(0);
    });
}
?>
====


注意事项
由于swoole底层使用了epoll的lt模式, 因此swoole_event_add添加的事件监听, 
在事件发生后回调函数中必须调用read方法读取socket中的数据, 否则底层会持续触发事件回调