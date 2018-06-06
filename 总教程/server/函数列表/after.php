swoole_server->after

在指定的时间后执行函数，需要swoole-1.7.7以上版本。
swoole_server->after(int $after_time_ms, mixed $callback_function);

swoole_server::after函数是一个一次性定时器，执行完成后就会销毁。

$after_time_ms 指定时间，单位为毫秒
$callback_function 时间到期后所执行的函数，必须是可以调用的。callback函数不接受任何参数
低于1.8.0版本task进程不支持after定时器，仅支持addtimer定时器

$after_time_ms 最大不得超过 86400000
此方法是swoole_timer_after函数的别名

生命周期

定时器的生命周期是进程级的，当使用reload或kill重启关闭进程时，定时器会全部被销毁
如果有某些定时器存在关键逻辑和数据，请在onWorkerStop回调函数中实现保存

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/6
 * Time: 12:23
 */