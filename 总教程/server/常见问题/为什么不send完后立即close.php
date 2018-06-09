为什么不要send完后立即close

send完后立即close就是不安全的，无论是服务器端还是客户端。

send操作成功只是表示数据成功地写入到操作系统socket缓存区，不代表对端真的接收到了数据。究竟操作系统有没有发送成功，对方服务器是否收到，服务器端程序是否处理，都不没办法确切保证。

close后的逻辑请看下面的linger设置相关

这个逻辑和电话沟通是一个道理，A告诉B一个事情，A说完了就挂掉电话。那么B听到没有，A是不知道的。如果A说完事情，B说好，然后B挂掉电话，就绝对是安全的。
linger设置

一个socket在close时，如果发送缓冲区仍然有数据，操作系统底层会根据linger设置决定如何处理
struct linger {
    int l_onoff;
    int l_linger;
}


l_onoff = 0，close时立刻返回，底层会将未发送完的数据发送完成后再释放资源，也就是优雅的退出。
l_onoff != 0，l_linger = 0，close时会立刻返回，但不会发送未发送完成的数据，而是通过一个RST包强制的关闭socket描述符，也就是强制的退出。
l_onoff !=0，l_linger > 0， closes时不会立刻返回，内核会延迟一段时间，这个时间就由l_linger的值来决定。如果超时时间到达之前，发送完未发送的数据(包括FIN包)并得到另一端的确认，close会返回正确，socket描述符优雅性退出。否则close会直接返回错误值，未发送数据丢失，socket描述符被强制性退出。如果socket描述符被设置为非堵塞型，则close会直接返回值。

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/7
 * Time: 17:43
 */