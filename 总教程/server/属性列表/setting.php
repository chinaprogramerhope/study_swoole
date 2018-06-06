swoole_server::$setting

swoole_server::set()函数所设置的参数会保存到swoole_server::$setting属性上。在回调函数中可以访问运行参数的值。

在swoole-1.6.11+可用

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/6
 * Time: 17:57
 */
// 示例
$serv = new swoole_server('127.0.0.1', 9501);
$serv->set([
    'worker_num' => 4
]);

echo $serv->setting['worker_num'];