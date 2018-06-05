
更新Table::incr和Table::decr支持有符号整型
兼容PHP-7.2版本
增加Event::cycle函数
修复Event::del函数无法移除标准输入句柄的问题
修复Task进程内定时器间隔小于Client接收超时时间，引起Client::recv死锁的问题
增加自动解析域名功能，异步客户端不再需要添加额外代码实现域名解析
增加ssl_host_name配置项，用于验证SSL/TLS主机合法性
使用dispatch_mode = 3时，当所有Worker为忙的状态时打印一条错误日志
增加端口迭代器，可遍历某个监听端口的所有连接
修复Table在非x86平台存在的内存对齐问题
修复BASE模式下max_request配置无效的问题
修复WebSocket服务器在某些客户端ping帧带有mask数据时回包错误的问题
修复HttpClient使用HEAD方法响应内容携带Content-Length导致卡死的问题
增加STREAM模块，Reactor、Worker、Task通信方式更灵活
增加request_slowlog_timeout配置，可记录慢请求日志
增加MySQL异步客户端对JSON格式的支持

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/5
 * Time: 14:45
 */