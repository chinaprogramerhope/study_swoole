reactor_num

Reactor线程数，reactor_num => 2，通过此参数来调节主进程内事件处理线程的数量，以充分利用多核。默认会启用CPU核数相同的数量。

reactor_num建议设置为CPU核数的1-4倍
reactor_num最大不得超过SWOOLE_CPU_NUM * 4

Reactor线程是可以利用多核，如：机器有128核，那么底层会启动128线程。每个线程能都会维持一个EventLoop。线程之间是无锁的，指令可以被128核CPU并行执行。考虑到操作系统调度存在一定程度的性能损失，可以设置为CPU核数*2，以便最大化利用CPU的每一个核。

reactor_num必须小于或等于worker_num
如果设置的reactor_num大于worker_num，会自动调整使reactor_num等于worker_num
1.7.14以上版本在超过8核的机器上reactor_num默认设置为8


<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/6
 * Time: 18:11
 */