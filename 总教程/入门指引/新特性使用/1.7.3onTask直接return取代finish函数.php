1.7.3之后，task/finish可以支持超大包了。发送的数据不再限制为8192。
另外swoole_server->finish函数已经废弃，采用直接在onTask回调函数中return字符串的方式

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/5
 * Time: 16:05
 */
function onTask($serv, $task_id, $from_id, $data) {
    // your code
    // 1.7.3之前, 是$serv->finish('result');
    return 'result.';
}