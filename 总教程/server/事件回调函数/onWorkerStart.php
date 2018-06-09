onWorkerStart


1.6.11之后Task进程中也会触发onWorkerStart事件
发生致命错误或者代码中主动调用exit时，Worker/Task进程会退出，管理进程会重新创建新的进程
onWorkerStart/onStart是并发执行的，没有先后顺序
可以通过$server->taskworker属性来判断当前是Worker进程还是Task进程

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/7
 * Time: 15:00
 */
// 下面的示例用于为Worker进程/Task进程重命名
$serv-on('WorkerStart', function ($serv, $worker_id) {
    global $argv;
    if ($worker_id >= $serv->setting['worker_num']) {
        swoole_set_process_name("php {$argv[0]} task worker");
    } else {
        swoole_set_process_name("php {$argv[0]} event worker");
    }
});
?>

如果想使用Reload机制实现代码重载入，必须在onWorkerStart中require你的业务文件，而不是在文件头部。在onWorkerStart调用之前已包含的文件，不会重新载入代码。

可以将公用的、不易变的php文件放置到onWorkerStart之前。这样虽然不能重载入代码，但所有Worker是共享的，不需要额外的内存来保存这些数据。
onWorkerStart之后的代码每个进程都需要在内存中保存一份

$worker_id是一个从0-$worker_num之间的数字，表示这个Worker进程的ID
$worker_id和进程PID没有任何关系，可使用posix_getpid函数获取PID

协程支持

2.1.0版本onWorkerStart回调函数中创建了协程，在onWorkerStart可以调用协程API
