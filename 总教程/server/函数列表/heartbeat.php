swoole_server->heartbeat

检测服务器所有连接，并找出已经超过约定时间的连接。如果指定if_close_connection，则自动关闭超时的连接。未指定仅返回连接的fd数组。

需要swoole-1.6.10 以上版本

函数原型：
array swoole_server::heartbeat(bool $if_close_connection = true);

$if_close_connection是否关闭超时的连接，默认为true
调用成功将返回一个连续数组，元素是已关闭的$fd。
调用失败返回false

$if_close_connection 在1.7.4+可用

示例：
$closeFdArr = $serv->heartbeat();

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/6
 * Time: 15:48
 */