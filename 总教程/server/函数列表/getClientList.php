swoole_server->getClientList

用来遍历当前Server所有的客户端连接，Server::getClientList方法是基于共享内存的，不存在IOWait，遍历的速度很快。另外getClientList会返回所有TCP连接，而不仅仅是当前Worker进程的TCP连接。

推荐使用 swoole_server::$connections 迭代器来遍历连接 getClientList的别名是connection_list
getClientList仅可用于TCP客户端，UDP服务器需要自行保存客户端信息
SWOOLE_BASE模式下只能获取当前进程的连接

函数原型：
swoole_server::getClientList(int $start_fd, int $pagesize = 10);

此函数接受2个参数，第1个参数是起始fd，第2个参数是每页取多少条，最大不得超过100。

调用成功将返回一个数字索引数组，元素是取到的$fd。数组会按从小到大排序。最后一个$fd作为新的start_fd再次尝试获取
调用失败返回false



<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/6
 * Time: 14:52
 */
// 示例
$start_fd = 0;
while (true) {
    $conn_list = $serv->getClientList($start_fd, 10);
    if ($conn_list === false or count($conn_list) === 0) {
        echo "finish\n";
        break;
    }
    $start_fd = end($conn_list);
    var_dump($conn_list);
    foreach ($conn_list as $fd) {
        $serv->send($fd, 'broadcast');
    }
}