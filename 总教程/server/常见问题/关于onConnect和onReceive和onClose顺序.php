
关于onConnect/onReceive/onClose顺序

在swoole服务器程序中，如果不修改dispatch_mode选项。底层是可以保证同一个socket连接的onConnect/onReceive/onClose绝对有序。
onConnect

连接进入后首先从主进程Accept，然后通知到Worker进程。之后才会将socket加入事件循环，监听可写。所以当收到的数据到达之前，Worker进程一定会先收到onConnect指令。

onConnect/onClose/onReceive 事件都是由reactor线程发出的

onClose

连接的关闭过程比较复杂。在swoole中close操作是在onClose事件回调函数执行完，并通知到reactor线程后。才会真正执行。
客户端主动关闭

这时reactor线程最先得到关闭的事件，之后会将此socket从事件循环中移除，并标记连接为removed，然后向Worker进程发送通知。当Worker进程得到通知后会回调onClose（如果有设置），然后再向reactor发送关闭确认。Reactor线程收到Worker进程的关闭确认后才会执行socket的清理工作，并close，将fd释放给操作系统。

客户端主动关闭连接后，TCP通道已不可用，所以收到Worker的发送指令，会将此数据丢弃。

服务器主动关闭

首先执行onClose事件回调，然后将连接标记为closed，并向reactor线程发送关闭确认。reactor线程收到此消息后会真正执行close。

reactor会先收到发送数据的指令，再收到关闭确认指令。等待所有数据发送到客户端后，才会执行close操作。

服务器主动关闭连接后，即使客户端仍然向Server发送数据，达到服务器时也会被丢弃。

管道塞满并启用缓存时

reactor和worker之间的管道如果发生塞满，这时会启用内存缓存队列。数据发送操作可能仍然在缓存队列中，并未发送到reactor线程。这是再发起close，那么关闭确认的消息也会加入缓存队列等待发送。所有指令都是有序的。

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/7
 * Time: 18:22
 */