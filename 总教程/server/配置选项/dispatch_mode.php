dispatch_mode

数据包分发策略。可以选择3种类型，默认为2

1，轮循模式，收到会轮循分配给每一个worker进程
2，固定模式，根据连接的文件描述符分配worker。这样可以保证同一个连接发来的数据只会被同一个worker处理
3，抢占模式，主进程会根据Worker的忙闲状态选择投递，只会投递给处于闲置状态的Worker
4，IP分配，根据客户端IP进行取模hash，分配给一个固定的worker进程。可以保证同一个来源IP的连接数据总会被分配到同一个worker进程。算法为 ip2long(ClientIP) % worker_num
5，UID分配，需要用户代码中调用 $serv-> bind() 将一个连接绑定1个uid。然后swoole根据UID的值分配到不同的worker进程。算法为 UID % worker_num，如果需要使用字符串作为UID，可以使用crc32(UID_STRING)

使用建议

无状态Server可以使用1或3，同步阻塞Server使用3，异步非阻塞Server使用1
有状态使用2、4、5

dispatch_mode 4,5两种模式，在1.7.8以上版本可用
dispatch_mode=1/3时，底层会屏蔽onConnect/onClose事件，原因是这2种模式下无法保证onConnect/onClose/onReceive的顺序
非请求响应式的服务器程序，请不要使用模式1或3

UDP协议

dispatch_mode=2/4/5时为固定分配，底层使用客户端IP取模散列到不同的worker进程，算法为 ip2long(ClientIP) % worker_num
dispatch_mode=1/3时随机分配到不同的worker进程

BASE模式

dispatch_mode配置在BASE模式是无效的，因为BASE不存在投递任务，当Reactor线程收到客户端发来的数据后会立即在当前线程/进程回调onReceive，不需要投递Worker进程。

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/6
 * Time: 19:38
 */