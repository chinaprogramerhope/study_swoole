创建一个异步server对象
$serv = new swoole_server(string $host, int $port = 0, int $mode = SWOOLE_PROCESS,
    int $sock_type = SWOOLE_SOCK_TCP);

参数

$host参数用来指定监听的ip地址，如127.0.0.1，或者外网地址，或者0.0.0.0监听全部地址
IPv4使用 127.0.0.1表示监听本机，0.0.0.0表示监听所有地址
IPv6使用::1表示监听本机，:: (相当于0:0:0:0:0:0:0:0) 表示监听所有地址
$port监听的端口，如9501
如果$sock_type为UnixSocket Stream/Dgram，此参数将被忽略
监听小于1024端口需要root权限
如果此端口被占用server->start时会失败
$mode运行的模式
SWOOLE_PROCESS多进程模式（默认）
SWOOLE_BASE基本模式
$sock_type指定Socket的类型，支持TCP、UDP、TCP6、UDP6、UnixSocket Stream/Dgram 6种
使用$sock_type | SWOOLE_SSL可以启用SSL隧道加密。启用SSL后必须配置ssl_key_file和ssl_cert_file
1.7.11版本增加了对Unix Socket的支持，详细请参见 /wiki/page/16.html
构造函数中的参数与swoole_server::addlistener中是完全相同的
监听端口失败，在1.9.16以上版本会抛出异常，可以使用try/catch捕获异常，在1.9.16以下版本抛出致命错误
高负载的服务器，请务必调整Linux内核参数
3种Server运行模式介绍

注意事项

底层有保护机制，一个PHP程序内只能创建启动一个Server实例
如果要实现多个Server实例的管理，父进程必须使用exec，不得使用fork

随机可用端口

swoole-1.9.6增加了随机监听可用端口的支持，$port参数可以设置为0，操作系统会随机分配一个可用的端口，进行监听。可以通过读取$server->port得到分配到的端口号。
$http = new swoole_http_server('0.0.0.0');

$http->on('request', function ($request, $response) {
    $response->header('Content-Type', 'text/html; charset=utf-8');
    $response->end("<h1>hello swoole. #" . rand(1000, 9999) . "</h1>");
});

$http->start();



SYSTEMD监听端口

swoole-1.9.7增加了对systemd socket的支持。监听端口由systemd配置指定。

swoole.socket
[Unit]
Description=Swoole Socket

[Socket]
ListenStream=9501
Accept=false
[Install]
WantedBy=sockets.target

swoole.service
[Service]
Type=forking
PIDFile=/var/run/swoole.pid
ExecStart=/usr/bin/php /var/www/swoole/server.php
ExecStop=/bin/kill $MAINPID
ExecReload=/bin/kill -USR1 $MAINPID

[Install]
WantedBy = multi-user.target


<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/6
 * Time: 10:45
 */
// server.php
$http = new swoole_http_server('systemd');

$http->set([
    'daemonize' => true,
    'pid_file' => '/var/run/swoole.pid',
]);

$http->on('request', function ($request, $response) {
    $response->header('Content-Type', 'text/html; charset=utf-8');
    $response->end("<h1>hello swoole. #" . rand(1000, 9999) . "</h1>");
});

$http->start();
?>

启动服务

sudo systemctl enable swoole.socket
sudo systemctl start swoole.socket
sudo systemctl start swoole.service


