tcp_defer_accept

启用tcp_defer_accept特性，可以设置为一个数值，表示当一个TCP连接有数据发送时才触发accept。
tcp_defer_accept => 5

启用tcp_defer_accept特性后，accept和onConnect对应的时间会发生变化。如果设置为5秒：

客户端连接到服务器后不会立即触发accept
在5秒内客户端发送数据，此时会同时顺序触发accept/onConnect/onReceive
在5秒内客户端没有发送任何数据，此时会触发accept/onConnect

tcp_defer_accept的可以提高Accept操作的效率

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/7
 * Time: 11:19
 */