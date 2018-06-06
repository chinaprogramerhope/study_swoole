task_max_request

设置task进程的最大任务数。一个task进程在处理完超过此数值的任务后将自动退出。这个参数是为了防止PHP进程内存溢出。如果不希望进程自动退出可以设置为0。

1.7.17以下版本默认为5000，受swoole_config.h的SW_MAX_REQUEST宏控制
1.7.17以上版本默认值调整为0，不会主动退出进程


<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/6
 * Time: 18:36
 */