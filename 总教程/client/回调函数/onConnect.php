onConnect

客户端连接服务器成功后会回调此函数
function onConnect(swoole_client $client)

    TCP客户端必须设置onConnect回调
    UDP客户端可选设置onConnect，socket创建成功会立即回调onConnect
