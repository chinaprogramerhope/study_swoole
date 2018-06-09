heartbeat_idle_time

与heartbeat_check_interval配合使用。表示连接最大允许空闲的时间。如

[
    'heartbeat_idle_time' => 600,
    'heartbeat_check_interval' => 60
]


表示每60秒遍历一次，一个连接如果600秒内未向服务器发送任何数据，此连接将被强制关闭
启用heartbeat_idle_time后，服务器并不会主动向客户端发送数据包
如果只设置了heartbeat_idle_time未设置heartbeat_check_interval底层将不会创建心跳检测线程，PHP代码中可以调用heartbeat方法手工处理超时的连接


<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/7
 * Time: 10:43
 */