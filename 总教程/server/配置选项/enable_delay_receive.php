enable_delay_receive

设置此选项为true后，accept客户端连接后将不会自动加入EventLoop，仅触发onConnect回调。worker进程可以调用$serv->confirm($fd)对连接进行确认，此时才会将fd加入EventLoop开始进行数据收发，也可以调用$serv->close($fd)关闭此连接。



<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/7
 * Time: 11:47
 */
// 实例

// 开启enable_delay_receive选项
$serv->set([
    'enable_delay_receive' => true,
]);

$serv->on('Connect', function ($serv, $fd, $reactorId) {
    $serv->after(2000, function () use ($serv, $fd) {
        // 确认连接, 开始接收数据
        $serv->confirm($fd);
    });
});
?>

enable_delay_receive在1.8.8或更高版本可用
