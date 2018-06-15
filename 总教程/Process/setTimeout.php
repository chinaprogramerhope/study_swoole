swoole_process->setTimeout 

设置管道读写操作的超时时间
function swoole_process->setTimeout(double $timeout);

$timeout单位为妙, 支持浮点数, 如1/5表示1s + 500ms
设置成功返回true
设置失败返回false, 可使用swoole_errno获取错误码

设置成功后, 调用recv和write在规定时间内未读取或写入成功, 将返回false,
可使用swoole_errno获取错误码.
在1.9.21或跟高版本可用

<?php
// 使用实例
$process = new \swoole_process(function (\swoole_process $process) {
    sleep(5);
});
$process->start();

$process->setTimtout(0.5);
$ret = $process->read();