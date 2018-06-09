chroot

重定向Worker进程的文件系统根目录。此设置可以使进程对文件系统的读写与实际的操作系统文件系统隔离。提升安全性。
$serv->set([
    'chroot' => '/data/server/',
]);
此配置在swoole-1.7.9以上版本可用

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/7
 * Time: 11:29
 */