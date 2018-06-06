swoole_server::$ports

监听端口数组，如果服务器监听了多个端口可以遍历swoole_server::$ports得到所有Swoole\Server\Port对象。 其中swoole_server::$ports[0]为构造方法所设置的主服务器端口。

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/6
 * Time: 18:08
 */
$ports = swoole_server::$ports;
$ports[0]->set($settings);
$ports[1]->on('Receive', function () {
    // callback
});