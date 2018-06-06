swoole_server->sendfile

发送文件到TCP客户端连接。使用示例：
bool swoole_server->sendfile(int $fd, string $filename, int $offset = 0, int $length = 0);

sendfile函数调用OS提供的sendfile系统调用，由操作系统直接读取文件并写入socket。sendfile只有2次内存拷贝，使用此函数可以降低发送大量文件时操作系统的CPU和内存占用。

$filename 要发送的文件路径，如果文件不存在会返回false
$offset 指定文件偏移量，可以从文件的某个位置起发送数据。默认为0，表示从文件头部开始发送
$length 指定发送的长度，默认为文件尺寸。
操作成功返回true，失败返回false

此函数与swoole_server->send都是向客户端发送数据，不同的是sendfile的数据来自于指定的文件
sendfile在低于1.9.17版本中不能用于SSL客户端连接
$length和$offset在1.9.11版本后可用



<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/6
 * Time: 14:24
 */