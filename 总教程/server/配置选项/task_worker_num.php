task_worker_num

配置Task进程的数量，配置此参数后将会启用task功能。所以Server务必要注册onTask、onFinish2个事件回调函数。如果没有注册，服务器程序将无法启动。

Task进程是同步阻塞的，配置方式与Worker同步模式一致
最大值不得超过SWOOLE_CPU_NUM * 1000

计算方法

单个task的处理耗时，如100ms，那一个进程1秒就可以处理1/0.1=10个task
task投递的速度，如每秒产生2000个task
2000/10=200，需要设置task_worker_num => 200，启用200个task进程

Task进程内不能使用swoole_server->task方法
Task进程内不能使用swoole_mysql、swoole_redis、swoole_event等异步IO函数

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/6
 * Time: 18:31
 */