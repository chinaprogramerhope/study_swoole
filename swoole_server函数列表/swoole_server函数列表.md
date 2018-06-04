1. swoole_server::__construct
功能描述：创建一个swoole_server资源对象
函数原型：
// 类成员函数
public function swoole_server::__construct(string $host, int $port, 
    int $mode = SWOOLE_PROCESS, int $sock_type = SWOOLE_SOCK_TCP);

// 公共函数
function swoole_server_create(string $host, int $port, 
    int $mode = SWOOLE_PROCESS, int $sock_type = SWOOLE_SOCK_TCP);
返回：一个swoole_server对象
参数说明：
参数 说明
string host 监听的IP地址
int port 监听的端口号
int mode 运行模式
int sock_type 指定的socket类型
说明： host、port、socket_type的详细说明见swoole_server::addlistener。
mode指定了swoole_server的运行模式，共有如下三种：
SWOOLE_BASE - Base模式
传统的异步非阻塞Server。在Reactor内直接回调PHP
的函数。如果回调函数中有阻塞操作会导致Server退
化为同步模式。worker_num参数对与BASE模式仍然
有效，swoole会启动多个Reactor进程

SWOOLE_THREAD - 线程模式(已废弃)
多线程Worker模式，Reactor线程来处理网络事件轮
询，读取数据。得到的请求交给Worker线程去处理。
多线程模式比进程模式轻量一些，而且线程之间可以
共享堆栈和资源。 访问共享内存时会有同步问题，需
要使用Swoole提供的锁机制来保护数据。

SWOOLE_PROCESS - 进程模式(默认)
Swoole提供了完善的进程管理、内存保护机制。 在业
务逻辑非常复杂的情况下，也可以长期稳定运行，适
合业务逻辑非常复杂的场景。
样例:
$serv = new swoole_server('127.0.0.1', 8888, SWOOLE_PROCESS, SWOOLE_SOCK_TCP);


2. swoole_server::set
功能描述：设置swoole_server运行时的各项参数
函数原型：
// 类成员函数
public function swoole_server::set(array $setting);
// 公共函数
function swoole_server_set(swoole_server $server, array $setting);
返回：无
参数说明：
array setting 配置选项数组，采用key-value形式
说明：
该函数必须在swoole_server::start函数调用前调用。
全部swoole_server的配置参数点此查看
样例:
$serv->set([
    'worker_num' => 8,
    'max_request' => 10000,
    'max_conn' => 100000,
    'dispatch_mode' => 2,
    'debug_mode' => 1,
    'daemonize' => false,
]);


3. swoole_server::on
功能描述：绑定swoole_server的相关回调函数
函数原型：
// 类成员函数
public function bool swoole_server->on(string $event, mixed $callback);

返回：设置成功返回true，否则返回false
参数说明：
参数 说明
string event 回调的名称（大小写不敏感）
mixed
callback
回调的PHP函数，可以是函数名的字符串，类静态方法，对象方法数
组，匿名函数
说明：
该函数必须在swoole_server::start函数调用前调用。
此方法与swoole_server::handler功能相同，作用是与swoole_client风格保持一致。
swoole_server::on中事件名称字符串不要加on。
全部的回调函数列表点此查看
样例:
$serv->on('connect', function ($serv, $fd) {
    echo "Client: Connect.\n";
});
$serv->on('receive', [$myclass, 'onReceive']); // onReceive时myclass的成员函数


4. swoole_server::addlistener
功能描述：给swoole_server增加一个监听的地址和端口
函数原型：
// 类成员函数
public function swoole_server::addlistener(string $host, int $port, 
    $type = SWOOLE_SOCK_TCP);
    
// 公共函数
function swoole_server_addlistener(swoole_server $serv, string $host,
    int $port, $type = SWOOLE_SOCK_TCP);
