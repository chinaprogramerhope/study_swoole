Length_Check 和 EOF_Check 的使用
在外网通信时，有些客户端发送数据的速度较慢，每次只能发送一小段数据。这样onReceive到的数据就不是一个完整的包。 还有些客户端是逐字节发送数据的，如果每次回调onReceive会拖慢整个系统。
Swoole提供了length_check和eof_check的功能，在扩展底层检测到如果不是完整的请求，会等待新的数据到达，组成完整的请求后再回调onReceive。


EOF检测
在swoole_server::set中增加open_eof_check和package_eof来开启此功能。open_eof_check => true表示启用结束符检查，package_eof设置数据包结束符。查看详细说明


Length检测
在swoole_server::set中增加open_length_check来开启此功能。查看详细说明
buffer功能会将所有收到的数据放到内存中，会占用较多内存
通过设置 package_max_length 来设定每个连接最大缓存多少数据，超过此大小的连接将会被关闭

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/7
 * Time: 16:10
 */
// 示例
$server->set([
    'worker_num' => 4, // worker process num
    'backlog' => 128, // listen backlog
    'max_request' => 50,
    'dispatch_mode' => 1,
    'package_eof' => "\r\n\r\n", // http协议就是以\r\n\r\n作为结束符的，这里也可以使用二进制内容
    'open_eof_check' => 1,
]);