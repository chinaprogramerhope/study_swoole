swoole.aio_thread_num
- 设置aio异步文件读写的线程数量

swoole.display_errors
- 关闭/开启swoole错误信息

swoole.unixsock_buffer_size
- 设置进程间通信的unixsocket缓存区尺寸

swoole.fast_serialize
- swoole_server中的task功能中是否使用swoole_serialize对异步任务数据序列化

swoole.use_namespace
- 此配置不支持运行时修改，必须运行前设置php.ini来启用命名空间
1.8.7或更高版本不再需要设置此选项，可同时使用命名空间/非命名空间2种风格
使用命名空间类风格，默认为关闭。启用命名空间后，所有的swoole类必须修改为命名空间格式。 对应关系如下：
下划线类名风格 	命名空间风格
swoole_server	Swoole\Server
swoole_client	Swoole\Client
swoole_process	Swoole\Process
swoole_timer	Swoole\Timer
swoole_table	Swoole\Table
swoole_lock	    Swoole\Lock
swoole_atomic	Swoole\Atomic
swoole_buffer	Swoole\Buffer
swoole_redis	Swoole\Redis
swoole_event	Swoole\Event
swoole_mysql	Swoole\MySQL
swoole_mmap	    Swoole\Mmap
swoole_channel	    Swoole\Channel
swoole_serialize	Swoole\Serialize
swoole_http_server	Swoole\Http\Server
swoole_http_client	Swoole\Http\Client
swoole_http_request	Swoole\Http\Request
swoole_http_response	Swoole\Http\Response
swoole_websocket_server	Swoole\WebSocket\Server

需要swoole-1.8.1或更高版本

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/5
 * Time: 18:31
 */