返回：无
参数说明：
string host 监听的IP地址
int port 监听的端口号
int sock_type 指定的socket类型
说明： swoole支持如下socket类型:
sock_type 说明
SWOOLE_TCP/SWOOLE_SOCK_TCP TCP IPv4 Socket
SWOOLE_TCP6/SWOOLE_SOCK_TCP6 TCP IPv6 Socket
SWOOLE_UDP/SWOOLE_SOCK_UDP UDP IPv4 Socket
SWOOLE_UDP6/SWOOLE_SOCK_UDP6 UDP IPv4 Socket
SWOOLE_UNIX_DGRAM Unix UDP Socket
SWOOLE_UNIX_STREAM Unix TCP Socket
Unix Socket仅在1.7.1+后可用，此模式下host参数必须填写可访问的文件路径，port参数忽略
Unix Socket模式下，客户端fd将不再是数字，而是一个文件路径的字符串
SWOOLE_TCP等是1.7.0+后提供的简写方式，与1.7.0前的SWOOLE_SOCK_TCP是等同的
样例:
$serv->addlistener('127.0.0.1', 9502, SWOOLE_SOCK_TCP);
$serv->addlistener('192.168.1.100', 9503, SWOOLE_SOCK_TCP);
$serv->addlistener('0.0.0.0', 9504, SWOOLE_SOCK_UDP);
$serv->addlistener('/var/run/myserv.sock', 0, SWOOLE_UNIX_STREAM);

swoole_server_addlisten($serv, '127.0.0.1', 9502, SWOOLE_SOCK_TCP);


5. swoole_server::handler
功能描述：设置Server的事件回调函数
函数原型：
// 类成员函数
public function swoole_server::handler(string $event_name, mixed $event_callback_function);

// 公共函数
function swoole_server_handler(swoole_server $serv, string $event_name, mixed $event_callback_function);
返回：设置成功返回true，否则返回false
参数说明：
string event_name 回调的名称（大小写不敏感）
mixed
event_callback_function
回调的PHP函数，可以是函数名的字符串，类静态方法，对
象方法数组，匿名函数
说明： 该函数必须在swoole_server::start函数调用前调用。
事件名称字符串要加on。
全部的回调函数列表点此查看
onConnect/onClose/onReceive这3个回调函数必须设置。其他事件回调函数可选
如果设定了timer定时器，onTimer事件回调函数也必须设置
如果启用了task_worker，onTask/onFinish事件回调函数必须设置
样例:
$serv->handler('onStart', 'my_onStart');
$serv->handler('onStart', [$this, 'my_onStart']);
$serv->handler('onStart', 'myClass::onStart');


6. swoole_server::start
功能描述：启动server，开始监听所有TCP/UDP端口
函数原型：
// 类成员函数
public function swoole_server::start();
返回：启动成功返回true，否则返回false
参数说明：无
说明：
启动成功后会创建worker_num+2个进程：Master进程+Manager进程+worker_num 个
Worker进程。
另外。启用task_worker会增加task_worker_num个Worker进程
三种进程的说明如下：
进程类型 说明
Master
进程
主进程内有多个Reactor线程，基于epoll/kqueue进行网络事件轮询。收到数
据后转发到Worker进程去处理
Manager
进程
对所有Worker进程进行管理，Worker进程生命周期结束或者发生异常时自动
回收，并创建新的Worker进程
Worker
进程
对收到的数据进行处理，包括协议解析和响应请求
样例:
$serv->start();


7. swoole_server::reload
功能描述：重启所有worker进程。
函数原型：
// 类成员函数
public function swoole_server::reload()

返回：调用成功返回true，否则返回false
参数说明：无
说明：
调用后会向Manager发送一个SIGUSR1信号，平滑重启全部的Worker进程（所谓平滑重启，
是指重启动作会在Worker处理完正在执行的任务后发生，并不会中断正在运行的任务。）
小技巧：在onWorkerStart回调中require相应的php文件，当这些文件被修改后，只需要通过
SIGUSR1信号即可实现服务器热更新。
1.7.7版本增加了仅重启task_worker的功能。只需向服务器发送SIGUSR2即可
样例:
$serv->reload();


8. swoole_server::shutdown
功能描述：关闭服务器。
函数原型：
// 类成员函数
public function swoole_server::shutdown()
返回：调用成功返回true，否则返回false
参数说明：无
说明：
此函数可以用在worker进程内，平滑关闭全部的Worker进程。
也可向Master进程发送SIGTERM信号关闭服务器。
样例:
$serv->shutdown();


