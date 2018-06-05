增加Atomic\Long，支持64位有符号长整型
优化底层GlobalMemory实现，支持创建无限个数的Atomic、Lock、Table
禁止序列化Swoole各模块对象
修复Http\Client::download第4个参数无效的问题
修复FreeBSD平台下编译报错的问题
修复MacOS平台下sendfile存在5秒延迟的问题
增加Process::setTimeout

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/5
 * Time: 14:43
 */