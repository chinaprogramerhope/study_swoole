swoole_client->sleep 

调用此方法会从事件循环中移除当前socket的可读监听，停止接收数据。
function swoole_client->sleep()

    此方法仅停止从socket中接收数据，但不会移除可写事件，所以不会影响发送队列
    sleep操作与wakeup作用相反，使用wakeup方法可以重新监听可读事件

    sleep方法在swoole-1.7.21或更高版本可用


<?php
// 使用示例
$client->on('receive', function (swoole_client $cli, $data) {
    // 睡眠模式, 不再接受新的数据
    $cli->sleep();
    swoole_timer_after(5000, function () use ($cli) {
        // 唤醒, 重新接收数据
        $cli->wakeup();
    });
});
