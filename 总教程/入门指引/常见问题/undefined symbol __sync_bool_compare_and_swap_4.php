运行swoole程序时出现此错误，说明操作系统gcc版本过低，请升级gcc至4.4以上版本。

/usr/local/php56/bin/php: symbol lookup error: /usr/local/php56/lib/php/extensions/no-debug-non-zts-20131226/swoole.so: undefined symbol: __sync_bool_compare_and_swap_4

然后重新编译安装swoole

phpize
./configure
make clean
make install

<?php
/**
 * Created by PhpStorm.
 * User: ftd20
 * Date: 2018/6/6
 * Time: 8:27
 */