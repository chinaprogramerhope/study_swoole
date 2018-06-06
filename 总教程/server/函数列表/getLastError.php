swoole_server->getLastError

获取最近一次操作错误的错误码。业务代码中可以根据错误码类型执行不同的逻辑。
function swoole_server->getLastError()

返回一个整型数字错误码

常见发送失败错误

1001 连接已经被Server端关闭了，出现这个错误一般是代码中已经执行了$serv->close()关闭了某个连接，但仍然调用$serv->send()向这个连接发送数据
1002 连接已被Client端关闭了，Socket已关闭无法发送数据到对端
1003 正在执行close，onClose回调函数中不得使用$serv->send()
1004 连接已关闭
1005 连接不存在，传入$fd 可能是错误的
1007 接收到了超时的数据，TCP关闭连接后，可能会有部分数据残留在管道缓存区内，这部分数据会被丢弃
1008 发送缓存区已满无法执行send操作，出现这个错误表示这个连接的对端无法及时收数据导致发送缓存区已塞满
1202 发送的数据超过了 server->buffer_output_size 设置




<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/6
 * Time: 15:51
 */