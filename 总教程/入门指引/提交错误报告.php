当使用swoole发生段错误时，请及时向开发组报告。可以使用gdb工具来得到一份bt信息。使用gdb跟踪需要在编译swoole时增加--enable-debug参数。

如果不方便gdb，也可以提供一份可稳定复现的demo程序

打开core dump

ulimit -c unlimited

使用gdb来查看core dump信息。core文件一般在当前目录，如果操作系统做了处理，将core dump文件放置到其他目录，请替换为相应的路径

gdb php core
gdb php /tmp/core.4596

在gdb下输入bt查看调用栈信息

(gdb)bt
Program terminated with signal 11, Segmentation fault.
#0  0x00007f1cdbe205e0 in swServer_onTimer (reactor=<value optimized out>, event=...)
    at /usr/local/php/swoole-swoole-1.5.9b/src/network/Server.c:92
    92                              serv->onTimer(serv, timer_node->interval);
    Missing separate debuginfos, use: debuginfo-install php-cli-5.3.3-22.el6.x86_64

    在gdb中使用f指令查看代码段

    (gdb)f 1
    (gdb)f 0

    如果没有函数调用栈信息，可能是编译去除了debug信息。请手工修改swoole源码目录下的Makefile文件，修改CFLAGS为

    CFLAGS = -Wall -pthread -g -O0

    内存检测

    除了使用gdb分析之外可以使用valgrind工具检测程序是否正常运行。

    USE_ZEND_ALLOC=0 valgrind php your_file.php

    程序逻辑覆盖后执行ctrl+c中断，将屏幕打印的信息复制到文件中

    注意：有些情况下在虚拟机下共享目录core文件无法生成，会生成一个0字节的文件，请将core文件生成目录改到/var/log/core下。

    提交问题

    请将上面的得到的信息，连同机器信息，包括php -v gcc -v uname -a 提交到 Github Issues页面 或者发送邮件到 team@swoole.com。

    若确定是Swoole底层的问题，开发组会快速解决。
    反馈建议

    为了减少Swoole内核开发者与反馈者之间的沟通成本，请认真阅读以下内容，在GitHub平台尽可能地按照Issue模板提交问题。

    请提供发生问题时使用的php、swoole、操作系统、gcc和openssl（可选）版本信息
    请描述具体是什么情况下发生，尽可能地给出可稳定重现的代码和测试过程
    请使用valgrind、gdb、strace等工具进行初步地问题跟踪，并贴出相关信息和线索
    请认真查看php错误日志、swoole的log_file、操作系统的syslog等日志信息，找到可能与该问题关联的信息和线索

    获取版本信息
    php

    php -v

    swoole

    php --ri swoole

    操作系统类型

    如Linux、MacOS、FreeBSD、CygWin、树莓派等
    内核版本

    uname -a

    gcc

    cc -v

    openssl

    openssl version

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/5
 * Time: 19:50
 */