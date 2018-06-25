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

    public function sendMail($param) {
        return clsMail::send_verify_mail($param);
    }
}