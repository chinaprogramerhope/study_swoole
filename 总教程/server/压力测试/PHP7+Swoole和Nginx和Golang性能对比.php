PHP7+Swoole/Nginx/Golang性能对比
QPS对比

使用apache bench工具对Nginx静态页、Golang Http程序、PHP7+Swoole Http程序进行压力测试。在同一台机器上，进行并发100共100万次Http请求的基准测试中，QPS对比如下：
软件 	QPS 	软件版本
Nginx	164489.92	nginx/1.4.6 (Ubuntu)
Golang	166838.68	go version go1.5.2 linux/amd64
PHP7+Swoole	287104.12	swoole-1.7.22-alpha
Nginx-1.9.9	245058.70	nginx/1.9.9

注：Nginx-1.9.9的测试中，已关闭access_log，启用open_file_cache缓存静态文件到内存

更详细的测试细节
历史测试数据：Nginx/Golang/Swoole/Node.js的性能对比

测试环境

CPU：Intel® Core™ i5-4590 CPU @ 3.30GHz × 4
内存：16G
磁盘：128G SSD
操作系统：Ubuntu14.04 (Linux 3.16.0-55-generic)

压测工具

ab -c 100 -n 1000000 -k http://127.0.0.1:8080/
VHOST配置

server {
listen 80 default_server;
root /data/webroot;
index index.html;
}

测试页面

<h1>Hello World!</h1>

进程数量

Nginx开启了4个Worker进程

htf@htf-All-Series:~/soft/php-7.0.0$ ps aux|grep nginx
root      1221  0.0  0.0  86300  3304 ?        Ss   12月07   0:00 nginx: master process /usr/sbin/nginx
www-data  1222  0.0  0.0  87316  5440 ?        S    12月07   0:44 nginx: worker process
www-data  1223  0.0  0.0  87184  5388 ?        S    12月07   0:36 nginx: worker process
www-data  1224  0.0  0.0  87000  5520 ?        S    12月07   0:40 nginx: worker process
www-data  1225  0.0  0.0  87524  5516 ?        S    12月07   0:45 nginx: worker process

Golang
测试代码

package main

import (
"log"
"net/http"
"runtime"
)

func main() {
runtime.GOMAXPROCS(runtime.NumCPU() - 1)

http.HandleFunc("/", func(w http.ResponseWriter, r *http.Request) {
w.Header().Add("Last-Modified", "Thu, 18 Jun 2015 10:24:27 GMT")
w.Header().Add("Accept-Ranges", "bytes")
w.Header().Add("E-Tag", "55829c5b-17")
w.Header().Add("Server", "golang-http-server")
w.Write([]byte("<h1>\nHello world!\n</h1>\n"))
})

log.Printf("Go http Server listen on :8080")
log.Fatal(http.ListenAndServe(":8080", nil))
}

PHP7+Swoole

PHP7已启用OpCache加速器。
PHP版本

htf@htf-All-Series:~/soft/php-7.0.0$ php -v
PHP 7.0.0 (cli) (built: Dec 10 2015 14:36:26) ( NTS )
Copyright (c) 1997-2015 The PHP Group
Zend Engine v3.0.0, Copyright (c) 1998-2015 Zend Technologies
with Zend OPcache v7.0.6-dev, Copyright (c) 1999-2015, by Zend Technologies

测试代码
<?php
$http = new swoole_http_server('127.0.0.1', 9501, SWOOLE_BASE);

$http->set([
    'worker_num' => 4,
]);

$http->on('request', function ($request, swoole_http_response $response) {
    $response->header('Last-Modified', 'Thu 18 Jun 2015 10:24:27 GMT');
    $response->header('E-Tag', '55829c5b-17');
    $response->header('Accept-Ranges', 'bytes');
    $response->end();
});

$http->start();
?>