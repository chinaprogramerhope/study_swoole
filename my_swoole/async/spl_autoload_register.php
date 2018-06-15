<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/11
 * Time: 10:35
 */
spl_autoload_register(function ($class) {
    require_once $class . '.php';
});