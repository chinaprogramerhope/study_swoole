确认连接，与enable_delay_receive或wait_for_bind配合使用。当客户端建立连接后，并不监听可读事件。仅触发onConnect事件回调，在onConnect回调中执行confirm确认连接，这时服务器才会监听可读事件，接收来自客户端连接的数据。
function swoole_server->confirm(int $fd);


$fd 连接的唯一标识符
确认成功返回true，
$fd对应的连接不存在、已关闭或已经处于监听状态时，返回false，确认失败

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/6
 * Time: 17:54
 */