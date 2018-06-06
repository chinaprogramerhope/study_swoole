swoole_server->sendwait

阻塞地向客户端发送数据。

有一些特殊的场景，Server需要连续向客户端发送数据，而swoole_server->send数据发送接口是纯异步的，大量数据发送会导致内存发送队列塞满。

使用swoole_server->sendwait就可以解决此问题，swoole_server->sendwait会阻塞等待连接可写。直到数据发送完毕才会返回。
bool swoole_server->sendwait(int $fd, string $send_data);

sendwait目前仅可用于SWOOLE_BASE模式
sendwait建议只用于本机或内网通信，外网连接请勿使用sendwait

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/6
 * Time: 14:32
 */