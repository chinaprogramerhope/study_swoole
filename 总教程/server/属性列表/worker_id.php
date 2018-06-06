swoole_server::$worker_id

得到当前worker进程的编号, 包括task进程
int $server->worker_id;

这个属性与onWorkerStart时的$worker_id是相同的

Worker进程编号范围是[0, $serv->setting['worker_num'])
Task进程编号范围是[$serv->setting['worker_num'], $serv->setting['worker_num'] + $serv->setting['task_worker_num'])

工作进程重启后worker_id的值是不变的

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/6
 * Time: 18:00
 */