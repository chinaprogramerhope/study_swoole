
错误信息：ERROR (9006)

错误信息：Worker#1 pipe buffer is full, the reactor will block.

出现此信息表示Worker进程和Reactor线程间通信的管道缓存区已满，这时Reactor线程将阻塞1秒钟等待Worker进程读取管道中的数据。

如果持续报出此错误，说明服务器当前并发请求数量已经超过Worker进程处理能力。需要调大Worker进程数，或者 尽快扩容机器进行解决。

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/7
 * Time: 18:41
 */