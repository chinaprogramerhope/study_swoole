<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/4
 * Time: 11:51
 */
// 要使用task worker, 需要进行一些必要的操作

// 首先, 需要设置swoole_server的配置参数
$serv->set([
    'task_worker_num' => 2 // 设置启动2个task进程
]);

// 接着, 绑定必要的回调函数
$serv->on('Task', 'onTask');
$serv->on('Finish', 'onFinish');

//其中两个回调函数的原型如下所示:
/**
 * @param swoole_server $serv   - swoole_server对象
 * @param $task_id              - 任务id
 * @param $from_id              - 投递任务的worker_id
 * @param $data                 - 投递的数据
 */
function onTask(swoole_server $serv, $task_id, $from_id, $data);

/**
 * @param swoole_server $serv   - swoole_server对象
 * @param $task_id              - 任务id
 * @param $data                 - 任务返回的数据
 */
function onFinish(swoole_server $serv, $task_id, $data);

// 在实际逻辑中, 当需要发起一个任务请求时, 可以使用如下方法调用:
$data = 'task data';
$serv->task($data, -1); // -1代表不指定task进程

// 在1.8.6+的版本中, 可以动态指定onFinish函数
$serv->task($data, -1, function (swoole_server $serv, $task_id, $data) {
    echo "task finish callback\n";
});