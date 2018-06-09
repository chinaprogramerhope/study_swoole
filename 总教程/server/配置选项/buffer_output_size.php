buffer_output_size

配置发送输出缓存区内存尺寸。
$server->set([
    'buffer_output_size' => 32 * 1024 *1024, //必须为数字
]);


单位为字节，默认为2M，如设置32 * 1024 *1024表示，单次Server->send最大允许发送32M字节的数据
调用swoole_server->send， swoole_http_server->end/write，swoole_websocket_server->push 等发送数据指令时，单次最大发送的数据不得超过buffer_output_size配置。

注意此函数不应当调整过大，避免拥塞的数据过多，导致吃光机器内存
开启大量worker进程时，将会占用worker_num * buffer_output_size字节的内存

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/7
 * Time: 11:34
 */