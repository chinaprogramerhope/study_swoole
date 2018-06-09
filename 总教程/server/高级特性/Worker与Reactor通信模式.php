Worker与Reactor通信模式

Worker进程如何与Reactor线程通信，Swoole提供了5种方式。通过swoole_server::set方法设置dispatch_mode来配置。


轮询模式
dispatch_mode = 1 收到的请求数据包会轮询发到每个Worker进程。


FD取模
dispatch_mode = 2
数据包根据fd的值%worker_num来分配，这个模式可以保证一个TCP客户端连接发送的数据总是会被分配给同一个worker进程。 这种模式可能会存在性能问题，作为SOA服务器时，不应当使用此模式。因为客户端很可能用了连接池，客户端100个进程复用10个连接，也就是同时只有10个swoole worker进程在处理请求。这种模式的业务系统可以使用dispatch_mode = 3，抢占式分配。


忙闲分配
dispatch_mode = 3 此模式下，Reactor只会给空闲的Worker进程投递数据。 这个模式的缺点是，客户端连接对应的Worker是随机的。不确定哪个Worker会处理请求。无法保存连接状态。 当然也可以借助第三方库来实现保存连接状态和会话内容，比如apc/redis/memcache。


IP取模
dispatch_mode = 4
如果客户端的连接不稳定，经常发生断线重连，fd的值不是固定的，使用IP进行取模分配可以解决此问题。同一个IP地址会被分配到同一个Worker进程。


UID取模
dispatch_mode = 5
与fd或IP取模分配一致，dispatch_mode = 5 需要应用层调用bind方法设置一个UID


<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/7
 * Time: 16:12
 */