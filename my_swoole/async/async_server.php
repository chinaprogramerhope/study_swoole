<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/8
 * Time: 10:41
 */
require_once 'spl_autoload_register.php';
require_once 'config/config.php';
require_once 'config/error_code.php';

$http_server = new swoole_http_server('0.0.0.0', 9401); // todo 0.0.0.0

// redis存储任务处理结果和进度
$redis = new Redis();
$redis->connect('127.0.0.1', 6379);
$key_prefix = 'swoole_';

$http_server->set([
    'worker_num' => 4,
    'open_tcp_nodelay' => true,

    'task_worker_num' => 4,

    'daemonize' => false, // todo
    'log_file' => '/tmp/swoole_http_server.log',
]);

$http_server->on('request', function (swoole_http_request $request, swoole_http_response $response) use ($http_server, $redis, $key_prefix) {
    // 返回值默认格式
    $error_ret_server = [
        "status" => 500,
        "data" => [],
        "msg" => ""
    ];
    $error_ret_client = [
        "status" => 400,
        "data" => [],
        "msg" => ""
    ];
    $success_ret = [
        "status" => 200,
        "data" => [],
        "msg" => ""
    ];

    $task_id = isset($request->get['taskId']) ? $request->get['taskId'] : '';
    if ($task_id != '') { // 返回任务状态
        $task_status = $redis->get($key_prefix . $task_id);
        $success_ret['task_status'] = $task_status;
        $response->end(json_encode($success_ret));
    }

    $param = $request->post; // 此处处理request请求数据作为任务执行的数据, 根据需要修改

    Log::info(__METHOD__ . ', ' . __LINE__ . ', param_type = ' . gettype($param) . ', data_content = ' . json_encode($param));

    // 参数检查
    if (!isset($param['class_name']) || !isset($param['func_name'])) {
        Log::error(__METHOD__ . ' : ' . __LINE__ . ' invalid param, param = ' . json_encode($param));
        $error_ret_client['msg'] = ' invalid param';
        $response->end(json_encode($error_ret_client));
    }
    $param['func_param'] = isset($param['func_param']) ? $param['func_param'] : [];
    if (!is_array($param['func_param'])) {
        Log::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, func_param is not array, func_param_type = '
            . gettype($param['func_param']));
        $error_ret_client['msg'] = ' invalid param';
        $response->end(json_encode($error_ret_client));
    }

    $task_id = $http_server->task($param);

    if ($task_id === false) {
        Log::error(__METHOD__ . ', ' . __LINE__ . ', task fail');
        $error_ret_server['msg'] = ' task fail in request';
        $response->end(json_encode($success_ret));
    }

    $success_ret['data']['task_id'] = $task_id;
    $response->end(json_encode($success_ret));
});

// 处理异步任务
$http_server->on('task', function ($server, $task_id, $from_id, $data) use ($redis, $key_prefix) {
    $task_status = 'success'; // todo 更丰富的状态, 根据需求

    $class = new $data['class_name']();
    $func_name = $data['func_name'];
    $error_code = $class->$func_name($data['param']); // 必须有return, 否则不会调用onFinish
    if ($error_code !== ERROR_OK) {
        Log::error(__METHOD__ . ', ' . __LINE__ . ' task fail in task');

        $task_status = 'fail';
    }

    // 保存任务执行结果 (客户端根据需要来查询任务执行结果)   todo 主动通知客户端任务执行结果;
    $redis->set($key_prefix . $task_id, $task_status);

    return;
});

// 任务结束之后处理任务或者回调
$http_server->on('finish', function ($server, $task_id, $data) {
    echo "$task_id task finish\n";
});

$http_server->start();
