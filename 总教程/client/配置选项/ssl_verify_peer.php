ssl_verify_peer

验证服务器端证书.
$client->set[
    'ssl_verify_peer' => true,
];

启用后会验证证书和主机域名是否对应, 如果为否将自动关闭连接


自签名证书
可设置ssl_allow_self_signed为true, 允许自签名证书
$client->set([
    'ssl_verify_peer' => true,
    'ssl_allow_self_signed' => true,
]);