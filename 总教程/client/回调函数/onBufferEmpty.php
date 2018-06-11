onBufferEmpty

当缓存区低于最低水位线时触发此事件.
function onBufferEmpty(Swoole\Client $cli);

    设置client->buffer_low_watermark来控制缓存区低水位线
    触发此事件后，表明当前发送队列中的数据已被发出，可以继续向服务器端发送数据

