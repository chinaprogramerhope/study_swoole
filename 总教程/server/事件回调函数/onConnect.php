onConnect

有新的连接进入时，在worker进程中回调。函数原型：
function onConnect(swoole_server $server, int $fd, int $reactorId);


$server是Swoole\Server对象
$fd是连接的文件描述符，发送数据/关闭连接时需要此参数
$reactorId来自哪个Reactor线程

关于$fd和$reactorId 详细的解释
onConnect/onClose这2个回调发生在worker进程内，而不是主进程。
UDP协议下只有onReceive事件，没有onConnect/onClose事件

dispatch_mode = 1/3

在1.7.15以上版本中，当设置dispatch_mode = 1/3时会自动去掉onConnect/onClose事件回调。原因是：

在此模式下onConnect/onReceive/onClose可能会被投递到不同的进程。连接相关的PHP对象数据，无法实现在onConnect回调初始化数据，onClose清理数据
onConnect/onReceive/onClose 3种事件可能会并发执行，可能会带来异常


<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/7
 * Time: 15:11
 */