swoole_process->freeQueue 

删除队列. 此方法与useQueue成对使用, useQueue创建队列, 使用freeQueue销毁队列.
销毁队列后队列中的数据会被清空.

如果车供需只调用了useQueue方法, 未调用freeQueue在程序结束时并不会清除数据.
重新运行程序时可以继续读取上次运行留下的数据.

系统重启时消息队列中的数据会被丢弃.
function swoole_process->freeQueue();