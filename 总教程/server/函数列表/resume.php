swoole_server->resume

恢复数据接收, 与pause方法成对使用
function swoole_server->resume(int $fd);

$fd为连接的文件描述符
调用此函数后会将连接重新加入到EventLoop中，继续接收客户端数据

resume方法仅可用于BASE模式

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/6
 * Time: 14:47
 */