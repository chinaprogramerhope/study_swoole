<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/11
 * Time: 10:25
 */
class Mail2 {
    public static function send_verify_mail($param) {
        // 参数检查  $to, $subject, $body, $cc = null, $reply = null
        if (!isset($param['to']) || !isset($param['subject']) || !isset($param['body'])) {
            // todo error
            return false;
        }
        $to = $param['to'];
        $subject = $param['subject'];
        $body = $param['body'];
        $cc = isset($param['cc']) ? $param['cc'] : null;
        $reply = isset($param['reply']) ? $param['reply'] : null;

//        $csmtp = new Mail_Csmtp(APF::get_instance()->get_config('smtp_server'), 587);
        $csmtp = new Mail_Csmtp(Config::SMTP_SERVER, 587);

        $start_tls_ret = $csmtp->start_tls();
        if ($start_tls_ret === false) {
//            Logger::info(__METHOD__ . ' start_tls fail');
            return false;
        }

//        $login_ret = $csmtp->login(APF::get_instance()->get_config('smtp_user'), APF::get_instance()->get_config('smtp_pass'));
        $login_ret = $csmtp->login(Config::SMTP_USER, Config::SMTP_PASS);
        if ($login_ret !== true) {
//            Logger::info(__METHOD__ . ' login fail');
            return false;
        }

        $send_ret = $csmtp->send($to, $subject, $body, $cc, $reply);
        if ($send_ret !== true) {
//            Logger::info(__METHOD__ . ' send fail');
            return false;
        }

        return true;
    }
}

/*
简易的SMTP发送邮件类，代码比较少，有助于学习SMTP协议，
可以带附件，支持需要验证的SMTP服务器（目前的SMTP基本都需要验证）
使用方法:

1. 初始化：连接到服务器（默认是QQ邮箱）
$mail = new cs_smtp('smtp.qq.com',25)
if ($mail->errstr) //如果连接出错
die($mail->errstr;
2. 登录到服务器验证,如果失败返回FALSE;
if (!$mail->login('USERNAME','PASSWORD'))
die($mail->errstr;
3. 添加附件如果不指定name自动从指定的文件中取文件名
$mail->AddFile($file,$name) //服务器上的文件，可以指定文件名;
4. 发送邮件
$mail->send($to,$subject,$body)
$to 收件人，多个使用','分隔
$subject 邮件主题，可选。
$body  邮件主体内容，可选
*/

class Mail_Csmtp {
    private $CRLF = "\r\n";
    private $from;
    private $smtp = null;
    private $attach = array();
    public $debug = false;//调试开关
    public $errstr = '';

    function __construct($host = 'smtp.qq.com', $port = 25) {
        if (empty($host))
            die('SMTP服务器未指定!');
        $this->smtp = fsockopen($host, $port, $errno, $errstr, 5);
        if (empty($this->smtp)) {
            $this->errstr = '错误' . $errno . ':' . $errstr;
            return $this->errstr;
        }
        $this->smtp_log(fread($this->smtp, 515));
        if (intval($this->smtp_cmd('EHLO ' . $host)) != 250 && intval($this->smtp_cmd('HELO ' . $host)))
            return $this->errstr = '服务器不支持！';
        $this->errstr = '';
    }

    private function AttachURL($url, $name) {
        $info = parse_url($url);
        isset($info['port']) || $info['port'] = 80;
        isset($info['path']) || $info['path'] = '/';
        isset($info['query']) || $info['query'] = '';
        $down = fsockopen($info['host'], $info['port'], $errno, $errstr, 5);
        if (!$down)
            return false;
        $out = "GET " . $info['path'] . '?' . $info['query'] . " HTTP/1.1\r\n";
        $out .= "Host: " . $info['host'] . "\r\n";
        $out .= "Connection: Close\r\n\r\n";
        fwrite($down, $out);
        $filesize = 0;
        while (!feof($down)) {
            $a = fgets($down, 515);
            if ($a == "\r\n")
                break;
            $a = explode(':', $a);
            if (strcasecmp($a[0], 'Content-Length') == 0)
                $filesize = intval($a[1]);
        }
        $sendsize = 0;
        echo "TotalSize: " . $filesize . "\r\n";
        $i = 0;
        while (!feof($down)) {
            $data = fread($down, 0x2000);
            $sendsize += strlen($data);
            if ($filesize) {
                echo "$i Send:" . $sendsize . "\r";
                ob_flush();
                flush();
            }
            ++$i;
            fwrite($this->smtp, chunk_split(base64_encode($data)));
        }
        echo "\r\n";
        fclose($down);
        return ($filesize > 0) ? $filesize == $sendsize : true;
    }

    function __destruct() {
        if ($this->smtp)
            $this->smtp_cmd('QUIT');//发送退出命令
    }

    private function smtp_log($msg)//即时输出调试使用
    {
        if ($this->debug == false)
            return;
        echo $msg . "\r\n";
        ob_flush();
        flush();
    }

    function reset() {
        $this->attach = null;
        $this->smtp_cmd('RSET');
    }

