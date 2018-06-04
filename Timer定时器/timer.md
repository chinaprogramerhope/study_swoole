<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/4
 * Time: 12:06
 */

// function onTimer(int $timer_id, mixed $param = null); // 回调函数的原型
int swoole_timer_tick(int $ms, mixed $callback, mixed $param = null);
int swoole_server::tick(int $ms, mixed $callback, mixed $param = null);

// function onAfter(); // 回调函数的原型(不接受任何参数)
void swoole_timer_after(int $after_time_ms, mixed $callback_function);
void swoole_server::after(int $after_time_ms, mixed $callback_function);

// tick实例:
$str = 'say ';
$timer_id = swoole_timer_tick(1000, function ($timer_id, $params) use ($str) {
    echo $str . $params; // 输出'say hello'
}, 'hello');

// after实例
class Test {
    private $str = 'say hello';
    public function onAfter() {
        echo $this->str; // 输出 say hello
    }
}

$test = new Test();
swoole_timer_after(1000, [$test, 'onAfter']); // 成员变量

swoole_timer_after(2000, function () use ($test) { // 闭包
    $test->onAfter(); // 输出say hello
});