
eventLoop has already been created. unable to create swoole_server

创建Server出现：

PHP Fatal error:  swoole_server::__construct(): eventLoop has already been created. unable to create swoole_server.

这表示你的程序在new swoole_server之前使用了其他异步IO的API，底层已经创建了EventLoop，无法重复创建。

这是错误的用法，如果要在Server中使用异步的Client、MySQL、Redis，请在Server的onWorkerStart回调函数或其他发生在Worker进程内的回调函数中使用。


<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/7
 * Time: 18:43
 */