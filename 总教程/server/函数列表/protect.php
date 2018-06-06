swoole_server->protect

设置客户端连接为保护状态，不被心跳线程切断。
function swoole_server->protect(int $fd, bool $value = 1);

$fd 要设置保护状态的客户端连接fd
$value 设置的状态，true表示保护状态，false表示不保护


<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/6
 * Time: 17:52
 */