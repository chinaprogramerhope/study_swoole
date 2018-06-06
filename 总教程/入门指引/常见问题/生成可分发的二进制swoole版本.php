swoole编译后会生成一个swoole.so动态连接库。如果服务器的Linux内核、glibc、PHP版本相同，就可以直接使用二进制版本，而不需要在当前机器上重新编译。

所以管理一个机器集群的swoole，可以在单独的一台母机上进行编译，生成swoole.so。其他的集群机器只需要分发swoole.so即可。

也可以将swoole.so制作成rpm/deb等安装包，使用操作系统的包管理工具，如 yum, rpm, apt-get, dpkg 等工具进行swoole软件的分发，安装，卸载。

<?php
/**
 * Created by PhpStorm.
 * User: ftd20
 * Date: 2018/6/6
 * Time: 8:13
 */