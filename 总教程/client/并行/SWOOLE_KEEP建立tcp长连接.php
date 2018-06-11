SWOOLE_KEEP建立tcp长连接

swoole_client支持在php-fpm/apache中创建一个tcp长连接到服务端. 使用方法:
$client = new swoole_client(SWOOLE_SOCK_TCP | SWOOLE_KEEP);
$client->connect('127.0.0.1', 9501);

启用SWOOLE_KEEP选项后，一个请求结束不会关闭socket，下一次再进行connect时会自动复用上次创建的连接。如果执行connect发现连接已经被服务器关闭，那么connect会创建新的连接。


SWOOLE_KEEP的优势

TCP长连接可以减少connect 3次握手/close 4次挥手带来的额外IO消耗
降低服务器端close/connect次数
