1.7.4后swoole增加了对SSL隧道加密的支持，在swoole_server中可以启用SSL证书加密。
使用仅需增加$serv->set的配置即可，并将listener端口的类型，增加SWOOLE_SSL标志。

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/5
 * Time: 16:16
 */
$serv = new swoole_server('0.0.0.0', 443, SWOOLE_PROCESS, SWOOLE_SOCK_TCP | SWOOLE_SSL);
$key_dir = dirname(dirname(__DIR__)) . '/tests/ssl';

// SWOOLE_SOCK_TCP表示此端口不加密
// SWOOLE_SOCK_TCP | SWOOLE_SSL表示此端口启用加密

$serv->addListener('0.0.0.0', 80, SWOOLE_SOCK_TCP);

$serv->set([
    'worker_num' => 4,
    'ssl_cert_file' => $key_dir . '/ssl.crt',
    'ssl_key_file' => $key_dir . '/ssl.key',
]);
?>

配置证书后即可启用SSL隧道加密，onReceive/$serv->send函数中还是继续填写明文，加密工作由底层完成。应用层无需考虑。
