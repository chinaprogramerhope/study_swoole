配置选项

Swoole\Client和Swoole\Http\Client可以使用set方法设置一些选项, 启用某些特性.

结束符检测
<?php
$client->set([
    'open_eof_check' => true,
    'package_eof' => "\r\n\r\n",
    'package_max_length' => 1024 * 1024 * 2,
]);
?>


长度检测
<?php
$client->set([
    'open_length_check' => 1,
    'package_length_type' => 'N',
    'package_length_offset' => 0, // 第N个字节是包长度的值
    'pakckage_body_offset' => 4, // 第几个字节开始计算长度
    'pakckage_max_length' => 2000000, // 协议最大长度
]);
?>


MQTT协议
<?php
// 启用MQTT协议解析, onReceive回调将受到完整的MQTT数据包
$client->set([
    'open_mqtt_protocol' => true,
]);
?>


socket缓存区尺寸
<?php
$client->set([
    'socket_buffer_size' => 1024 * 1024 * 2, // 2m缓存区
]);
// 包括socket底层操作系统缓存区, 应用层接收数据内存缓存区, 应用层发送数据内存缓存区
?>


关闭nagle合并算法
<?php
$client->set([
    'open_tcp_nodelay' => true,
]);
?>


ssl/tls证书
<?php
$client->set([
    'ssl_cert_file' => $your_ssl_cert_file_path,
    'ssl_key_file' =>  $your_ssl_key_file_path,
]);
// swoole-1.7.21或更高版本可用
?>


绑定ip和端口
<?php
// 机器有多个网卡的情况下, 设置bind_address参数可以强制开了户端socket绑定某个网络地址
// 设置bind_port可以使客户端socket使用固定的端口连接到外网服务器
$client->set([
    'bind_address' => '192.168.1.100',
    'bind_port' => 36002,
]);
// swoole-1.8.5或更高版本可用
?>


socket5或代理设置
<?php
$client->set([
    'socks5_host' => '192.168.1.100',
    'socks5_port' => 1080,
    'socks5_username' => 'username',
    'socks5_password' => 'password',
]);
// socks5_name, socks5_password为可选参数
?>



http代理设置
<?php
$client->set([
    'http_proxy_host' => '192.168.1.100',
    'http_proxy_port' => 1080,
]);
?>


使用说明
    目前支持open_length_check和open_eof_check2种自动协议处理功能，参考swoole_server中的配置选项
    启用了自动协议后，同步阻塞客户端recv方法将不接受长度参数，每次必然返回一个完整的数据包
    启用了自动协议后，异步非阻塞客户端onReceive每次必然返回一个完整的数据包

