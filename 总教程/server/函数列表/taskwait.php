swoole_server->taskwait

函数原型:
function Server->taskwait(mixed $data, float $timeout = 0.5, int $dstWorkerId = -1) : string | bool

taskwait与task方法作用相同，用于投递一个异步的任务到task进程池去执行。与task不同的是taskwait是阻塞等待的，直到任务完成或者超时返回。 $result为任务执行的结果，由$serv->finish函数发出。如果此任务超时，这里会返回false。

taskwait是阻塞接口，如果你的Server是全异步的请使用swoole_server::task和swoole_server::finish,不要使用taskwait
第3个参数可以指定要给投递给哪个task进程，传入ID即可，范围是0 - serv->task_worker_num
$dstWorkerId在1.6.11以上版本可用，可以指定目标Task进程的ID，默认为-1表示随机投递
taskwait方法不能在task进程中调用

特例

如果onTask中没有任何阻塞IO操作，底层仅有2次进程切换的开销，并不会产生IO等待，因此这种情况下 taskwait 可以视为非阻塞。实际测试onTask中仅读写PHP数组，进行10万次taskwait操作，总耗时仅为1秒，平均每次消耗为10微秒

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/6
 * Time: 15:14
 */