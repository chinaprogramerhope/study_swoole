request_slowlog_file

开启请求慢日志。启用后Manager进程会设置一个时钟信号，定时侦测所有Task和Worker进程，一旦进程阻塞导致请求超过规定的时间，将自动打印进程的PHP函数调用栈。

底层基于ptrace系统调用实现，某些系统可能关闭了ptrace，无法跟踪慢请求。请确认kernel.yama.ptrace_scope内核参数是否0。
[
    'request_slowlog_file' => '/tmp/trace.log',
]

与trace_event_worker和request_slowlog_timeout配置项配合使用。

注意事项
需要1.10.0或更高版本
仅在同步阻塞的程序中有效，请勿使用与协程和异步回调的服务器中
必须是具有可写权限的文件，否则创建文件失败底层会抛出致命错误
默认仅监听Task进程，通过增加trace_event_worker => true来开启对Worker进程的跟踪


超时时间
通过request_slowlog_timeout来设置请求超时时间，单位为秒。
[
    'requset_slowlog_time' => 2, // 2秒
    'request_slowlog_file' => '/tmp/trace.log',
    'trace_event_worker' => true, // 跟踪task和worker进程
]

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/7
 * Time: 11:59
 */