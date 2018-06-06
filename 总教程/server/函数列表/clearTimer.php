swoole_server->clearTimer

清除tick/after定时器，此函数是swoole_timer_clear的别名。



<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/6
 * Time: 12:29
 */
// 使用示例
$timer_id = $server->tick(1000, function ($id) use ($server) {
    $server->clearTimer($id);
});