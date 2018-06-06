task_tmpdir

设置task的数据临时目录，在swoole_server中，如果投递的数据超过8192字节，将启用临时文件来保存数据。这里的task_tmpdir就是用来设置临时文件保存的位置。

Swoole默认会使用/tmp目录存储task数据，如果你的Linux内核版本过低，/tmp目录不是内存文件系统，可以设置为 /dev/shm/

需要swoole-1.7.7+


<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/6
 * Time: 19:34
 */