swoole_client->sendfile

发送文件到服务器，本函数是基于sendfile操作系统调用实现，在1.7.5以上版本可用。
bool swoole_client->sendfile(string $filename, int $offset = 0, int $length = 0);

sendfile不能用于UDP客户端和SSL隧道加密连接



参数

$filename指定要发送文件的路径
$offset 上传文件的偏移量，可以指定从文件的中间部分开始传输数据。此特性可用于支持断点续传。
$length 发送数据的尺寸，默认为整个文件的尺寸



返回值

如果传入的文件不存在，将返回false
执行成功返回true



注意事项

$length, $offset参数在1.9.11或更高版本可用
如果是同步client，sendfile会一直阻塞直到整个文件发送完毕或者发生致命错误
如果是异步client，sendfile会异步发送，当发生致命错误时会回调onError
