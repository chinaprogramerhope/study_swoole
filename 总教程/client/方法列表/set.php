swoole_client->set

设置客户端参数，必须在connect前执行。swoole-1.7.17为客户端提供了类似swoole_server的自动协议处理功能。通过设置一个参数即可完成TCP的自动
function swoole_client->set(array $settings);

可用的配置选项参考 Client - 配置选项
<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/7
 * Time: 19:59
 */