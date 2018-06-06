swoole_server->taskWaitMulti

并发执行多个Task
array swoole_server->taskWaitMulti(array $tasks, double $timeout = 0.5);

$tasks 必须为数字索引数组，不支持关联索引数组，底层会遍历$tasks将任务逐个投递到Task进程
$timeout 为浮点型，单位为秒，默认为0.5
任务完成或超时，返回结果数组。结果数组中每个任务结果的顺序与$tasks对应，如：$tasks[2]对应的结果为$result[2]
某个任务执行超时不会影响其他任务，返回的结果数据中将不包含超时的任务

taskWaitMulti接口在1.8.8或更高版本可用
最大并发任务不得超过1024



<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/6
 * Time: 15:18
 */
// 使用实例
$tasks[] = mt_rand(1000, 9999); // 任务1
$tasks[] = mt_rand(1000, 9999); // 任务2
$tasks[] = mt_rand(1000, 9999); // 任务3
var_dump($tasks);

// 等待所有Task结果返回, 超时为10s
$results = $serv->taskWaitMulti($tasks, 10.0);

if (!isset($results[0])) {
    echo "任务1执行超时了\n";
}
if (isset($results[1])) {
    echo "任务2的执行结果为{$results[1]}\n";
}
if (isset($results[2])) {
    echo "任务3的执行结果为{$results[2]}\n";
}