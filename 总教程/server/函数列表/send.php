向客户端发送数据, 函数原型:
bool swoole_server->send(int $fd, string $data, int $extraData = 0);

$data，发送的数据，TCP协议最大不得超过2M，可修改 buffer_output_size 改变允许发送的最大包长度
UDP协议不得超过65507，UDP包头占8字节, IP包头占20字节，65535-28 = 65507
UDP服务器使用$fd保存客户端IP，$extraData保存server_fd和port
发送成功会返回true
发送失败会返回false，调用$server->getLastError()方法可以得到失败的错误码

TCP服务器

send操作具有原子性，多个进程同时调用send向同一个TCP连接发送数据，不会发生数据混杂
如果要发送超过2M的数据，可以将数据写入临时文件，然后通过sendfile接口进行发送
通过设置 buffer_output_size 参数可以修改发送长度的限制
在发送超过8K的数据时，底层会启用Worker进程的共享内存，需要进行一次Mutex->lock操作
当Worker进程的管道缓存区已满时，发送8K数据将启用临时文件存储
不需要关心客户端的带宽，底层会自动监听可写，将数据逐步发送给客户端
如果连续向同一个客户端发送大量数据，可能会导致Socket内存缓存区塞满，底层会立即返回false，应用程序可以调整socket_buffer_size设置，或 将数据保存到磁盘，等待客户端收完已发送的数据后再进行发送

TCP客户端发送数据，不需要$extraData参数

UDP服务器

send操作会直接在Worker进程内发送数据包，不会再经过主进程转发
如果在onReceive后立即向客户端发送数据，可以不传$extraData
如果向其他UDP客户端发送数据，必须要传入$extraData
在外网服务中发送超过64K的数据会分成多个传输单元进行发送，如果其中一个单元丢包，会导致整个包被丢弃。所以外网服务，建议发送1.5K以下的数据包


<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/6
 * Time: 12:31
 */