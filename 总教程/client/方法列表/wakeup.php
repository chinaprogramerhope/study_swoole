swoole_client->wakeup 

调用此方法会重新监听可读事件, 将socket连接从睡眠中唤醒.
function swoole_client->wakeup();

    如果socket并未进入sleep模式，wakeup操作没有任何作用

sleep方法在swoole-1.7.21或更高版本可用

