heartbeat_check_interval

启用心跳检测，此选项表示每隔多久轮循一次，单位为秒。如 heartbeat_check_interval => 60，表示每60秒，遍历所有连接，如果该连接在60秒内，没有向服务器发送任何数据，此连接将被强制关闭。

swoole_server并不会主动向客户端发送心跳包，而是被动等待客户端发送心跳。服务器端的heartbeat_check仅仅是检测连接上一次发送数据的时间，如果超过限制，将切断连接。

heartbeat_check仅支持TCP连接

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/7
 * Time: 10:42
 */