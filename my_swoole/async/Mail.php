<?php

/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/8
 * Time: 15:24
 */

/**
 * 邮箱不可用 550 User has no permission的解决方法:
 * 当传入发送邮箱正确的用户名和密码时，总是收到到：550 User has no permission这样的错误，
 * 其实我们用代码发送邮件时相当于自定义客户端根据用户名和密码进行登录，然后使用SMTP服务发送邮件。但新注册的163邮件默认是不开启客户端授权验证的（对自定的邮箱大师客户端默认开启），
 * 因此登录总是会被拒绝，验证没有权限。解决办法是进入163邮箱，进入邮箱中心——客户端授权密码，选择开启, 设置完成后, 用授权码代替发件人邮箱密码
 */
//$port = 25; // SMTP服务器端口
//$user = 'phphack@163.com'; // 发件人邮箱
//$pass = 'han888'; // 发件人邮箱密码
//$host = 'smtp.163.com'; // SMTP服务器
//$from = 'phphack@163.com';
//$to = '18301805881@163.com';
//$body = 'hello world';
//$subject = '我是标题';
//
//$mailer = new Mail($host, $port, $user, $pass, true);
//$mailer->sendMail($from, $to, $subject, $body);

class Mail {
    private $host;
    private $port = 25;
    private $user;
    private $pass;
    private $debug = false;
    private $sock;

    public function __construct($host, $port, $user, $pass, $debug = false) {
        $this->host = $host;
        $this->port = $port;
        $this->user = base64_encode($user); // 用户名密码一定要使用base64编码才行
        $this->pass = base64_encode($pass);
        $this->debug = $debug;
        // socket连接
        $this->sock = fsockopen($this->host, $this->port);
        if (!$this->sock) {
            exit('出错啦');
        }
        // 读取smtp服务返回给我们的数据
        $response = fgets($this->sock);
        $this->debug($response);
        // 如果响应中有220返回码，说明我们连接成功了
        if (strstr($response, '220') === false) {
            exit('出错啦');
        }
    }

    // 发送SMTP指令，不同指令的返回码可能不同
    public function execCommand($cmd, $return_code) {
        fwrite($this->sock, $cmd);

        $response = fgets($this->sock);
        // 输出调试信息
        $this->debug('cmd:' . $cmd . ';response:' . $response);
        if (strstr($response, $return_code) === false) {
            return false;
        }
        return true;
    }

    public function sendMail($from, $to, $subject, $body) {
        // detail是邮件的内容，一定要严格按照下面的格式，这是协议规定的
        $detail = 'From:' . $from . "\r\n";
        $detail .= 'To:' . $to . "\r\n";
        $detail .= 'Subject:' . $subject . "\r\n";
        $detail .= 'Content-Type: Text/html;' . "\r\n";
        $detail .= 'charset=gb2312' . "\r\n\r\n";
        $detail .= $body;
        $this->execCommand("HELO " . $this->host . "\r\n", 250);
        $this->execCommand("AUTH LOGIN\r\n", 334);
        $this->execCommand($this->user . "\r\n", 334);
        $this->execCommand($this->pass . "\r\n", 235);
        $this->execCommand("MAIL FROM:<" . $from . ">\r\n", 250);
        $this->execCommand("RCPT TO:<" . $to . ">\r\n", 250);
        $this->execCommand("DATA\r\n", 354);
        $this->execCommand($detail . "\r\n.\r\n", 250);
        $this->execCommand("QUIT\r\n", 221);
    }

    public function debug($message) {
        if ($this->debug) {
            echo '<p>Debug:' . $message . PHP_EOL . '</p>';
        }
    }

    public function __destruct() {
        fclose($this->sock);
    }

}