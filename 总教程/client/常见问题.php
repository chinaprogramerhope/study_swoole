常见问题

object is not instanceof swoole_client

出现这个错误，表明代码中在客户端连接关闭后，仍然调用了recv、send等方法操作socket。