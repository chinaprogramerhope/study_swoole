reload_async

设置异步重启开关。设置为true时，将启用异步安全重启特性，Worker进程会等待异步事件完成后再退出。详细信息请参见 异步安全重启特性
$serv->set([
    'reload_async' => true
]);

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/7
 * Time: 11:54
 */