开发框架

Swoft 首个基于 Swoole 原生协程的新时代 PHP 高性能协程全栈框架，内置协程网络服务器及常用的协程客户端，常驻内存，不依赖传统的 PHP-FPM，全异步非阻塞 IO 实现，以类似于同步客户端的写法实现异步客户端的使用，没有复杂的异步回调，没有繁琐的 yield, 有类似 Go 语言的协程、灵活的注解、强大的全局依赖注入容器、完善的服务治理、灵活强大的 AOP、标准的 PSR 规范实现等等，可以用于构建高性能的Web系统、API、中间件、基础服务等等。
EasySwoole EasySwoole 是一款基于Swoole Server 开发的常驻内存型PHP框架，专为API而生，摆脱传统PHP运行模式在进程唤起和文件加载上带来的性能损失。EasySwoole 高度封装了Swoole Server 而依旧维持Swoole Server 原有特性，支持同时混合监听HTTP、自定义TCP、UDP协议，让开发者以最低的学习成本和精力编写出多进程，可异步，高可用的应用服务。
SwooleDistributed SD框架全称SwooleDistributed，从名称上看一个是Swoole一个是Distributed，他是基于Swoole扩展的可以分布式部署的应用服务器框架。 借助于PHP的高效开发环境，Swoole的高性能异步网络通信引擎，以及其他的高可用的扩展和工具，SD框架提供给广大开发者一个稳定的高效的而且功能强大的应用服务器框架。
MixPHP 是一个基于 Swoole 的常驻内存型 PHP 高性能框架，围绕常驻内存的方式而设计，提供了 Web / Console 开发所需的众多开箱即用的组件，MixPHP 追求简单、实用主义，开发文档完善，试图让更多开发者以更低的学习成本享受到 Swoole 带来的高性能与全新的编程体验。
Swoolefy 基于swoole扩展实现的轻量级高性能的API和Web应用服务框架，高度封装了http，websocket，udp服务器，以及基于tcp实现可扩展，自定义协议的rpc服务器，同时支持composer包方式快速部署项目。基于易用，swoolefy抽象Event事件处理类，实现与底层的回调的解耦，专注逻辑业务，支持同步|异步调用，内置view、Log、session、mysql、redis、memcached、mongodb，mailer等常用组件。
Lawoole 基于 Laravel 和 Swoole 的高性能 PHP 框架。借助 Swoole 的高性能特点，弥补了 Laravel 的性能缺陷。在大幅提升程序运行速度的情况下，能够使用到绝大部分 Laravel 中优秀的特性。在 Lawoole 中，你可以拥有与 Laravel 一致的开发体验，编写那些富有创造力的代码。

服务器

MyQEE-Server 将swoole服务和功能对象抽象化，为每个 Worker、Task、多端口分配一个对象，带来全新的编程体验让代码清晰有条理，适合多端口以及Http、WebSocket、Tcp混合的应用服务器开发，支持创建大文件、断点、分片上传的Http服务器
EPServer 高性能TCP服务器框架，底层基于swoole扩展
WebSocket & WebIM
Upload-Server 基于swoole扩展开发的，高性能TCP文件上传服务器，是全异步非阻塞多进程的。可同时支持数万个TCP客户端连接，上传文件。
php-queue PHP开发的磁盘存储消息队列服务，基于leveldb和swoole，在4核机器上处理能力可以达到2.5W/s
PtWebserver PtWebserver 基于php swoole 扩展的高性能web 服务器。应用对象常驻内存，不用重复创建对象，提高响应时间与性能
swoole-jobs swoole-jobs,基于swoole的job调度组件,支持composer，可以跟任意框架集成

应用项目

zchat 基于zphp框架和swoole扩展开发的PHP网页即时聊天室系统。
PHPWebIM 基于swoole扩展开发的websocket网页聊天系统
swoole_flash_game 基于swoole扩展开发的flash游戏，可与服务器实时交互
statistics 一个运用php与swoole实现的统计监控系统
swoole-bot基于swoole实现的微信机器人，依赖vbot和微信网页版的功能，帮助管理微信群/聊天/踢人等
vbot 基于web api打造的微信机器人，可以通过配置开启 swoole，便可打造自己的个性化微信客户端

微服务框架

SwooleDistributed 2.0版本为微服务框架，具有服务注册中心，可以发布服务，监测服务状态，进程内的负载均衡，同时具有熔断，降级等保护服务的高级功能。服务健康状态，上下线服务自动感知，可以通过RPC或者HTTP与其他服务器进行交互。如果服务中断框架会自动将请求迁移到可用的服务上，尽量保证高可用性，性能更是优秀。通过版本管理还可以支持灰度发布。
Group-Co 优雅的异步协程框架，并内置分布式服务化体系，可以根据自身架构需求自定义实现服务的上下线，监控，发布等等。

HTTP 应用框架

zhttp 基于swoole+generator的异步非阻塞轻量级web框架（api和web皆可）,内置mysql、redis、memcached、mongodb全套异步客户端的连接池，内置http异步客户端，近乎同步的写法，却是异步的调用，性能强悍

FastD 适用于对性能有要求的 API 场景，并且灵活的扩展性可以让开发者们更容易地建造自己的服务。支持HTTP、TCP、UDP、WebSocket，简单，易用。

LaravelS 基于Swoole加速Laravel/Lumen，常驻内存，内置HTTP/Websocket Server，支持TCP/UDP Server，异步的事件监听，异步任务队列，毫秒级定时任务，平滑Reload，与Nginx配合搭建高可用分布式服务器群，开箱即用。

Yii2-Swoole 支持基于Yii2框架运行于Swoole中,同时可以很简单的支持Swool 1.0与2.0协程,自带mysql,redis连接池,可以使用Yii2的全栈框架来开发HTTP,WebSocket等网络服务。

如果您有基于swoole开发新的开源项目，可以联系我们。将你的开源项目加入swoole官方推荐列表中

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/5
 * Time: 18:42
 */