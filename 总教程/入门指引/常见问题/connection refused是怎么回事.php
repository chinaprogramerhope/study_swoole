telnet 127.0.0.1 9501 时发生Connection refused，这表示服务器未监听此端口。

检查程序是否执行成功: ps aux
检查端口是否在监听: netstat -lp
查看网络通信通信过程是否正常: tcpdump traceroute

<?php
/**
 * Created by PhpStorm.
 * User: ftd20
 * Date: 2018/6/6
 * Time: 8:16
 */