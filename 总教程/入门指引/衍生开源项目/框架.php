
框架

Tencent-TSF 腾讯公司推出的PHP协程框架，基于Swoole+PHP Generator实现Coroutine，可以像Golang一样用协程实现高并发服务器。
swoole_framework基于swoole扩展开发的通用后端服务框架，包含了内置PHP应用服务器、FastCGI、WebSocket、Web框架等丰富的功能特性
MixPHP 是一个基于 Swoole 的常驻内存型 PHP 高性能框架，围绕常驻内存的方式而设计，提供了 Web / Console 开发所需的众多开箱即用的组件，MixPHP 追求简单、实用主义，开发文档完善，试图让更多开发者以更低的学习成本享受到 Swoole 带来的高性能与全新的编程体验。
LaravelS 基于Swoole加速Laravel/Lumen，常驻内存，内置HTTP/Websocket Server，支持TCP/UDP Server，异步的事件监听，异步任务队列，毫秒级定时任务，平滑Reload，与Nginx配合搭建高可用分布式服务器群，开箱即用。
zphp一个极轻的的，专用于游戏(社交，网页，移动)的服务器端开发框架.提供高性能实时通信方案。zphp使用swoole作为底层网络通信的框架。
zapi 基于swoole+generator的http api异步非阻塞轻量级框架,内置mysql、redis、memcached、mongodb全套异步客户端的连接池，内置http异步客户端，近乎同步的写法，却是异步的调用，性能强悍
zhttp 基于swoole+generator的异步非阻塞轻量级web框架,内置mysql、redis、memcached、mongodb全套异步客户端的连接池，内置http异步客户端，近乎同步的写法，却是异步的调用，性能强悍
swoole-yaf 结合PHP的Yaf框架和Swoole扩展的高性能PHP Web框架
Swoole-Yaf 将Yaf框架和Swoole扩展提供的HttpServer结合在一起，server和框架高度结合形成超高性能的组合
ciswoole CodeIgniter 2.2 with Swoole_Http_Server
owl-mvc 基于 swoole_http_server 的一套PHP MVC框架
hprose/hprose-php 高性能远程对象调用服务，PHP 版本底层使用 swoole 实现了 http，https，tcp，tcp6，websocket， unix socket 服务器和 tcp，tcp6，unix socket 客户端。
yiiSwoole Yii 1.1.16 with Swoole Http_Server，In high-concurrency situations,will be better than php-fpm
Dora-RPC 是基础swoole实现的轻量级高性能RPC框架，支持同步/异步调用，拥有有多任务并发及长链接维持特性
Blink 是一个为构建 “long running” 服务而生的 Web 微型高性能框架，它为构建 Web 应用程序提供简洁优雅的API，尽量的减轻我们的常规开发工作
swPromise 基于swoole的PHP promise框架
Aurora 是一个建立在 Lightning 之上的高性能高并发框架，为追求极限性能而打造，底层由Phalcon + Swoole组合驱动，适用于需要支持高并发的场景，如API 接口、微服务等。
Group 轻量级框架。基于swoole实现了定时任务，分布式任务队列，异步多进程服务(模拟map-reduce)，结合hprose的rpc服务。
Group-co 优雅的异步协程框架,支持服务化搭建高并发httpserver，支持分布式使用，详情请戳链接。
FastD FastD 是一个支持 Swoole 的轻量级 Web 开发框架，可适用于对性能有要求的 API 场景，并且灵活的扩展性可以让开发者们更容易地建造自己的服务 (基于Swoole)
Yii2-Swoole 支持基于Yii2框架运行于Swoole中,同时可以很简单的支持Swool 1.0与2.0协程,自带mysql,redis连接池,可以使用Yii2的全栈框架来开发HTTP,WebSocket等网络服务。
ultraman 结合PHP的Yaf框架和Swoole扩展的高性能PHP 封装成composer 及其容易上手
Lawoole 基于 Laravel 和 Swoole 的高性能 PHP 框架。借助 Swoole 的高性能特点，弥补了 Laravel 的性能缺陷。在大幅提升程序运行速度的情况下，能够使用到绝大部分 Laravel 中优秀的特性。在 Lawoole 中，你可以拥有与 Laravel 一致的开发体验，编写那些富有创造力的代码。

Swoft：基于2.0原生协程的高性能PHP微服务框架

https://github.com/swoft-cloud/swoft

