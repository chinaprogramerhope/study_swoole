服务器端设置
双向认证指服务器也要对发起请求的客户端进行认证，只有通过认证的客户端才能进行访
问。 为了开启SSL双向认证，swoole需要额外的配置参数如下：
$server->set([
    'ssl_cert_file' => '/path/to/server.crt',
    'ssl_key_file' => '/path/to/server.key',
    'ssl_client_cert_file' => '/path/to/ca.crt',
    'ssl_verify_depth' => 10,
]);

客户端设置
这里我们使用CURL进行https请求的发起。 首先，需要配置php.ini,增加如下配置：
curl.cainfo = /path/to/ca.crt

发起curl请求时, 增加如下配置项:
$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, '2');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // 只信任ca颁布的证书
curl_setopt($ch, CURLOPT_SSLCERT, '/path/to/cer.pem');
curl_setopt($ch, CURLOPT_SSLKEY, '/path/to/key.pem');
curl_setopt($ch, CURLOPT_SSLCERTTYPE, 'PEM');
curl_setopt($ch, CURLOPT_SSLCERTPASSWD, '****'); // 创建客户端证书时标记的client_pwd密码
这时，就可以发起一次https请求，并且被swoole服务器验证通过了。