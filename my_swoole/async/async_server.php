<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/8
 * Time: 10:41
 */
require_once 'Mail.php';

$http_server = new swoole_http_server('0.0.0.0', 9401); // todo 0.0.0.0

// redis存储任务处理结果和进度
$redis = new Redis();
$redis->connect('127.0.0.1', 6379);
$key_prefix = 'swoole_';

$http_server->set([ // todo
    'worker_num' => 4,
    'open_tcp_nodelay' => true,
    'task_worker_num' => 4,

    'daemonize' => false,
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

    $param = $request->get; // 此处处理request请求数据作为任务执行的数据, 根据需要修改
    $task_id = $http_server->task($param);
    $response->end("
    <h1>do task:$task_id.</h1>
    ");
});

// 处理异步任务
$http_server->on('task', function ($server, $task_id, $from_id, $data) use ($redis, $key_prefix) {
    // 任务处理, 可以把处理结果和状态在redis里面实时更新, 便于获取任务状态
    for ($i = 1; $i <= 3; ++$i) {
        $redis->set($key_prefix . $task_id, $i);
        sleep(1);
    }

    $port = 25; // SMTP服务器端口
    $user = 'phphack@163.com'; // 发件人邮箱
    $pass = 'han888'; // 发件人邮箱密码
    $host = 'smtp.163.com'; // SMTP服务器
    $from = 'phphack@163.com';
    $to = '18301805881@163.com';
    $body = 'hello world';
    $subject = '我是标题';

    echo 'type = ' . gettype($data) . ', content = ' . json_encode($data);

    $class = new $data['class_name']($host, $port, $user, $pass, true);
    $func_name = $data['func_name'];
    $class->$func_name($from, $to, $subject, $body);

    return $i; // 必须有return, 否则不会调用onFinish
});

// 任务结束之后处理任务或者回调
$http_server->on('finish', function ($server, $task_id, $data) {
    echo "$task_id task finish\n";
});

$http_server->start();
