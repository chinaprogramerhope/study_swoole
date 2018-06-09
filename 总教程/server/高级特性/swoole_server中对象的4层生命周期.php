swoole_server中对象的4层生命周期

开发swoole程序与普通LAMP下编程有本质区别。在传统的Web编程中，PHP程序员只需要关注request到达，request结束即可。而在swoole程序中程序员可以操控更大范围，变量/对象可以有四种生存周期。

变量、对象、资源、require/include的文件等下面统称为对象

程序全局期

在swoole_server->start之前就创建好的对象，我们称之为程序全局生命周期。这些变量在程序启动后就会一直存在，直到整个程序结束运行才会销毁。

有一些服务器程序可能会连续运行数月甚至数年才会关闭/重启，那么程序全局期的对象在这段时间持续驻留在内存中的。程序全局对象所占用的内存是Worker进程间共享的，不会额外占用内存。

这部分内存会在写时分离（COW），在Worker进程内对这些对象进行写操作时，会自动从共享内存中分离，变为进程全局对象。

程序全局期include/require的代码，必须在整个程序shutdown时才会释放，reload无效

进程全局期

swoole拥有进程生命周期控制的机制，一个Worker子进程处理的请求数超过max_request配置后，就会自动销毁。Worker进程启动后创建的对象（onWorkerStart中创建的对象），在这个子进程存活周期之内，是常驻内存的。onConnect/onReceive/onClose 中都可以去访问它。

进程全局对象所占用的内存是在当前子进程内存堆的，并非共享内存。对此对象的修改仅在当前Worker进程中有效
进程期include/require的文件，在reload后就会重新加载

会话期

会话期是在onConnect后创建，或者在第一次onReceive时创建，onClose时销毁。一个客户端连接进入后，创建的对象会常驻内存，直到此客户端离开才会销毁。

在LAMP中，一个客户端浏览器访问多次网站，就可以理解为会话期。但传统PHP程序，并不能感知到。只有单次访问时使用session_start，访问$_SESSION全局变量才能得到会话期的一些信息。

swoole中会话期的对象直接是常驻内存，不需要session_start之类操作。可以直接访问对象，并执行对象的方法。
请求期

请求期就是指一个完整的请求发来，也就是onReceive收到请求开始处理，直到返回结果发送response。这个周期所创建的对象，会在请求完成后销毁。

swoole中请求期对象与普通PHP程序中的对象就是一样的。请求到来时创建，请求结束后销毁。

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/7
 * Time: 16:48
 */