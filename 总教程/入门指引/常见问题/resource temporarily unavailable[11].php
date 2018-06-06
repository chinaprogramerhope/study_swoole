客户端swoole_client在recv时报

swoole_client::recv(): recv() failed. Error: Resource temporarily unavailable [11]

这个错误表示，服务器端在规定的时间内没有返回数据，接收超时了。

可以通过tcpdump查看网络通信过程，检查服务器是否发送了数据
服务器的$serv->send函数需要检测是否返回了true
外网通信时，耗时较多需要调大swoole_client的超时时间

<?php
/**
 * Created by PhpStorm.
 * User: ftd20
 * Date: 2018/6/6
 * Time: 8:19
 */