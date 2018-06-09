ssl_ciphers

启用SSL后，设置ssl_ciphers来改变openssl默认的加密算法。Swoole底层默认使用EECDH+AESGCM:EDH+AESGCM:AES256+EECDH:AES256+EDH
$server->set([
    'ssl_ciphers' => 'ALL:!ADH:!EXPORT56:RC4+RSA:+HIGH:+MEDIUM:+LOW:+SSLv2:+EXP',
]);
ssl_ciphers 设置为空字符串时，由openssl自行选择加密算法

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/7
 * Time: 11:24
 */