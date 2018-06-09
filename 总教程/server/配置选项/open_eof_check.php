open_eof_check

[
    'open_eof_check' => true, // 打开eof检测
    'package_eof' => "\r\n", // 设置eof
]

常见的Memcache/SMTP/POP等协议都是以\r\n结束的，就可以使用此配置。开启后可以保证Worker进程一次性总是收到一个或者多个完整的数据包。

EOF检测不会从数据中间查找eof字符串，所以Worker进程可能会同时收到多个数据包，需要在应用层代码中自行explode("\r\n", $data) 来拆分数据包
1.7.15版本增加了open_eof_split，支持从数据中查找EOF，并切分数据

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/7
 * Time: 10:45
 */