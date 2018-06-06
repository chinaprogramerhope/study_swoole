swoole_server->pause

停止接收数据
function swoole_server->pause(int $fd);

$fd为连接的文件描述符
调用此函数后会将连接从EventLoop中移除，不再接收客户端数据。
此函数不影响发送队列的处理

pause方法仅可用于BASE模式


<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/6
 * Time: 14:45
 */