swoole与phpdaemon/react有何不同

swoole是完全使用C语言编写，多线程epoll，作为PHP扩展运行的。 phpdaemon/react都是基于libevent扩展使用php开发，以脚本方式执行。 swoole中提供的多线程Reactor，异步MySQL，毫秒定时器，异步文件读写、异步DNS查询，在PHP生态圈中是独一无二的。
Linux内核问题

swoole建议使用Linux2.6.32+，低于此版本的系统有很多特性会不支持。swoole会启用兼容的代码来实现特性，性能较差，而且缺少维护。可能会产生问题，仅供开发使用。
Swoole的性能如何

swoole使用C语言开发，性能接近nginx。这里有一个echo server的测试。可以作为参考：http://www.swoole.com/wiki/main/63

<?php
/**
 * Created by PhpStorm.
 * User: ftd20
 * Date: 2018/6/6
 * Time: 8:11
 */