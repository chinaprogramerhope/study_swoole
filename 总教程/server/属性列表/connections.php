swoole_server::$connections

TCP连接迭代器，可以使用foreach遍历服务器当前所有的连接，此属性的功能与swoole_server->connnection_list是一致的，但是更加友好。遍历的元素为单个连接的fd。

注意$connections属性是一个迭代器对象，不是PHP数组，所以不能用var_dump或者数组下标来访问，只能通过foreach进行遍历操作。

foreach ($server->connections as $fd) {
    $server->send($fd, 'hello');
}

echo '当前服务器共有' . count($server->connections) . " 个连接\n";

此属性在1.7.16以上版本可用
连接迭代器依赖pcre库（不是PHP的pcre扩展），未安装pcre库无法使用此功能
pcre库的安装方法， http://wiki.swoole.com/wiki/page/312.html

Base 模式

SWOOLE_BASE模式下不支持跨进程操作TCP连接，因此在BASE模式中，只能在当前进程内使用$connections迭代器。
<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/6
 * Time: 18:05
 */