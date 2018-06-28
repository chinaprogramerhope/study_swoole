<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/27
 * Time: 18:05
 */

function check_param_set($need_param) {
    foreach ($need_param as $v) {
        if (!isset($v)) {
            return false;
        }
    }

    return true;
}