task_ipc_mode

设置task进程与worker进程之间通信的方式。

1, 使用unix socket通信，默认模式
2, 使用消息队列通信
3, 使用消息队列通信，并设置为争抢模式

模式2和模式3的不同之处是，模式2支持定向投递，$serv->task($data, $task_worker_id) 可以指定投递到哪个task进程。模式3是完全争抢模式，task进程会争抢队列，将无法使用定向投递，task/taskwait将无法指定目标进程ID，即使指定了$task_worker_id，在模式3下也是无效的。

模式3会影响sendMessage方法，使sendMessage发送的消息会随机被某一个task进程获取

消息队列模式

消息队列模式使用操作系统提供的内存队列存储数据，未指定 mssage_queue_key 消息队列Key，将使用私有队列，在Server程序终止后会删除消息队列。
指定消息队列Key后Server程序终止后，消息队列中的数据不会删除，因此进程重启后仍然能取到数据
可使用ipcrm -q 消息队列ID手工删除消息队列数据


<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/6
 * Time: 18:34
 */