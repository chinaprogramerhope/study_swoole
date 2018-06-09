ssl_cert_file

设置SSL隧道加密，设置值为一个文件名字符串，制定cert证书和key私钥的路径。

https应用浏览器必须信任证书才能浏览网页
wss应用中，发起WebSocket连接的页面必须使用https
浏览器不信任SSL证书将无法使用wss
文件必须为PEM格式，不支持DER格式，可使用openssl工具进行转换

使用SSL必须在编译swoole时加入--enable-openssl选项
$serv = new swoole_server('0.0.0.0', 9501, SWOOLE_PROCESS, SWOOLE_SOCK_TCP | SWOOLE_SSL);
$serv->set([
    'ssl_cert_file' => __DIR__ . '/config/ssl.crt',
    'ssl_key_file' => __DIR__ . '/config/ssl.key',
]);

PEM转DER格式

openssl x509 -in cert.crt -outform der -out cert.der

DER转PEM格式

openssl x509 -in cert.crt -inform der -outform pem -out cert.pem

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/7
 * Time: 11:21
 */