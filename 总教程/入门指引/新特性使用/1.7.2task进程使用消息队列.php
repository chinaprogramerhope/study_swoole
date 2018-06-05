1.7.2新增特性，可将task进程单独设置为消息队列。带来的好处是：
任务排队容量增加

在维持worker进程异步的前提下，task进程可使用消息队列提升任务排队的容量，unix sock受到缓存区尺寸限制，而消息队列不受限制，可以利用到操作系统所有的内存。 如你的机器有32G内存，如果是unix sock一般缓冲区只有8M。如果你的任务很多，会堆积在socket缓存区中。当超过缓冲区时就会无法再投递新的任务。 而消息队列，只要操作系统有剩余内存，那一直可以投递新的任务到队列中。
支持外部程序投递任务

当前的swoole使用Unix Socket，只允许程序内部进行通信。采用消息队列后，拿到消息队列的key。其他程序就可以向此队列投递数据了。
实例

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/5
 * Time: 15:01
 */
class SwooleTask {
    protected $queueId;
    protected $workerId;
    protected $taskId = 1;

    const SW_TASK_TMPFILE = 1; // tmp file
    const SW_TASK_SERIALIZE = 2; // php serialize
    const SW_TASK_NONBLOCK = 4; // task

    const SW_EVENT_TASK = 7;

    /**
     * SwooleTask constructor.
     * @param $key
     * @param int $workerId
     * @throws Exception
     */
    function __construct($key, $workerId = 0) {
        $this->queueId = msg_get_queue($key);
        if ($this->queueId === false) {
            throw new \Exception("msg_get_queue() failed.");
        }
        $this->workerId = $workerId;
    }

    protected static function pack($taskId, $data) {
        $flags = self::SW_TASK_NONBLOCK;
        $type = self::SW_EVENT_TASK;
        if (!is_string($data)) {
            $data = serialize($data);
            $flags |= self::SW_TASK_SERIALIZE;
        }
        if (strlen($data) >= 8180) {
            $tmpFile = tempnam('/tmp/', 'swoole.task');
            file_put_contents($tmpFile, $data);
            $data = pack('1', strlen($data) . $tmpFile . "\0");
            $flags |= self::SW_TASK_TMPFILE;
            $len = 128 + 24;
        } else {
            $len = strlen($data);
        }

        return pack('lSsCCS', $taskId, $len, 0, $type, 0, $flags) . $data;
    }

    function dispatch($data) {
        $taskId = $this->taskId++;
        if (!msg_send($this->queueId, 2, self::pack($taskId, $data), false)) {
            return false;
        } else {
            return $taskId;
        }
    }
}

echo "Sending text to msg queue.\n";
$task = new SwooleTask(0x70001002, 1);
// 普通字符串
$task->dispatch('hello from php!');
?>

task进程是可以与swoole_server所有的客户端连接进行通信的，所以外部程序使用消息队列作为IPC，就可以与所有客户端连接进行通信。

使用方法
只需设置swoole_server::set参数即可。新增的参数如下：
task_ipc_mode => 1 | 2 | 3，默认为1就是普通的unix socket通信方式，2, 3就是使用消息队列模式。
模式2和模式3的不同之处是，模式2支持定向投递，$serv->task($data, $task_worker_id) 这里可以指定投递到哪个task进程。
模式3是完全争抢模式，task进程会争抢队列，将无法使用定向投递，即使指定了$task_worker_id，在模式3下也是无效的。
message_queue_key => 0x72000100 ，指定一个消息队列key。如果需要运行多个swoole_server的实例，务必指定。否则会发生数据错乱