9. swoole_server::addtimer
功能描述：设置一个固定间隔的定时器
函数原型：
// 类成员函数
public function swoole_server::addtimer(int $interval);
// 公共函数
function swoole_server_addtimer(swoole_server $serv, int $interval);
返回：设置成功返回true，否则返回false
参数说明：
int interval 定时器的时间间隔，单位为毫秒ms
说明：
swoole定时器的最小颗粒是1毫秒，支持多个不同间隔的定时器。
注意不能存在2个相同间隔时间的定时器。
使用多个定时器时，其他定时器必须为最小定时器时间间隔的整数倍。
该函数只能在onWorkerStart/onConnect/onReceive/onClose回调函数中调用。
增加定时器后需要为Server设置onTimer回调函数，否则Server将无法启动。
样例:
$serv->addtimer(1000); // 1s
swoole_server_addtimer($serv, 20); // 20ms


10. swoole_server::deltimer
功能描述：删除指定的定时器。
函数原型：
// 类成员函数
public function swoole_server::deltimer(int $interval);
返回：无
参数说明：
int interval 定时器的时间间隔，单位为毫秒ms
说明：
删除间隔为interval的定时器
样例:
$serv->deltimer(1000);


11. swoole_server::after
功能描述：在指定的时间后执行函数
函数原型：
// 类成员函数
public function swoole_server::after(int $after_time_ms, mixed $callback_function, mixed $params);
// 公共函数
function swoole_timer_after(swoole_server $serv, int $after_time_ms, mixed $callback_function, mixed $params);
返回：无
参数说明：
int after_time_ms 指定时间，单位为毫秒ms
mixed callback_function 指定的回调函数
mixed params 指定的回调函数的参数
说明：
创建一个一次性定时器，在指定的after_time_ms时间后调用callback_funciton回调函数，执
行完成后就会销毁。
callback_function函数的参数为指定的params
需要swoole-1.7.7以上版本。
样例:
$serv->after(1000, function ($params) {
    echo "Do something\n";
}, "data");


12. swoole_server::close
功能描述：关闭客户端连接
函数原型：
// 类成员函数
public function swoole_server::close(int $fd, int $from_id = 0);
返回：关闭成功返回true，失败返回false
参数说明:
int fd 指定关闭的fd
int from_id fd来自于哪个Reactor（swoole-1.6以后已废弃该参数）
说明：
调用close关闭连接后，连接并不会马上关闭，因此不要在close之后立即写清理逻辑，而是应
该在onClose回调中处理
样例:
$serv->close($fd);


13. swoole_server::send
功能描述：向客户端发送数据
函数原型：
public function swoole_server::send(int $fd, string $data, int $from_id = 0);

返回：发送成功返回true，失败返回false
参数说明：
int fd 指定发送的fd
string data 发送的数据
int from_id fd来自于哪个Reactor
说明：
data，发送的数据，最大不得超过2M。send操作具有原子性，多个进程同时调用send向
同一个连接发送数据，不会发生数据混杂。
如果要发送超过2M的数据，建议将数据写入临时文件，然后通过sendfile接口直接发送文
件
UDP协议，send会直接在worker进程内发送数据包
向UDP客户端发送数据，必须要传入from_id
发送成功会返回true，如果连接已被关闭或发送失败会返回false
swoole-1.6以上版本不需要from_id
UDP协议使用fd保存客户端IP，from_id保存from_fd和port
UDP协议如果是在onReceive后立即向客户端发送数据，可以不传from_id
样例:
$serv->send($fd, 'hello world');


14. swoole_server::sendfile
功能描述：发送文件到TCP客户端连接
函数原型：
// 类成员函数
public function swoole_server::sendfile(int $fd, string $filename);

返回：发送成功返回true，失败返回false
参数说明：
int fd 指定发送的fd
string filename 发送的文件名
说明：
sendfile函数调用OS提供的sendfile系统调用，由操作系统直接读取文件并写入socket。
sendfile只有2次内存拷贝，使用此函数可以降低发送大量文件时操作系统的CPU和内存占
用。
样例:
$serv->sendfile($fd, __DIR__ . '/test.jpg');


