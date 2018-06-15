swoole_process->write 

向管道内写入数据.
int swoole_process->write(string $data);

$data的长度在linux系统下最大不超过8k, macos/freebsd下最大不超过2k
在子进程内调用write, 父进程可以调用read接收此数据
在父进程内调用write, 子进程可以调用read接收此数据

swoole底层使用unix socket实现通信, unix socket是内核实现的全内存通信, 无任何io消耗.
在1进程write, 1进程read, 每次都写1024字节数据的测试中, 100万次通信仅需1.02秒.

管道通信默认的方式是流式, write写入的数据在read可能会被底层合并.
可以设置swoole_process构造函数的第三个参数为2改变为数据报式.

macos/freebsd可以设置net.local.dgram.maxdgram内核参数修改最大长度
====


异步模式

如果进程内使用了异步io, 比如swoole_event_add, 进程内执行write操作将变为异步模式.
swoole底层会监听可写事件, 自动完成管道写入.

异步模式下如果socket缓存区已满, swoole的处理逻辑请参考 swoole_event_write
====


同步模式

进程内未使用任何异步io, 当前管道为同步阻塞模式, 如果缓存区已满, 
将阻塞等待直到write操作完成.

task进程就是同步阻塞的模式, 如果管道的缓存区已满, 调用write时会发生阻塞
====


乱序丢包

很多网络文章提到DGRAM模式下会出现丢包, 乱序问题, 实际上这些问题仅存在于internet网络的udp通信.
unixsocket时linux内核是先的内存数据队列, 不会出现丢包乱序问题.
write写入和read读取的顺序是完全一致的.
write返回成功后一定是可以read到的.