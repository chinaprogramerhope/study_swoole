onShutdown

此事件在Server正常结束时发生，，函数原型
function onShutdown(swoole_server $server);

在此之前Swoole\Server已进行了如下操作

已关闭所有Reactor线程、HeartbeatCheck线程、UdpRecv线程
已关闭所有Worker进程、Task进程、User进程
已close所有TCP/UDP/UnixSocket监听端口
已关闭主Reactor

强制kill进程不会回调onShutdown，如kill -9
需要使用kill -15来发送SIGTREM信号到主进程才能按照正常的流程终止
在命令行中使用Ctrl+C中断程序会立即停止，底层不会回调onShutdown

注意事项

请勿在onShutdown中调用任何异步或协程相关API。触发onShutdown时底层已销毁了所有事件循环设施。

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/7
 * Time: 14:56
 */