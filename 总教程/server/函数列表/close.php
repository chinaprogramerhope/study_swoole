swoole_server->close

关闭客户端连接，函数原型：
bool swoole_server->close(int $fd, bool $reset = false);



swoole-1.8.0或更高版本可以使用$reset方法

操作成功返回true，失败返回false.
Server主动close连接，也一样会触发onClose事件。
不要在close之后写清理逻辑。应当放置到onClose回调中处理
$reset设置为true会强制关闭连接，丢弃发送队列中的数据

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/6
 * Time: 12:30
 */