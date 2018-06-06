CPU多核的利用

node.js没有内置对多线程/多进程的支持，用户必须使用cluster/child_process等扩展自行实现并行
swoole内置对多线程/多进程的支持，用户仅需配置参数即可

对于熟悉并行编程的程序员使用node.js cluster/child_process可以解决问题。但毕竟不是官方提供的，难免会产生BUG，需要开发者自己负责
对于不熟悉并行编程的程序员，并行会变得困难。很多技术人员采用了启动多个程序实例来解决此问题。

同步阻塞的支持

swoole同时支持同步/异步2种模式
node.js仅支持异步

为什么强调同步阻塞模式的支持。多进程同步阻塞模式是Unix世界40多年历史中最成熟的一种编程模式。配套的调试工具非常丰富完善，稳定性、成熟度、调度公平性、开发调试效率都是最佳的。多线程、异步回调、协程等模式编程虽然可以带来一定的性能提升，但复杂度过高，开发调试困难。

业务逻辑很重的程序，最佳的方式仍然是多进程同步阻塞。

协程本质上也是一种异步IO，无法利用现有的工具如strace，gdb进行调试
swoole中对于复杂业务逻辑，推荐使用同步阻塞

自动协议的支持

node.js没有内置通用协议处理的支持，需要自行实现代码
swoole内置了通用协议处理的支持，可以借助swoole提供的功能轻松实现

TCP心跳检测

swoole内置了对TCP心跳检测的支持

<?php
/**
 * Created by PhpStorm.
 * User: ftd20
 * Date: 2018/6/6
 * Time: 8:21
 */