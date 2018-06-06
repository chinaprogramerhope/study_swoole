swoole_server->stats

得到当前Server的活动TCP连接数，启动时间，accpet/close的总次数等信息。
array swoole_server->stats();

返回的结果数组示例：

array (
'start_time' => 1409831644,
'connection_num' => 1,
'accept_count' => 1,
'close_count' => 0,
);

start_time 服务器启动的时间
connection_num 当前连接的数量
accept_count 接受了多少个连接
close_count 关闭的连接数量
tasking_num 当前正在排队的任务数

stats()方法在1.7.5+后可用

请求数量

request_count => 1000, Server收到的请求次数
worker_request_count => 当前Worker进程收到的请求次数

消息队列状态

swoole-1.8.5版本增加了Task消息队列的统计数据。

array (
'task_queue_num' => 10,
'task_queue_bytes' => 65536,
);

task_queue_num 消息队列中的Task数量
task_queue_bytes 消息队列的内存占用字节数

协程相关

array (
'coroutine_num' => 10,
);

当前协程数量coroutine_num

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/6
 * Time: 15:07
 */