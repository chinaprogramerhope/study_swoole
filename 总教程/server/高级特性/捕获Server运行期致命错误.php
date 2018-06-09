捕获Server运行期致命错误

Server运行期一旦发生致命错误，那客户端连接将无法得到回应。如Web服务器，如果有致命错误应当向客户端发送Http 500 错误信息。

在PHP中可以通过register_shutdown_function + error_get_last 2个函数来捕获致命错误，并将错误信息发送给客户端连接。具体代码示例如下：

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/7
 * Time: 16:28
 */
register_shutdown_function('handleFatal');
function handleFatal() {
    $error = error_get_last();
    if (isset($error['type'])) {
        switch ($error['type']) {
            case E_ERROR:
            case E_PARSE:
            case E_CODE_ERROR:
            case E_COMPILE_ERROR:
                $message = $error['message'];
                $file = $error['file'];
                $line = $error['line'];
                $log = "$message ($file:$line)\nStack trace:\n";
                $trace = debug_backtrace();
                foreach ($trace as $i => $t) {
                    if (!isset($t['file'])) {
                        $t['file'] = 'unknown';
                    }
                    if (!isset($t['line'])) {
                        $t['line'] = 0;
                    }
                    if (!isset($t['function'])) {
                        $t['function'] = 'unknown';
                    }
                    $log .= "#$i {$t['file']}({$t['line']}): ";
                    if (isset($t['object']) and is_object($t['object'])) {
                        $log .= get_class($t['object']) . '->';
                    }
                    $log .= "{$t['function']}()\n";
                }
                if (isset($_SERVER['REQUEST_URI'])) {
                    $log .= '[QUERY]' . $_SERVER['REQUEST_URI'];
                }
                error_log($log);
                $serv->send($this->currentFd, $log);
            default:
                break;
        }
    }
}