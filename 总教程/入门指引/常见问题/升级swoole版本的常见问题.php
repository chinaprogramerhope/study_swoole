可以使用pecl进行安装和升级

pecl upgrade swoole

也可以直接从github/pecl下载一个新版本，重新安装编译。

更新swoole版本，不需要卸载或者删除旧版本swoole，安装过程会覆盖旧版本
swoole编译安装后没有额外的文件，仅有一个swoole.so，如果是在其他机器编译好的二进制版本。直接互相覆盖swoole.so，即可实现版本切换
git clone拉取的代码，执行git pull更新代码后，务必要再次执行phpize、./configure、make clean、make install

<?php
/**
 * Created by PhpStorm.
 * User: ftd20
 * Date: 2018/6/6
 * Time: 8:11
 */