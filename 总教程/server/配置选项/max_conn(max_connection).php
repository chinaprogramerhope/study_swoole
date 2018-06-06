max_conn(max_connection)

服务器程序，最大允许的连接数，如max_connection => 10000, 此参数用来设置Server最大允许维持多少个TCP连接。超过此数量后，新进入的连接将被拒绝。

max_connection最大不得超过操作系统ulimit -n的值，否则会报一条警告信息，并重置为ulimit -n的值
max_connection默认值为ulimit -n的值

WARN    swServer_start_check: serv->max_conn is exceed the maximum value[100000].

最大上限

底层使用了SESSION_LIST来实现session_id（虚拟fd）与真实fd的对应，因此除了max_sockets限制之外，max_connection还受限于SW_SESSION_LIST_SIZE宏的设置。

目前SW_SESSION_LIST_SIZE底层的值为1M，请勿设置max_connection超过1M
内存占用

max_connection参数不要调整的过大，根据机器内存的实际情况来设置。Swoole会根据此数值一次性分配一块大内存来保存Connection信息，可使用gdb跟踪运行中的进程，打印p sizeof(swConnection) 得到准确的数值。在1.9.16版本中一个TCP连接的Connection信息，需要占用224字节。
最小设置

此选项设置过小底层会抛出错误，并设置为ulimit -n的值。

最小值为(serv->worker_num + SwooleG.task_worker_num) * 2 + 32

serv->max_connection is too small.


<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/6
 * Time: 18:28
 */