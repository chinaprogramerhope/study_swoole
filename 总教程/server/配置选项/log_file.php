log_file

log_file => '/data/log/swoole.log', 指定swoole错误日志文件。在swoole运行期发生的异常信息会记录到这个文件中。默认会打印到屏幕。

注意log_file不会自动切分文件，所以需要定期清理此文件。观察log_file的输出，可以得到服务器的各类异常信息和警告。

log_file中的日志仅仅是做运行时错误记录，没有长久存储的必要。

开启守护进程模式后(daemonize => true)，标准输出将会被重定向到log_file。在PHP代码中echo/var_dump/print等打印到屏幕的内容会写入到log_file文件

日志标号

在日志信息中，进程ID前会加一些标号，表示日志产生的线程/进程类型。

# Master进程
$ Manager进程
* Worker进程
^ Task进程

重新打开日志文件

在服务器程序运行期间日志文件被mv移动或unlink删除后，日志信息将无法正常写入，这时可以向Server发送SIGRTMIN信号实现重新打开日志文件。

在1.8.10或更高版本可用
仅支持Linux平台


<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/6
 * Time: 20:13
 */