<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/1
 * Time: 17:14
 */
class Test {
    public function onReceive(swoole_server $serv, $fd, $from_id, $data) {
        echo $fd . ':' . $data;
        $param = [
            'fd' => $fd
        ];
        $serv->task(json_encode($param));
    }

    public function onTask($serv, $task_id, $from_id, $data) {
        $fd = json_decode($data, true)['fd'];
        $serv->send($fd, "ddd");
    }
}