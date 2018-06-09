
常见问题
连接超时

Chrome错误信息：Error in connection establishment: net::ERR_TIMED_OUT
Socket客户端连接错误码：110, 114, 115

此类错误可能是网络通信存在问题，如主机IP不可达、防火墙等原因。TCP的三次握手是由Linux内核完成的，与应用层软件无关，只要Server监听此端口，服务器就会自动对客户端连接完成握手，无需Server程序参与。
连接被拒绝

Socket客户端连接错误码：111

服务器未监听此端口或者监听端口的listen队列已满。
接收超时

Socket客户端连接错误码：11

数据接收超时，表示服务器端在规定的时间内未向客户端发送数据。一般出现在同步客户端中，调用$client->recv接收Response，服务器处理的时间过长，超过了$client->connect设置的超时时间（默认500ms）。

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/7
 * Time: 17:19
 */