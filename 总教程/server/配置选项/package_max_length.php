package_max_length

设置最大数据包尺寸，单位为字节。开启open_length_check/open_eof_check/open_http_protocol等协议解析后。swoole底层会进行数据包拼接。这时在数据包未收取完整时，所有数据都是保存在内存中的。

所以需要设定package_max_length，一个数据包最大允许占用的内存尺寸。如果同时有1万个TCP连接在发送数据，每个数据包2M，那么最极限的情况下，就会占用20G的内存空间。

open_length_check，当发现包长度超过package_max_length，将直接丢弃此数据，并关闭连接，不会占用任何内存。包括websocket、mqtt、http2协议。
open_eof_check，因为无法事先得知数据包长度，所以收到的数据还是会保存到内存中，持续增长。当发现内存占用已超过package_max_length时，将直接丢弃此数据，并关闭连接
open_http_protocol，GET请求最大允许8K，而且无法修改配置。POST请求会检测Content-Length，如果Content-Length超过package_max_length，将直接丢弃此数据，发送http 400错误，并关闭连接

此参数不宜设置过大，否则会占用很大的内存


<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/7
 * Time: 11:10
 */