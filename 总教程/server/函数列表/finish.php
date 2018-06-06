swoole_server->finish

此函数用于在task进程中通知worker进程，投递的任务已完成。此函数可以传递结果数据给worker进程。
$serv->finish('response');

使用swoole_server::finish函数必须为Server设置onFinish回调函数。此函数只可用于task进程的onTask回调中

finish方法可以连续多次调用，Worker进程会多次触发onFinish事件
在onTask回调函数中调用过finish方法后，return数据依然会触发onFinish事件

swoole_server::finish是可选的。如果worker进程不关心任务执行的结果，不需要调用此函数
在onTask回调函数中return字符串，等同于调用finish

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/6
 * Time: 15:44
 */