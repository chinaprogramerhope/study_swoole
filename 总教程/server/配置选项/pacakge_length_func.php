package_length_func

设置长度解析函数，支持C++或PHP的2种类型的函数。长度函数必须返回一个整数。

返回0，数据不足，需要接收更多数据
返回-1，数据错误，底层会自动关闭连接
返回包长度值（包括包头和包体的总长度），底层会自动将包拼好后返回给回调函数

默认底层最大会读取8K的数据，如果包头的长度较小可能会存在内存复制的消耗。可设置package_body_offset参数，底层只读取包头进行长度解析。
PHP长度解析函数

由于ZendVM不支持运行在多线程环境，因此底层会自动使用Mutex互斥锁对PHP长度函数进行加锁，避免并发执行PHP函数。在1.9.3或更高版本可用。

请勿在长度解析函数中执行阻塞IO操作，可能导致所有Reactor线程发生阻塞


<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/7
 * Time: 11:05
 */
$serv = new swoole_server('127.0.0.1', 9501);

$serv->set([
    'open_length_check' => true,
    'dispatch_mode' => 1,
    'package_length_func' => function ($data) {
        if (strlen($data) < 8) {
            return 0;
        }
        $length = intval(trim(substr($data, 0, 8)));
        if ($length <= 0) {
           return -1;
        }
        return $length + 8;
    },
    'package_max_length' => 2000000, // 协议最大长度
]);

$serv->on('receive', function (swoole_server $serv, $fd, $from_id, $data) {
    var_dump($data);
    echo "#{$serv->worker_id}>> received length=" . strlen($data) . "\n";
});

$serv->start();
?>


C++长度解析函数

在其他PHP扩展中，使用swoole_add_function注册长度函数到Swoole引擎中。

C++长度函数调用时底层不会加锁，需要调用方自行保证线程安全性

实例：
#include <string>
    #include <iostream>
        #include "swoole.h"

        using namespace std;

        int test_get_length(swProtocol *protocol, swConnection *conn, char *data, uint32_t length);

        void register_length_function(void)
        {
        swoole_add_function((char *) "test_get_length", (void *) test_get_length);
        return SW_OK;
        }

        int test_get_length(swProtocol *protocol, swConnection *conn, char *data, uint32_t length)
        {
        printf("cpp, size=%d\n", length);
        return 100;
        }

