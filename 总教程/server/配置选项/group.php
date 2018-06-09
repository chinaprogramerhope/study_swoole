group

设置worker/task子进程的进程用户组。与user配置相同，此配置是修改进程所属用户组，提升服务器程序的安全性。
$serv->set([
    'group' => 'www-data'
]);
此配置在swoole-1.7.9以上版本可用
仅在使用root用户启动时有效

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/7
 * Time: 11:27
 */