tcp_fact_open

开启TCP快速握手特性。此项特性，可以提升TCP短连接的响应速度，在客户端完成握手的第三步，发送SYN包时携带数据。
$server->set([
    'tcp_fastopen' => true
]);

此参数可以设置到监听端口上

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/7
 * Time: 11:58
 */