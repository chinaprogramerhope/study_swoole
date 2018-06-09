enable_unsafe_event

swoole在配置dispatch_mode=1或3后，因为系统无法保证onConnect/onReceive/onClose的顺序，默认关闭了onConnect/onClose事件。

如果应用程序需要onConnect/onClose事件，并且能接受顺序问题可能带来的安全风险，可以通过设置enable_unsafe_event为true，启用onConnect/onClose事件

enable_unsafe_event配置在1.7.18以上版本可用


<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/7
 * Time: 11:41
 */