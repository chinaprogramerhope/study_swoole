SSL单向认证
Swoole开启SSL
Swoole开启SSL功能需要如下参数：
$server = new swoole_server('127.0.0.1', '9501', SWOOLE_PROCESS,
    SWOOLE_SOCK_TCP | SWOOLE_SSL);
    
$server = new swoole_http_server('127.0.01', '9501', SWOOLE_PROCESS, 
    SWOOLE_SOCK_TCP | SWOOLE_SSL);
    
并在swoole的配置选项中增加如下两个选项:
$server->set([
    'ssl_cert_file' => '/path/to/server.crt',
    'ssl_key_file' => '/path/to/server.key',
]);

这时, swoole服务器就已经开启了单向ssl认证, 可以通过https://127.0.0.1:9501/进行访问