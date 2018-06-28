<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/27
 * Time: 15:16
 *
 * 消息推送
 */

class svcPush {
    public function __construct() {
    }

    /**
     * 推送小程序模板消息
     */
    public function mp_tmp($param) {
        $need_param = [
            'touser',
            'template_id',
            'from_id',
            'data',
        ];

        if (check_param_set($need_param)) {

        }
    }
}