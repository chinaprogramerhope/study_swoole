<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/15
 * Time: 15:11
 */

class svcMail {
    public function __construct() {
    }

    /**
     * 发送加密邮件
     * @param $param
     * @return bool
     */
    public function send_verify_mail($param) {
        return clsMail::send_verify_mail($param);
    }
}