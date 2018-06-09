
可选参数

监听端口调用set方法只能设置一些特定的参数，无法修改全局的Server设置。

监听端口未设置任何参数，将会继承主服务器的相关配置
主服务器为Http/WebSocket服务器，如果未设置协议参数，监听的端口仍然会设置为Http或WebSocket协议，并且不会执行为端口设置的onReceive回调
主服务器为Http/WebSocket服务器，监听端口调用set设置配置参数，会清除主服务器的协议设定。监听端口将变为TCP协议。监听的端口如果希望仍然使用Http/WebSocket协议，需要在配置中增加open_http_protocol => true 和 open_websocket_protocol => true

可用的参数列表

socket参数，如backlog、TCP_KEEPALIVE、open_tcp_nodelay、tcp_defer_accept等
协议相关，如open_length_check、open_eof_check、package_length_type等
SSL证书相关，如ssl_cert_file、ssl_key_file等

不可用的参数列表

worker_num、task_worker_num、reactor_num
dispatch_mode、task_ipc_num
heartbeart_check
log_file
user/group/chroot
open_cpu_affinity
max_request/task_max_request



<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/7
 * Time: 14:06
 */