swoole_client->getPeerCert

获取服务器端证书信息
function swoole_client->getPeerCert();



    执行成功返回一个X509证书字符串信息
    执行失败返回false
    必须在SSL握手完成后才可以调用此方法
    可以使用openssl扩展提供的openssl_x509_parse函数解析证书的信息

    需要在编译swoole时启用--enable-openssl
    此方法在1.8.8或更高版本可用
