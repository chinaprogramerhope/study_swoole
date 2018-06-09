open_cpu_affinity

启用CPU亲和性设置。在多核的硬件平台中，启用此特性会将swoole的reactor线程/worker进程绑定到固定的一个核上。可以避免进程/线程的运行时在多个核之间互相切换，提高CPU Cache的命中率。

使用taskset命令查看进程的CPU亲和设置：

taskset -p 进程ID
pid 24666's current affinity mask: f
pid 24901's current affinity mask: 8

mask是一个掩码数字，按bit计算每bit对应一个CPU核，如果某一位为0表示绑定此核，进程会被调度到此CPU上，为0表示进程不会被调度到此CPU。

示例中pid为24666的进程mask = f 表示未绑定到CPU，操作系统会将此进程调度到任意一个CPU核上。 pid为24901的进程mask = 8，8转为二进制是 1000，表示此进程绑定在第4个CPU核上。

仅推荐在全异步非阻塞的Server程序中启用


<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/7
 * Time: 11:12
 */