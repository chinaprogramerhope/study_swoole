enable_reuse_port

设置端口重用，此参数用于优化TCP连接的Accept性能，启用端口重用后多个进程可以同时进行Accept操作。

enable_reuse_port = true 打开端口重用
enable_reuse_port = false 关闭端口重用

仅在Linux-3.9.0以上版本的内核可用
启用端口重用后可以重复启动同一个端口的Server程序


<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/7
 * Time: 11:45
 */