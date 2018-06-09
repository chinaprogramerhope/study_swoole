pipe_buffer_size

调整管道通信的内存缓存区长度。Swoole使用Unix Socket实现进程间通信。
$server->set([
    'pipe_buffer_size' => 32 * 1024 * 1024, // 必须为数字
]);


swoole的reactor线程与worker进程之间
worker进程与task进程之间
1.9.16或更高版本已移除此配置项，底层不再限制管道缓存区的长度

都是使用unix socket进行通信的，在收发大量数据的场景下，需要启用内存缓存队列。此函数可以修改内存缓存的长度。

task_ipc_mode=2/3时会使用消息队列通信不受此参数控制
管道缓存队列已满会导致reactor线程、worker进程发生阻塞
此参数在1.7.17以上版本默认为32M，1.7.17以下版本默认为8M


<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/7
 * Time: 11:31
 */