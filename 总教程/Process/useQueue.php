swoole_process->useQueue

启用消息队列作为进程间通信.
bool swoole_process->useQueue(int $msgkey = 0, int $mode = 2);

useQueue方法接收2个可选参数

$msgkey是消息队列的key, 默认会使用ftok(__FILE__, 1)作为key
$mode通信模式, 默认为2, 表示争抢模式, 所有创建的子进程都会从队列中取数据
如果创建消息队列失败, 会返回false, 可使用swoole_strerror(swoole_errno())得到错误码和错误信息

使用模式2后, 创建的子进程无法进行单独通信, 比如发给特定子进程.
$process对象并未执行start, 也可以执行push/pop向队列推送/提取数据
消息队列通信方式与管道不可共用. 消息队列不支持EventLoop, 使用消息队列后只能使用同步阻塞模式

CygWin环境不支持消息队列, 请勿在此环境下使用.
====


非阻塞

在1.9.2或更高版本中增加了swoole_process::IPC_NOWAIT的支持, 可将队列设置为非阻塞.
在非阻塞模式下, 队列已满调用push方法, 队列已空调用pop方法时将不再阻塞立即返回.
// 设置为非阻塞模式
$process->useQueue($key, $mode | swoole_process::IPC_NOWAIT);

<?php
// 示例
$worker_num = 2;
$process_bool = [];

$process = null;
$pid = posix_getpid();

function sub_process(swoole_process $worker) {
    sleep(1); // 防止父进程还未往消息队列中加入内容直接退出
    echo "worker " . $worker->pid . " started" . PHP_EOL;
    while ($msg = $worker->pop()) {
        if ($msg === false) {
            break;
        }
        $sub_pid = $worker->pid;
        echo "[$sub_pid] msg : $msg" . PHP_EOL;
        sleep(1); // 这里的sleep模拟任务耗时, 否则可能1个worker就把所有信息全接收了
    }
    echo "worker " . $worker->pid . " exit" . PHP_EOL;
    $worker->exit(0);
}

$customMsgKey = 1;
$mod = 2 | swoole_process::IPC_NOWAIT; // 这里设置消息队列为非阻塞模式

// 创建worker进程
for ($i = 0; $i < $worker_num; $i++) {
    $process = new swoole_process('sub_process');
    $process->useQueue($customMsgKey, $mod);
    $process->start();
    $pid = $process->pid;
    $process_pool[$pid] = $process;
}

$message = [
    'ok1',
    'ok2',
    'ok3',
    'ok4',
    'ok5',
];
// 由于所有进程是共享使用一个消息队列, 所以只需向一个子进程发送消息即可
$process = current($process_pool);
foreach ($messages as $msg) {
    $process->push($msg);
}

swoole_process::wait();
swoole_process::wait();

echo "master exit" . PHP_EOL;