log_level

设置swoole_server错误日志打印的等级，范围是0-5。低于log_level设置的日志信息不会抛出。
$serv->set([
    'log_level' => 1,
]);

级别对应

0 =>DEBUG
1 =>TRACE
2 =>INFO
3 =>NOTICE
4 =>WARNING
5 =>ERROR

*默认是0 也就是所有级别都打印

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/7
 * Time: 10:41
 */