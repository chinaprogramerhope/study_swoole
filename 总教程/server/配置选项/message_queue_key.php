message_queue_key

设置消息队列的KEY，仅在task_ipc_mode = 2/3时使用。设置的Key仅作为Task任务队列的KEY，此参数的默认值为ftok($php_script_file, 1)

task队列在server结束后不会销毁，重新启动程序后，task进程仍然会接着处理队列中的任务。如果不希望程序重新启动后不执行旧的Task任务。可以手工删除此消息队列。
ipcs -q
ipcrm -Q [msgkey]

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/6
 * Time: 20:04
 */