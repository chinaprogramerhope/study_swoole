package_length_func

设置长度计算函数，与Server的使用方法完全一致。与open_length_check配合使用。长度函数必须返回一个整数。此配置对同步客户端、异步客户端均有效。

    返回0，数据不足，需要接收更多数据
    返回-1，数据错误，底层会自动关闭连接
    返回包长度值（包括包头和包体的总长度），底层会自动将包拼好后返回给回调函数

默认底层最大会读取8K的数据，如果包头的长度较小可能会存在内存复制的消耗。可设置package_body_offset参数，底层只读取包头进行长度解析。




<?php
// 实例
$client = new swoole_client(SWOOLE_SOCK_TCP);
$client->set([
    'open_length_check' => true,
    'package_length_func' => function ($data) {
        if (strlen($data) < 0) {
            return 0;
        }
        $length = intval(trim(substr($data, 0, 8)));
        if ($length <= 0) {
            return -1;
        }
        return $length + 8;
    },
]);
if (!$client->connect('127.0.0.1', 9501, -1)) {
    exit("connect failed. error: {$client->errCode}\n");
}
$client->send("hello world\n");
echo $client->recv();
$client->close();