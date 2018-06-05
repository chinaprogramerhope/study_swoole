
分布式
SwooleDistributed(推荐使用)

SwooleDistributed swoole 分布式全栈框架框架，它的特点：

优秀的框架（MVC）设计，丰富的支持极大加快开发速度
通过开启不同端口同时支持TCP和HTTP，WebSocket，同一逻辑处理不同协议
全异步支持，无需手动处理连接池，异步redis,异步mysql，mysql语法构建器，支持异步mysql事务,异步httpclient，效率出众
协程模式全支持，异步redis，异步mysql，异步httpclient，异步task，全部都提供了协程模式，业务代码摆脱处处回调的困扰（不是swoole2.0同样支持）
支持协程嵌套，支持协程内异常处理（和正常逻辑用法一样）
额外提供了protobuf完整RPC实例，轻松使用protobuf
天然分布式的支持，一台机器不够零配置，零代码修改完成高效分布式系统的搭建
完善详细的文档，还有实例代码，轻松掌握
线上项目打造维护，不断优化与改进
SwooleDistributed 2.0版本为微服务框架，拥有1.x版本全部功能，核心代码重构，协程效率更加优秀，具有服务注册中心，可以发布服务，监测服务状态，进程内的负载均衡，同时具有熔断，降级等保护服务的高级功能。服务健康状态，上下线服务自动感知，可以通过RPC或者HTTP与其他服务器进行交互。如果服务中断框架会自动将请求迁移到可用的服务上，尽量保证高可用性。通过版本管理还可以支持灰度发布。

swoole-task

swoole-task 是基于PHP swoole扩展开发的一个异步多进程任务处理框架，服务端和客户端通过http协议进行交互。

它适用于任务需要花费较长时间处理，而客户端不必关注任务执行结果的场景.比如数据清洗统计类的工作，报表生成类任务。
swoole-jobs

swoole-jobs 基于swoole的job调度组件，特性：

redis/rabbitmq/zeromq等任何一种做队列消息存储(目前只实现redis/rabbitmq)
利用swoole的process实现多进程管理，进程个数可配置，worker进程退出后会自动拉起
子进程循环次数可配置，防止业务代码内存泄漏
支持topic特性，不同的job绑定不同的topic
支持composer，可以跟任意框架集成
日志文件自动切割，默认最大100M，最多5个日志文件，防止日志刷满磁盘

DFS

DFS 分布式文件服务器，核心特性：

基于swoole和inotify实现分布式文件服务
采用协议包来实时同步文件、性能很高，采用sendfile传送文件，内存、cpu占有率很少
文件实时监控及监控子目录服务
自动断线重连服务
自动扫描本地已存在的文件目录实时同步服务

multiprocess

multiprocess 基于swoole的进程管理组件，可轻松让普通PHP脚本变守护进程和多进程执行：

基于swoole的脚本管理，用于多进程和守护进程管理
进程个数可配置，可以根据配置一次性执行多条命令
子进程异常退出时,自动重启
主进程异常退出时,子进程在干完手头活后退出(平滑退出)


<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/5
 * Time: 19:48
 */