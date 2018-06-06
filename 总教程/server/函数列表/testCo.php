swoole_server->taskCo

并发执行Task并进行协程调度。仅用于2.0版本。
function swoole_server->taskCo(array $tasks, float $timeout = 0.5) : array;

$tasks任务列表，必须为数组。底层会遍历数组，将每个元素作为task投递到Task进程池
$timeout超时时间，默认为0.5秒，当规定的时间内任务没有全部完成，立即中止并返回结果
任务完成或超时，返回结果数组。结果数组中每个任务结果的顺序与$tasks对应，如：$tasks[2]对应的结果为$result[2]
某个任务执行失败或超时，对应的结果数组项为false，如：$tasks[2]失败了，那么$result[2]的值为false

最大并发任务不得超过1024
taskCo在2.0.9或更高版本可用

调度过程

$tasks列表中的每个任务会随机投递到一个Task工作进程，投递完毕后，yield让出当前协程，并设置一个$timeout秒的定时器
在onFinish中收集对应的任务结果，保存到结果数组中。判断是否所有任务都返回了结果，如果为否，继续等待。如果为是，进行resume恢复对应协程的运行，并清除超时定时器
在规定的时间内任务没有全部完成，定时器先触发，底层清除等待状态。将未完成的任务结果标记为false，立即resume对应协程



<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/6
 * Time: 15:26
 */
// 使用示例
$server = new Swoole\Http\Server('127.0.0.1', 9502, SWOOLE_BASE);

$server->set([
    'worker_num' => 1,
    'task_worker_num' => 2
]);

$server->on('Task', function (swoole_server $serv, $task_id, $worker_id, $data) {
    echo "#{$serv->worker_id}\tonTask: worker_id={$worker_id}, task_id=$task_id\n";
    if ($serv->worker_id == 1) {
        sleep(1);
    }
    return $data;
});

$server->on('Request', function ($request, $response) use ($server) {
    $tasks[0] = 'hello world';
    $tasks[1] = ['data' => 1234, 'code' => 200];
    $result = $server->taskCo($tasks, 0.5);
    $response->end('Test End, Result: ' . var_export($response, true));
});

$server->start();