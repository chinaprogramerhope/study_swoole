swoole程序中禁止使用exit/die，如果PHP代码中有exit/die，当前工作的Worker进程、Task进程、User进程、以及swoole_process进程会立即退出。

建议使用try/catch的方式替换exit/die，实现中断执行跳出PHP函数调用栈。

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/5
 * Time: 14:21
 */
function swoole_exit($msg) {
    if (ENV == 'php') { // php-fpm的环境
        exit($msg);
    } else { // swoole的环境
        throw new Swoole\ExitException($msg);
    }
}
?>

以上代码并未实现ENV常量和Swoole\ExitException，请自行实现

异常处理的方式比exit/die更友好，因为异常是可控的，exit/die不可控。在最外层进行try/catch即可捕获异常，仅终止当前的任务。Worker进程可以继续处理新的请求，而exit/die会导致进程直接退出，当前进程保存的所有变量和资源都会被销毁。如果进程内还有其他任务要处理，遇到exit/die也将全部丢弃。
