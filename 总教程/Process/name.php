swoole_process->name

修改进程名称. 此函数是swoole_set_process_name的别名.
$process->name("php server.php: worker");

在执行exec后, 进程名称会被新的程序重新设置.

此方法在swoole-1.7.9以上版本可用
name方法应当在start之后的子进程回调函数中使用