首个基于 Swoole 原生协程的新时代 PHP 高性能协程全栈框架，内置协程网络服务器及常用的协程客户端，常驻内存，不依赖传统的 PHP-FPM，全异步非阻塞 IO 实现，以类似于同步客户端的写法实现异步客户端的使用，没有复杂的异步回调，没有繁琐的 yield，有类似 Go 语言的协程、灵活的注解、强大的全局依赖注入容器、完善的服务治理、灵活强大的 AOP、标准的 PSR 规范实现等等，可以用于构建高性能的Web系统、API、中间件、基础服务等等。

基于 Swoole 扩展
内置协程 HTTP, TCP, WebSocket 网络服务器
强大的 AOP (面向切面编程)
灵活完善的注解功能
全局的依赖注入容器
基于 PSR-7 的 HTTP 消息实现
基于 PSR-14 的事件管理器
基于 PSR-15 的中间件
基于 PSR-16 的缓存设计
可扩展的高性能 RPC
完善的服务治理，熔断，降级，负载，注册与发现
数据库 ORM
通用连接池
协程 Mysql, Redis, RPC, HTTP 客户端
协程和同步阻塞客户端无缝自动切换
协程、异步任务投递
自定义用户进程
RESTful 支持
国际化(i18n)支持
高性能路由
快速灵活的参数验证器
别名机制
强大的日志系统
跨平台热更新自动 Reload

MyQEE 服务器类库

https://github.com/myqee/server

MyQEE 服务器类库是一套基础服务器类库，让你可以摒弃 Swoole 传统的 On 回调写法，在不损失性能和功能的前提下实现功能和服务的对象抽象化，实现全新的编程体验，让代码清晰有条理。特别适合复杂的应用服务器，不管是你要在一起集成 Http 还是 Tcp 还是 WebSocket 服务，解决了使用 Swoole 开发复杂服务器的痛点。另外，通过本类库使得php新手使用 swoole 会变得更轻松不再那么迷茫（比如多端口绑定、任务进程和工作进程的关系和功能）。

MyQEE服务器类库特性：

对象抽象化：为每个 Worker、TaskWorker、以及端口监听分配一个对象，业务层自己实现相应功能即可，让开发代码清晰有条理；
填补了 Swoole 服务器开发中的很多坑；
支持大文件、断点、分片上传功能并完美融合服务（swoole_http_server 不支持大文件上传，会有内存问题，也存在一些细节上的bug）；
易于使用的多重混合服务器端口监听方案；
解决服务器选型痛点；
解决代码混乱的痛点；
解决新手搞不清 Worker、TaskWorker 和多端口之间的功能、关系、使用特性；
更加简单易用的热更新方案；
连接池、资源池；
更多的周边功能特性；

zys高性能服务框架

https://github.com/qieangel2013/zys 基于Yaf和Swoole的i高性能Service框架，核心特性：

基于swoole提供分布式服务器通讯服务
基于thrift提供rpc远程调用服务
基于HTML5提供在线网络直播平台服务
基于swoole提供同步异步数据库连接池服务
基于swoole提供异步任务服务器投递任务服务
基于vmstat提供服务器硬件实时监控服务
基于yac、yaconf提供共享数据、配置服务
基于zqf提供高并发计数器、红包、二维码服务
很好的支持网页版console的shell服务
基于hprose提供rpc远程调用、推送等服务

WebWorker-swoole高性能http服务框架

https://github.com/xtgxiso/WebWorker-swoole 基于Swoole2.0的协程特性写的框架，核心特性：

实现了简单路由功能的小巧框架,便于开发者使用和扩展,非常具有灵活性
相比php-fpm或mod_php的方式性能有几十倍左右的提升
可设置自动加载目录加载目录下的所有php文件(仅一级不支持递归)
自定义404响应
支持中间件
redis支持原生同步和协程版本，只需要一个配置参数即可
mysql支持原生同步和协程版本，只需要一个配置参数即可

easySwoole 高性能HTTP框架

easySwoole 专为API而生，是一款常驻内存化的PHP开发框架，摆脱传统PHP运行模式在进程唤起和文件加载上带来的性能损失，自带服务器功能，无需依赖Apache或Nginx运行。在web服务器模式下，支持多层级(组模式)控制器访问与多种事件回调,高度封装了Swoole Server 而依旧维持Swoole Server原有特性，支持在 Server 中监听自定义的TCP、UDP协议，让开发者可以最低的学习成本和精力，编写出多进程，可定时，可异步，高可用的应用服务。
项目地址 : https://www.easyswoole.com/


<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/5
 * Time: 19:36
 */