daemonize

守护进程化。设置daemonize => 1时，程序将转入后台作为守护进程运行。长时间运行的服务器端程序必须启用此项。

如果不启用守护进程，当ssh终端退出后，程序将被终止运行。

启用守护进程后，标准输入和输出会被重定向到 log_file
如果未设置log_file，将重定向到 /dev/null，所有打印屏幕的信息都会被丢弃
启用守护进程后，CWD（当前目录）环境变量的值会发生变更，相对路径的文件读写会出错。PHP程序中必须使用绝对路径

systemd

使用systemd管理Swoole服务时，请勿设置daemonize = 1。主要原因是systemd的机制与init不同。init进程的PID为1，程序使用daemonize后，会脱离终端，最终被init进程托管，与init关系变为父子进程关系。

但systemd是启动了一个单独的后台进程，自行fork管理其他服务进程，因此不需要daemonize，反而使用了daemonize = 1会使得Swoole程序与该管理进程失去父子进程关系。

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/6
 * Time: 20:07
 */