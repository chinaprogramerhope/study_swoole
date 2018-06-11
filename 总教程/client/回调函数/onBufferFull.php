onBufferFull

当缓存区达到最高水位时触发此事件.
function onBufferFull(Swoole\Client $cli);

    设置client->buffer_high_watermark选项来控制缓存区高水位线
    触发onBufferFull表明发送队列已触顶即将塞满，不能再向服务器端发送数据
