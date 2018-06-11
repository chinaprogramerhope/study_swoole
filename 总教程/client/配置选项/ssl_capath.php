ssl_capath

如果未设置ssl_cafile, 或者ssl_cafile所指的文件不存在时, 会在ssl_capath所指定的目录搜索适用的证书.
该目录必须是已经经过哈希处理的证书目录.

类型: string
$client->set([
    'ssl_capath' => '/etc/capath/',
]);