ssl_host_name

设置服务器主机名称, 与ssl_verify_peer配置或Client::verifyPeerCert配合使用
$client->set([
    'ssl_host_name' => 'www.google.com',
]);