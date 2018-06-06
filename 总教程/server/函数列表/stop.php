swoole_server->stop

使当前worker进程停止运行，并立即触发onWorkerStop回调函数。
function swoole_server->stop(int $worker_id = -1, bool $waitEvent = false);

使用此函数代替exit/die结束Worker进程的生命周期
$waitEvent可以控制退出策略，默认为false表示立即退出，设置为true表示等待事件循环为空时再退出
如果要结束其他Worker进程，可以在stop里面加上worker_id作为参数或者使用swoole_process::kill($worker_pid)

此方法在1.8.2或更高版本可用
$waitEvent在1.9.19或更高版本可用

异步退出

异步服务器在调用stop退出进程时，可能仍然有事件在等待。比如使用了Swoole\MySQL->query，发送了SQL语句，但还在等待MySQL服务器返回结果。这时如果进程强制退出，SQL的执行结果就会丢失了。

设置$waitEvent = true后，底层会使用异步安全重启策略。先通知Manager进程，重新启动一个新的Worker来处理新的请求。当前旧的Worker会等待事件，直到事件循环为空或者超过max_wait_time后，退出进程，最大限度的保证异步事件的安全性。
<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/6
 * Time: 12:14
 */