onManagerStart

当管理进程启动时调用它，函数原型：
void onManagerStart(swoole_server $serv);

在这个回调函数中可以修改管理进程的名称。

注意manager进程中不能添加定时器
manager进程中可以调用sendMessage接口向其他工作进程发送消息



<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/7
 * Time: 15:46
 */