swoole_server->exist

检测fd对应的连接是否存在
bool function swoole_server->exist(int $fd);


$fd对应的TCP连接存在返回true，不存在返回false

此接口是基于共享内存计算，没有任何IO操作
swoole_server->exist在1.7.18以上版本可用

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/6
 * Time: 14:44
 */