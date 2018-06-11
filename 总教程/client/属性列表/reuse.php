swoole_client->reuse 

类型: boolean，表示此连接是新创建的还是复用已存在的。与SWOOLE_KEEP配合使用。
1.8.0或更高版本可用


使用场景

WebSocket客户端与服务器建立连接后需要进行握手，如果连接是复用的，那就不需要再次进行握手，直接发送WebSocket数据帧即可。
<?php
if ($client->reuse) {
    $client->send($data);
} else {
    $client->doHandShake();
    $client->send($data);
}