15. swoole_server::connection_info
功能描述：获取连接的信息
函数原型：
// 类成员函数
public function swoole_server::connection_info(int $fd, int $from_id = 0)

返回：如果fd存在，返回一个数组，连接不存在或已关闭返回false
参数说明：
int fd 指定发送的fd
int from_id 来自于哪个Reactor
说明：
UDP socket调用该参数时必须传入from_id.
返回的结果如下：
名称 说明
int from_id 来自于哪个Reactor
int from_fd 来自哪个Server Socket
int from_port 来自哪个Server端口
int remote_port 客户端连接的端口
string remote_ip 客户端连接的ip
int connect_time 连接到Server的时间，单位秒
int last_time 最后一次发送数据的时间，单位秒
sendfile函数调用OS提供的sendfile系统调用，由操作系统直接读取文件并写入socket。
sendfile只有2次内存拷贝，使用此函数可以降低发送大量文件时操作系统的CPU和内存占
用。
样例:
$fdinfo = $serv->connection_info($fd);
$udp_client = $serv->connection($fd, $from_id);


16. swoole_server::connection_list
功能描述：遍历当前Server的全部客户端连接
函数原型：
// 类成员函数
public function swoole_server::connection_list(int $start_fd = 0, int $pagesize = 10);

返回：调用成功将返回一个数字索引数组，元素是取到的fd。数组会按从小到大排序。最后一
个fd作为新的start_fd再次尝试获取。
调用失败返回false
参数说明：
int start_fd 起始fd
int pagesize 每页取多少条，最大不得超过100.
说明：
connection_list仅可用于TCP，UDP服务器需要自行保存客户端信息
样例:
$start_fd = 0;
while (true) {
    $conn_list = $serv->connection_list($start_fd, 10);
    if ($conn_list === false) {
        echo "finish\n";
        break;
    }
    $start_fd = end($conn_list);
    var_dump($conn_list);
    foreach ($conn_list as $fd) {
        $serv->send($fd, 'broadcast');
    }
}


17. swoole_server::stats
功能描述：获取当前Server的活动TCP连接数，启动时间，accpet/close的总次数等信息。
函数原型：
// 类成员函数
public function swoole_server->stats();

返回：结果数组
参数说明：无
说明：
stats方法在1.7.5+后可用
名称 说明
int start_time 启动时间
int connection_num 当前的连接数
int accept_count accept总次数
int close_count close连接的总数
样例:
$status = $serv->stats();


18. swoole_server::task
功能描述：投递一个异步任务到task_worker池中
函数原型：
// 类成员函数
public function swoole_server::task(string $data, int $dst_worker_id = -1);

返回：调用成功返回task_worker_id，失败返回false
参数说明：
参数 说明
string data task数据
int dst_worker_id 指定投递给哪个task进程，默认随机投递
说明：
此功能用于将慢速的任务异步地去执行，调用task函数会立即返回，Worker进程可以继续处理新的请求。
函数会返回一个 $task_id  数字，表示此任务的ID
任务完成后，可以通过return(低于swoole-1.7.2版本使用finish函数)将结果通过onFinish回调返回给Worker进程。
发送的data必须为字符串，如果是数组或对象，请在业务代码中进行serialize处理，并在onTask/onFinish中进行unserialize。
data可以为二进制数据，最大长度为8K(超过8K可以使用临时文件共享)。字符串可以使用gzip进行压缩。
使用task必须为Server设置onTask和onFinish回调,并指定task_worker_num配置参数。
样例:
$task_id = $serv->task('some data');


19. swoole_server::taskwait
功能描述：投递一个同步任务到task_worker池中
函数原型：
// 类成员函数
public function swoole_server::taskwait(string $task_data, float $timeout = 0.5, int $dst_worker_id = -1);

返回：task执行的结果
参数说明：
string data task数据
float timeout 超时时间
int dst_worker_id 指定投递给哪个task进程，默认随机投递
说明：
taskwait与task方法作用相同，用于投递一个异步的任务到task进程池去执行。与task不同的
是taskwait是阻塞等待的，直到任务完成或者超时返回。
任务完成后，可以通过return直接返回结果
样例:
$task_id = $serv->taskwait('some data', 30);


