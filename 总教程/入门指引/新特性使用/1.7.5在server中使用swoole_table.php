1.7.5增加了swoole_table共享内存表，swoole_table可以与swoole_server结合使用。使用方法也很简单

在swoole_server->start()之前创建swoole_table对象。并存入全局变量或者类静态变量/对象属性中。
在worker/task进程中获取table对象，并使用

只有在swoole_server->start()之前创建的table对象才能在子进程中使用
swoole_table构造方法中指定了最大容量，一旦超过此数据容量将无法分配内存导致set操作失败。所以使用swoole_table之前一定要规划好数据容量

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/5
 * Time: 16:24
 */
$table = new swoole_table(1024);
$table->column('fd', swoole_table::TYPE_INT);
$table->column('from_id', swoole_table::TYPE_INT);
$table->column('data', swoole_table::TYPE_STRING, 64);
$table->create();

$serv = new swoole_server('127.0.0.1', 9501);
// 将table保存在serv对象上
$serv->table = $table;

$serv->on('receive', function ($serv, $fd, $from_id, $data) {
    $ret = $serv->table->set($fd, [
        'from_id' => $data,
        'fd' => $fd,
        'data' => $data
    ]);
});

$serv->start();