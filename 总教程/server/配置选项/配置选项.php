swoole_server::set用于设置swoole_server运行时的各项参数.
本节所有的子页面均为配置数组的元素

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/6
 * Time: 18:12
 */
// 示例
$serv->set([
    'worker_num' => 4, // worker process num
    'backlog' => 128, // listen backlog
    'max_request' => 50,
    'dispatch_mode' => 1
]);