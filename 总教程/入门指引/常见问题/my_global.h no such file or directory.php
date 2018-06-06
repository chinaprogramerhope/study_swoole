PHP缺少mysqln，请检查php编译参数。

php -i | grep configure

或者查看phpinfo页面中的configure项

编译PHP时，./configure参数中务必要加入

--enable-mysqlnd --with-mysqli

<?php
/**
 * Created by PhpStorm.
 * User: ftd20
 * Date: 2018/6/6
 * Time: 8:26
 */