PHP7+Swoole开启opcache，运行时出现zend_mm_heap corrupted。这个问题的主要原因是PHP7增加了一个优化项，如果PHP代码中一个数组只声明一次，并且没有对数据进行修改操作。PHP7会将此数组转为immutable类型，此数组仅作为只读。

PHP7的解析器只能识别PHP程序中的数组操作行为，但是扩展层对数组的修改无法识别。而Swoole的Server->set等方法可能会修改传入的数组，导致出现内存错误。
Immutable数组

$array = array(
'worker_num' => 1,
'log_file' => 'swoole.log',
);

非Immutable数组

$array = array(
'worker_num' => 1,
'log_file' => 'swoole.log',
);
//有修改行为，PHP7不会优化此数组为只读
$array['daemonize'] = true;

未启用opcache时，Immutable数组即使被修改了，只要PHP代码中没有再操作此数据则不会出现内存错误。一旦开启opcache，Immutable数组会被转存到SharedMemory并进行持久化。这时Swoole修改此数组会使ZendVM发生内存错误，抛出zend_mm_heap corrupted错误。

zval *zsetting = sw_zend_read_property(swoole_server_class_entry_ptr, getThis(), ZEND_STRL("setting"), 1);
if (zsetting == NULL || ZVAL_IS_NULL(zsetting))
{
SW_MAKE_STD_ZVAL(zsetting);
array_init(zsetting);
zend_update_property(swoole_server_class_entry_ptr, getThis(), ZEND_STRL("setting"), zsetting);
}

add_assoc_bool(zsetting, "open_http_protocol", 1);
add_assoc_bool(zsetting, "open_mqtt_protocol", 0);
add_assoc_bool(zsetting, "open_eof_check", 0);
add_assoc_bool(zsetting, "open_length_check", 0);

底层修复

1.9.2版本增加了一个php_swoole_array_separate的宏，用于将Immutable数组分离并重新构建一个非Immutable数组，底层就可以修改这个数组的值了。实现代码：

#define php_swoole_array_separate(arr)       zval *_new_##arr;\
SW_MAKE_STD_ZVAL(_new_##arr);\
array_init(_new_##arr);\
sw_php_array_merge(Z_ARRVAL_P(_new_##arr), Z_ARRVAL_P(arr));\
arr = _new_##arr;

在C扩展中如果需要修改PHP代码传入的数组，必须调用php_swoole_array_separate将数组分离。

php_swoole_array_separate(zset);

解决办法

升级到最新版本的swoole，或者关闭opcache扩展，可修改php.ini加入配置项：

opcache.enable_cli = off

<?php
/**
 * Created by PhpStorm.
 * User: ftd20
 * Date: 2018/6/6
 * Time: 8:31
 */