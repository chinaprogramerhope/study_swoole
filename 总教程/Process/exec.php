swoole_process->exec 

执行一个外部程序, 此函数是exec系统调用的封装.
bool swoole_process->exec(string $execfile, array $args);

$execfile指向可执行文件的绝对路径, 如"/usr/bin/python"
$args是一个数组, 是exec的参数列表, 如array('test.py', 123), 相当于python test.py 123

执行成功后, 当前进程的代码段将会被新程序替换.
子进程蜕变成另外一套程序. 父进程与当前进程仍然是父子进程关系.

父进程与新进程之间可以通过标准输入输出进行通信, 必须启用标准输入输出重定向.

$execfile必须使用绝对路径, 否则会报文件不存在错误.
由于exec系统调用会使用指定的程序覆盖当前程序, 子进程需要读写标准输出与父进程进行通信
如果未指定redirect_stdin_stdout = true, 执行exec后子进程与父进程无法通信

<?php
// 调用示例
$process = new \Swoole\Process(function (\Swoole\Process $childProcess) {
    // 不支持这种写法
    // $childProcess->exec('/usr/local/bin/php /var/www/project/yii-best-practice/cli/yii/index -m=123 abc xyz');

    // 封装exec系统调用
    // 绝对路径
    // 参数必须分开放到数组中
    $childProcess->exec('/usr/local/bin/php', ['/var/www/project/yii-best-practice/cli/yii',
    't/index', '-m=123', 'abc', 'xyz']); // exec系统调用
});

$process->start(); // 启动子进程
?>

父进程与exec进程使用管道进行通信:
<?php
// exec - 与exec进程进行管道通信
use Swoole\Process;
$process = new Process(function (Process $worker) {
    $worker->exec('/bin/echo', ['hello']);
    $worker->write('hello');
}, true); // 需要启用标准输入输出重定向
$process->start();
echo "from exec: " . $process->read() . "\n";
?>
====


执行shell命令

exec方法与php提供的shell_exec不同, 他是更底层的系统调用封装.
如果需要执行一条shell命令, 请使用以下方法:
$worker->exec('/bin/sh', ['-c', "cp -rf /data/test/* /tmp/test/"]);