压力测试
注意事项

不同的硬件平台和软件环境，测试出的实际数据并不相同，因此仅建议进行基准测试，在相同的环境下测试不同软件系统之间的性能差距

编译Swoole必须关闭debug，使用gcc -O2或更高优化级别
关闭屏幕输出，否则打印屏幕的echo操作会使服务器阻塞
在多核的机器上开启合适的进程数量，进程数量不足将无法发挥全部硬件计算能力
检查程序中是否存在PHP错误，PHP错误处理会使服务器的处理能力大幅下降

优化选项

使用SWOOLE_BASE模式，可以减少2次IPC开销，提升性能
启用端口复用，可大幅提高短连接服务的性能，需要Linux-3.10或更高版本内核
Http服务器请关闭gzip压缩，可节省服务器CPU的开销
Http服务器请使用KeepAlive长连接测试，避免短连接的IO开销降低性能差异比例
移除没有实际逻辑的回调设置，如程序中并未使用onConnect和onClose回调，在代码中不要设置这2项回调
<?php
Swoole\Async::set(['enable_reuse_port' => true]);
$serv = new Swoole\Server('0.0.0.0', 9502, SWOOLE_BASE);

$serv->set([
    'worker_num' => 8,
]);

$serv->on('Receive', function (swoole_server $serv, $fd, $from_id, $data) {
    $serv->send($fd, "Swoole: " . $data);
});

$serv->start();
?>

其他提示

使用ab测试工具时，请开启-k长连接
ab测试工具不支持Http-Chunk，在Http\Server中请勿使用response->write

