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
    // 请求过滤
    if ($request->server['path_info'] == '/favicon.info' || $request->server['request_uri'] == '/favicon.ico') { // todo
        $response->end(); // todo return $response->end();
    }

    $task_id = isset($request->get['taskId']) ? $request->get['taskId'] : '';
    if ($task_id != '') {
        // 返回任务状态
        $status = $redis->get($key_prefix . $task_id);
        $response->end("task: $task_id; status: $status"); // todo return
    }

    $param = $request->post; // 此处处理request请求数据作为任务执行的数据, 根据需要修改
    $task_id = $http_server->task($param);

    // todo 错误和成功的返回在各个接口中返回; 并在这里得到各个接口的返回值并返回
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
    $success_ret['data']['task_id'] = $task_id;
    $response->end(json_encode($success_ret));
});

// 处理异步任务
$http_server->on('task', function ($server, $task_id, $from_id, $data) use ($redis, $key_prefix) {
    // 任务处理, 可以把处理结果和状态在redis里面实时更新, 便于获取任务状态
    for ($i = 1; $i <= 3; ++$i) {
        $redis->set($key_prefix . $task_id, $i);
//        sleep(2);
    }

    Log::info(__METHOD__ . ' : ' . __LINE__ . ' data_type = ' . gettype($data) . ', data_content = ' . json_encode($data));

    if (!isset($data['class_name']) || !isset($data['func_name'])) {
        Log::error(__METHOD__ . ' : ' . __LINE__ . ' invalid param, param = ' . json_encode($data));
        return ERROR_INVALID_PARAM;
    }

    $param = isset($data['param']) ? $data['param'] : [];
    if (!is_array($param)) {
        Log::error(__METHOD__ . ' : ' . __LINE__ . ' invalid param, param is not array, param_type = ' . gettype($param));
        return ERROR_INVALID_PARAM;
    }

    $class = new $data['class_name']();
    $func_name = $data['func_name'];
    return $class->$func_name($param); // 必须有return, 否则不会调用onFinish
});

// 任务结束之后处理任务或者回调
$http_server->on('finish', function ($server, $task_id, $data) {
    echo "$task_id task finish\n";
});

$http_server->start();
