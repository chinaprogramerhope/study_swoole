方法列表
SSL/TLS

依赖openssl库，需要在编译swoole时增加enable-openssl或with-openssl-dir
必须在定义Client时增加SWOOLE_SSL

低于1.9.5版本在设置ssl_key_file后会自动启用SSL
$client = new Swoole\Client(SWOOLE_TCP | SWOOLE_ASYNC | SWOOLE_SSL);
<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/7
 * Time: 19:49
 */