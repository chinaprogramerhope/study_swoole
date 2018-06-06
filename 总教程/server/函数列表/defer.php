swoole_server->defer

延后执行一个PHP函数。Swoole底层会在EventLoop循环完成后执行此函数。此函数的目的是为了让一些PHP代码延后执行，程序优先处理IO事件。底层不保证defer的函数会立即执行，如果是系统关键逻辑，需要尽快执行，请使用after定时器实现。
function swoole_server->defer(callable $callback);

defer函数的别名是swoole_event_defer
$callback为可执行的函数变量，可以是字符串、数组、匿名函数
在onWorkerStart回调中执行defer时，必须要等到有事件发生才会回调

defer函数在swoole-1.8.0或更高版本可用




<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/6
 * Time: 12:26
 */
// 使用实例
function query($server, $db) {
    $server->defer(function () use ($db) {
        $db->close();
    });
}
