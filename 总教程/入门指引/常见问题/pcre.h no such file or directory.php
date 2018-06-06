编译swoole扩展出现

fatal error: pcre.h: No such file or directory

原因是缺少pcre，需要安装libpcre
ubuntu/debian：

apt-get install libpcre3 libpcre3-dev

centos/redhat：

yum install pcre-devel

其他Linux：

到PCRE官方网站下载源码包，编译安装pcre库。

<?php
/**
 * Created by PhpStorm.
 * User: ftd20
 * Date: 2018/6/6
 * Time: 8:25
 */