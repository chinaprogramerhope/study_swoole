编译安装完swoole后，在php-fpm/apache的phpinfo页面中有，在命令行的php -m中没有。原因可能是cli/php-fpm/apache使用不同的php.ini配置
一、确认php.ini的位置

cli命令行下

php -i|grep php.ini

php-fpm/apache，查看phpinfo页面找到php.ini的绝对路径。
二、查看对应php.ini是否有extension=swoole.so

cat /usr/local/lib/php.ini | grep swoole.so

<?php
/**
 * Created by PhpStorm.
 * User: ftd20
 * Date: 2018/6/6
 * Time: 8:15
 */