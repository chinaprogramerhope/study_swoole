swoole_process->statQueue

查看消息队列状态.
array swoole_process->statQueue();

返回一个数组, 包括2项信息
queue_num队列中的任务数量
queue_bytes队列数据的总字节数

[
    'queue_num' => 10,
    'queue_bytes' => 161,
];

需要1.8.6或更高版本