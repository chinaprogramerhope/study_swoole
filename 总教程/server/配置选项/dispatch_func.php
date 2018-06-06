dispatch_func

设置dispatch函数，swoole底层了内置了5种dispatch_mode，如果仍然无法满足需求。可以使用编写C++函数或PHP函数，实现dispatch逻辑。使用方法：
$serv->set([
    'dispatch_func' => 'my_dispatch_function',
]);

设置dispatch_func后底层会自动忽略dispatch_mode配置
dispatch_func对应的函数不存在，底层将抛出致命错误
如果需要dispatch一个超过8K的包，dispatch_func只能获取到 0-8180 字节的内容

dispatch_func在1.9.7或更高版本可用
dispatch_func在1.9.18或更高版本可以设置为PHP函数
dispatch_func仅在SWOOLE_PROCESS模式下有效，UDP/TCP/UnixSocket均有效

编写PHP函数
由于ZendVM无法支持多线程环境，即使设置了多个Reactor线程，同一时间只能执行一个dispatch_func。因此底层在执行此PHP函数时会进行加锁操作，可能会存在锁的争抢问题。请勿在dispatch_func中执行任何阻塞操作，否则会导致Reactor线程组停止工作。
$serv->set([
    'dispatch_mode' => function ($serv, $fd, $type, $data) {
        var_dump($fd, $type, $data);
        return intval($data[0]);
    }
]);

$fd为客户端连接的唯一标识符，可使用Server::getClientInfo获取连接信息
$type数据的类型，0表示来自客户端的数据发送，4表示客户端连接关闭，5表示客户端连接建立
$data数据内容，需要注意：如果启用了Http、EOF、Length等协议处理参数后，底层会进行包的拼接。但在dispatch_func函数中只能传入数据包的前8K内容，不能得到完整的包内容。
必须返回一个[0-serv->worker_num)的数字，表示数据包投递的目标工作进程ID
小于0或大于等于serv->worker_num为异常目标ID，dispatch的数据将会被丢弃


编写C++函数

在其他PHP扩展中，使用swoole_add_function注册长度函数到Swoole引擎中。

C++函数调用时底层不会加锁，需要调用方自行保证线程安全性
int dispatch_function(swServer *serv, swConnection *conn, swEventData *data);

int dispatch_function(swServer *serv, swConnection *conn, swEventData *data) {
    printf("cpp, type=%d, size=%d\n", data->info.type, data->info.len);
    return data->info.len % serv->worker_num;
}

int register_dispatch_function(swModule *module) {
    swoole_add_function('my_dispatch_function', (void *) dispatch_function);
}

dispatch函数必须返回投递的目标worker进程id
返回的worker_id不得超过serv->worker_num，否则底层会抛出段错误
返回负数（return -1）表示丢弃此数据包
data可以读取到事件的类型和长度
conn是连接的信息，如果是UDP数据包，conn为NULL


<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/6
 * Time: 19:48
 */