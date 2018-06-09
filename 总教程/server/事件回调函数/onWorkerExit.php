onWorkerExit

仅在开启reload_async特性后有效。异步重启特性，会先创建新的Worker进程处理新请求，旧的Worker进程自行退出。原型：
function onWorkerExit(swoole_server $server, int $worker_id);


Worker进程未退出，onWorkerExit会持续触发
onWorkerExit仅在Worker进程内触发，Task进程不执行onWorkerExit

旧的Worker进程，在退出时先会执行一次onWorkerStop事件回调，然后会在事件循环的每个周期结束时调用onWorkerExit通知Worker进程退出。

在onWorkerExit中尽可能地移除/关闭异步的Socket连接，最终底层检测到Reactor中事件监听的句柄数量为0时退出进程。

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/7
 * Time: 15:09
 */