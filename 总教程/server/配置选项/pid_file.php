pid_file

在Server启动时自动将master进程的PID写入到文件，在Server关闭时自动删除PID文件。
$server->set([
    'pid_file' => __DIR__ . '/server.pid',
]);


使用时需要注意如果Server非正常结束，PID文件不会删除，需要使用swoole_process::kill($pid, 0)来侦测进程是否真的存在

此选项在1.9.5或更高版本可用

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/7
 * Time: 11:30
 */