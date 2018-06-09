open_length_check

打开包长检测特性。包长检测提供了固定包头+包体这种格式协议的解析。启用后，可以保证Worker进程onReceive每次都会收到一个完整的数据包。

长度协议提供了3个选项来控制协议细节。
package_length_type

包头中某个字段作为包长度的值，底层支持了10种长度类型。请参考 package_length_type
package_body_offset

从第几个字节开始计算长度，一般有2种情况：

length的值包含了整个包（包头+包体），package_body_offset 为0
包头长度为N字节，length的值不包含包头，仅包含包体，package_body_offset设置为N

package_length_offset

length长度值在包头的第几个字节。

示例:
struct {
    uint32_t type;
    uint32_t uid;
    uint32_t length;
    uint32_t serid;
    char body[0];
}

以上通信协议的设计中，包头长度为4个整型，16字节，length长度值在第3个整型处。因此package_length_offset设置为8，0-3字节为type，4-7字节为uid，8-11字节为length，12-15字节为serid。



<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/7
 * Time: 11:01
 */
$server->set([
    'open_length_check' => true,
    'package_max_length' => 81920,
    'package_length_type' => 'N',
    'package_length_offset' => 8,
    'package_body_offset' => 16,
]);