4种PHP回调函数风格

1. 匿名函数
<?php
$server->on('Request', function ($req, $resp) {
    echo 'hello world';
});
?>


2. 类静态方法
<?php
class A {
    static function test($req, $resp) {
        echo 'hello world';
    }
}
$server->on('Request', 'A::Test');
$server->on('Request', ['A', 'Test']);
?>


3. 函数
<?php
function my_onRequest($req, $resp) {
    echo 'hello world';
}
$server->on('Request', 'my_onRequest');
?>


4. 对象方法
<?php
class A1 {
    function test($req, $resp) {
        echo 'hello world';
    }
}
$object = new A();
$server->on('Request', [$object, 'test']);