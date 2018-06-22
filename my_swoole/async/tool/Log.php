<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/21
 * Time: 16:29
 */

class Log {
    // 调式日志
    public static function debug($content) {

    }

    // 运行日志, 打印感兴趣或重要信息, 勿滥用
    public static function info($content) {

    }

    // 潜在错误, 不是错误信息, 但有必要提示
    public static function warn($content) {

    }

    // 错误日志, 出现这种错误时, 不影响系统运行
    public static function error($content) {

    }

    // 重大错误, 出现这种错误时吗, 须停止程序
    public static function fatal($content) {

    }
}