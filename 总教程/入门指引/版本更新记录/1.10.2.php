
修复BASE模式设置max_request=1时发生崩溃的问题
修复WebSocket客户端在握手响应与数据帧在同一个传输单元时解包失败的问题
修复SSL连接无法使用sendfile的问题
修复BASE模式下频繁reload导致进程丢失的问题
修复swoole_async_dns_lookup在启用jemalloc时发生崩溃的问题
修复PHP7.2版本中开启opcache.enable_cli=On时发生崩溃的问题
修改Client在域名解析失败时的错误信息
进程在reload时标记为繁忙状态，不再接收新请求

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/5
 * Time: 14:49
 */