    function smtp_cmd($msg)//SMTP命令发送和收收
    {
        fputs($this->smtp, $msg . $this->CRLF);
        $this->smtp_log('SEND:' . substr($msg, 0, 80));
        $res = fread($this->smtp, 515);
        $this->smtp_log($res);
        $this->errstr = $res;
        return $res;
    }

    function AddURL($url, $name) {
        $this->attach[$name] = $url;
    }

    function AddFile($file, $name = '')//添加文件附件
    {
        if (file_exists($file)) {
            if (!empty($name))
                return $this->attach[$name] = $file;
            $fn = pathinfo($file);
            return $this->attach[$fn['basename']] = $file;
        }
        return false;
    }

    function send($to, $subject = '', $body = '', $cc = null, $reply = null) {
        $this->smtp_cmd("MAIL FROM: <" . $this->from . '>');
        $mailto = explode(',', $to);
        foreach ($mailto as $email_to) {
            $this->smtp_cmd("RCPT TO: <" . $email_to . ">");
        }
        if (isset($cc)) {
            $mailcc = explode(',', $cc);
            foreach ($mailcc as $email_cc) {
                $this->smtp_cmd("RCPT CC: <" . $email_cc . ">");
            }
        }
        if (intval($this->smtp_cmd("DATA")) != 354)//正确的返回必须是354
            return false;
        $subject = "=?UTF-8?B?" . base64_encode($subject) . "?=";
        fwrite($this->smtp, "Subject: $subject\n");
        //fwrite($this->smtp,"Subject: $subject\n");
        $boundary = uniqid("--BY_CHENALL_", true);
        $headers = "MIME-Version: 1.0" . $this->CRLF;
        foreach ($mailto as $email_to) {
            $headers .= "To: <" . $email_to . ">" . $this->CRLF;
        }
        if (isset($cc)) {
            foreach ($mailcc as $email_cc) {
                $headers .= "Cc: <" . $email_cc . ">" . $this->CRLF;
            }
        }
        if (isset($reply) || !empty($reply)) {
            $headers .= "Reply-To: <" . $reply . ">" . $this->CRLF;
        }
        //$fjr = "kangkanghui";
        $fjr = "青苹果";
        $fjr = "=?UTF-8?B?" . base64_encode($fjr) . "?=";
        $headers .= "From: " . $fjr . "<" . $this->from . ">" . $this->CRLF;
        $headers .= "Content-type: multipart/mixed; boundary= $boundary\n\n" . $this->CRLF;//headers结束要至少两个换行
        fwrite($this->smtp, $headers);

        $msg = "--$boundary\nContent-Type: text/html;charset=\"utf-8\"\nContent-Transfer-Encoding: base64\n\n";
        $msg .= chunk_split(base64_encode($body));
        fwrite($this->smtp, $msg);
        $files = '';
        $errinfo = '';
        foreach ($this->attach as $name => $file) {
            $files .= $name;
            $msg = "--$boundary\n--$boundary\n";
            $msg .= "Content-Type: application/octet-stream; name=\"" . $name . "\"\n";
            $msg .= "Content-Disposition: attachment; filename=\"" . $name . "\"\n";
            $msg .= "Content-transfer-encoding: base64\n\n";
            fwrite($this->smtp, $msg);
            if (substr($file, 4, 1) == ':')//URL like http:///file://
            {
                if (!$this->AttachURL($file, $name))
                    $errinfo .= '文件下载错误:' . $name . ",文件可能是错误的\r\n$file";
            } else
                fwrite($this->smtp, chunk_split(base64_encode(file_get_contents($file))));//使用BASE64编码，再用chunk_split大卸八块（每行76个字符）
        }
        if (!empty($errinfo)) {
            $msg = "--$boundary\n--$boundary\n";
            $msg .= "Content-Type: application/octet-stream; name=Error.log\n";
            $msg .= "Content-Disposition: attachment; filename=Error.log\n";
            $msg .= "Content-transfer-encoding: base64\n\n";
            fwrite($this->smtp, $msg);
            fwrite($this->smtp, chunk_split(base64_encode($errinfo)));
        }
        return intval($this->smtp_cmd("--$boundary--\n\r\n.")) == 250;//结束DATA发送，服务器会返回执行结果，如果代码不是250则出错。
    }

    function login($su, $sp) {
        if (empty($this->smtp))
            return false;
        $res = $this->smtp_cmd("AUTH LOGIN");
        if (intval($res) > 400)
            return !$this->errstr = $res;
        $res = $this->smtp_cmd(base64_encode($su));
        if (intval($res) > 400)
            return !$this->errstr = $res;
        $res = $this->smtp_cmd(base64_encode($sp));
        if (intval($res) > 400)
            return !$this->errstr = $res;
        $this->from = $su;
        return true;
    }

    public function start_tls() {
        if (empty($this->smtp)) {
            return false;
        }

        $start_tls_ret = $this->smtp_cmd('STARTTLS');
        if (strpos($start_tls_ret, '220') === false) {
            return false;
        }

        $cry_ret = stream_socket_enable_crypto($this->smtp, true, STREAM_CRYPTO_METHOD_SSLv23_CLIENT);
        if ($cry_ret === false) { //todo 0
            return false;
        }

        return true;
    }
}
