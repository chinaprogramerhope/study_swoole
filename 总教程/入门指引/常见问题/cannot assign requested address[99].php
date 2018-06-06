客户端连接时出现

Error: Cannot assign requested address [99]

此错误是指无法分配本地端口。每一个socket客户端，系统都要分配一个本地端口。当一台机器存在大量客户端socket时，本地端口可能会不够用，这时再发起网络请求就会报 #99 错误。

相关内核参数是：

net.ipv4.ip_local_port_range = 20000 65000

启用快速回收

快速回收可以加速local port的回收，在短连接的服务中需要开启此参数

net.ipv4.tcp_tw_recycle = 1

<?php
/**
 * Created by PhpStorm.
 * User: ftd20
 * Date: 2018/6/6
 * Time: 8:20
 */