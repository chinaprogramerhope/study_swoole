onBufferEmpty

当缓存区低于最低水位线时触发此事件。
function onBufferEmpty(Swoole\Server $serv, int $fd);


设置server->buffer_low_watermark来控制缓存区低水位线
触发此事件后，表明当前的$fd发送队列中的数据已被发出，可以继续向此连接发送数据了

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/7
 * Time: 15:31
 */