discard_timeout_request

swoole在配置dispatch_mode=1或3后，系统无法保证onConnect/onReceive/onClose的顺序，因此可能会有一些请求数据在连接关闭后，才能到达Worker进程。

discard_timeout_request配置默认为true，表示如果worker进程收到了已关闭连接的数据请求，将自动丢弃。discard_timeout_request如果设置为false，表示无论连接是否关闭Worker进程都会处理数据请求。

discard_timeout_request 在1.7.16以上可用


<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/7
 * Time: 11:44
 */