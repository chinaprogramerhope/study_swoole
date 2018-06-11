ssl_cafile

当设置ssl_verify_peer为true时, 用来验证远端证书所用到的ca证书. 
本选项值为ca证书在本地文件系统的全路径及文件名.

类型: string

$client->set([
    'ssl_cafile' => '/etc/CA',
]);
