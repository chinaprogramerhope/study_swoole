onBufferFull

当缓存区达到最高水位时触发此事件。
function onBufferFull(Swoole\Server $serv, int $fd);


设置buffer_high_watermark选项来控制缓存区高水位线，单位为字节
触发onBufferFull表明此连接$fd的发送队列已触顶即将塞满，这时不应当再向此$fd发送数据

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/7
 * Time: 15:30
 */
$server->set([
    'buffer_high_watermark' => 8 * 1024 * 1024,
]);

$server->on('onBufferFull', function ($serv, $fd) {

});