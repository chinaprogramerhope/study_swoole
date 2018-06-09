open_eof_split

启用EOF自动分包。当设置open_eof_check后，底层检测数据是否以特定的字符串结尾来进行数据缓冲。但默认只截取收到数据的末尾部分做对比。这时候可能会产生多条数据合并在一个包内。

启用open_eof_split参数后，底层会从数据包中间查找EOF，并拆分数据包。onReceive每次仅收到一个以EOF字串结尾的数据包。

启用open_eof_split参数后，无论参数open_eof_check是否设置，open_eof_split都将生效。

open_eof_split在1.7.15以上版本可用

与 open_eof_check 的差异

open_eof_check 只检查接收数据的末尾是否为 EOF，因此它的性能最好，几乎没有消耗
open_eof_check 无法解决多个数据包合并的问题，比如同时发送两条带有 EOF 的数据，底层可能会一次全部返回
open_eof_split 会从左到右对数据进行逐字节对比，查找数据中的 EOF 进行分包，性能较差。但是每次只会返回一个数据包

[
    'open_eof_split' => true, // 打开EOF_SPLIT检测
    'package_eof' => "\r\n", // 设置EOF
]

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/7
 * Time: 10:46
 */