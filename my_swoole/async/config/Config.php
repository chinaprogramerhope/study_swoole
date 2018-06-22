<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/11
 * Time: 10:30
 */
class Config {
    // 邮件
    const MAIL_SMTP_SERVER = 'smtp.exmail.qq.com';
    const MAIL_SMTP_USER = 'noreply@kangkanghui.com';
    const MAIL_SMTP_PASS = 'SCkjF#xj1237jKs%';

    // 短信
    const SMS_PROVIDER_URL = 'https://sms.yunpian.com/v2/sms/tpl_single_send.json'; // 短信服务商地址
    const SMS_PROVIDER_ID = '1916474'; // 短信模板ID
    const SMS_PROVIDER_MARKET_APIKEY = '4968d32fc54da13181879fadd234479d'; // 短信服务商私钥
    const SMS_PROVIDER_CAPTCHA_APIKEY = '4d27e0f6b9cd89de1e69c27ba7ced9bd'; // 专用注册登录验证码通道

    const SMS_SEND_IC_INTERVAL = 120; // 手机短信验证码发送间隔 - 秒
    const SMS_RESEND_IC_TIME = 60; // 手机短信验证码重发间隔 - 秒
    const SMS_IC_EXPIRED = 3600; // 手段短信验证码过期时间 - 秒

    // mysql
    const DB_DEFAULT_FETCH_MODE = PDO::FETCH_ASSOC;
    const DB_CONFIG = [
        'usercenter' => [
            'dsn' => 'mysql:host=127.0.0.1;dbname=usercenter_db',// 'dsn'=>'mysql:host=10.28.150.218;dbname=usercenter_db'
            'username' => 'root', // 'kkhfast01',
            'password' => 'password', // 'ufxjp3x#z&',
            'init_attributes' => [],
            'init_statements' => [
                'SET CHARACTER SET utf8mb4',
                'SET NAMES utf8mb4'
            ],
//            'default_fetch_mode' => Config::DB_DEFAULT_FETCH_MODE,
        ],

    ];

}