20. swoole_server::finish
功能描述：传递Task结果数据给worker进程
函数原型：
// 类成员函数
public function swoole_server::finish(string $task_data);

返回：无
参数说明：
string data 结果数据
说明：
使用swoole_server::finish函数必须为Server设置onFinish回调函数。此函数只可用于TaskWorker进程的onTask回调中
swoole_server::finish是可选的。如果Worker进程不关心任务执行的结果，可以不调用此函数
此函数在swoole-1.7.2以上版本已废弃，使用return代替。
样例:
$serv->finish('result data');


21. swoole_server::heartbeat
功能描述：进行心跳检测
函数原型：
// 类成员函数
public function swoole_server::heartbeat(bool $if_close_connection = true);

返回：无
参数说明：
bool if_close_connection 是否关闭超时的连接，默认为true
说明：
该函数会主动发起一次检测，遍历全部连接，根据设置的heartbeat_check_interval和
heartbeat_idle_time参数，找到那些处于idle闲置状态的连接
swoole默认会直接关闭这些连接，heartbeat会返回这些连接的fd
如果if_close_connection为false，则heartbeat会返回这些idle连接的fd，但不会关闭这些连接
if_close_connection参数 在swoole-1.7.4以上版本可用
样例:
$serv->heartbeat();


22. swoole_get_mysqli_sock
功能描述：获取mysqli的socket文件描述符
函数原型：
// 公共函数
int swoole_get_mysqli_sock(mysqli $db)

返回：mysqli的fd
参数说明：
mysqli db mysqli的连接
说明：
可将mysql的socket增加到swoole中，执行异步MySQL查询。如果想要使用异步MySQL，需
要在编译swoole时制定--enable-async-mysql
swoole_get_mysqli_sock仅支持mysqlnd驱动
即使是异步MySQL也需要一个连接池，并发SQL必须有多个连接。
样例:
$db = new mysqli;
$db->connect('127.0.0.1', 'root', 'root', 'test');
$db->query('show tables', MYSQLI_ASYNC);
swoole_event_add(swoole_get_mysqli_sock($db), function ($db_sock) {
    global $db;
    $res = $db->reap_async_query();
    var_dump($res->fetch_all(MYSQLI_ASSOC));
    swoole_event_exit();
});


23. swoole_set_process_name
功能描述：设置进程的名称
函数原型：
// 公共函数
void swoole_set_process_name(string $name);

返回：无
参数说明：
string name 进程名称
说明：
修改进程名称后，通过ps命令看到的将不再是php your_file.php，而是设定的字符串
在swoole_server_create之前修改为manager进程名称 onStart调用时修改为主进程名称
onWorkerStart修改为worker进程名称
swoole_set_process_name存在兼容性问题，优先使用PHP内置的cli_set_process_title函数
样例:
swoole_set_process_name('swoole server');


24. swoole_version
功能描述：获取swoole扩展的版本号
函数原型：
// 公共函数
string swoole_version();

返回：swoole扩展的版本号
参数说明：无
说明：
样例:
echo swoole_version();


25. swoole_strerror
功能描述：将标准的Unix Errno错误码转换成错误信息
函数原型：
// 公共函数
string swoole_strerror(int $errno);

返回：转化后的错误信息
参数说明：
int errno errno错误码
说明：
样例:
echo swoole_strerror($errno);


26. swoole_errno
功能描述：获取最近一次系统调用的错误码
函数原型：
// 公共函数
int swoole_errno();

返回：最近一次系统调用的错误码
参数说明：无
说明：
错误码的值与操作系统有关。可是使用swoole_strerror将错误转换为错误信息。
样例:
echo swoole_strerror(swoole_errno());


27. swoole_get_local_ip
功能描述：此函数用于获取本机所有网络接口的IP地址
函数原型：
// 公共函数
array swoole_get_local_ip();

返回：以interface名称为key的关联数组
参数说明：无
说明：
目前只返回IPv4地址，返回结果会过滤掉本地loop地址127.0.0.1
返回结果样例array("eth0" => "192.168.1.100")； 样例:
var_dump(swoole_get_local_ip());


















































