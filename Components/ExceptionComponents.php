<?php


namespace HuanL\Core\Components;


use HuanL\Container\Container;

class ExceptionComponents extends Components {

    public function __construct(Container $container) {
        parent::__construct($container);
    }

    public function init() {
        // TODO: Implement init() method.
        //设置不输出错误,由自己的函数来处理

        //貌似不需要屏蔽,绑定了的话会自动捕捉错误,而且万一我这个破框架写错了呢?233
//        error_reporting(E_ALL);
//        ini_set('display_errors', 'off');

        set_error_handler([ExceptionComponents::class, 'error_handler']);
        set_exception_handler([ExceptionComponents::class, 'exception_handler']);
    }

    /**
     * 错误处理
     * @param int $errno
     * @param string $errstr
     * @param string $errfile
     * @param int $errline
     * @param array $errcontext
     * @return bool
     */
    public static function error_handler(int $errno,
                                         string $errstr,
                                         string $errfile,
                                         int $errline,
                                         array $errcontext): bool {
        return static::out_error_msg($errno, $errstr, $errfile, $errline);
    }

    /**
     * 异常处理
     * @param \Throwable $exception
     */
    public static function exception_handler(\Throwable $exception) {
        return static::out_error_msg(
            $exception->getCode(),
            $exception->getMessage(),
            $exception->getFile(),
            $exception->getLine(),
            $exception->getTrace()
        );

    }


    /**
     * 输出错误信息
     * @param int $errno
     * @param string $errstr
     * @param string $errfile
     * @param int $errline
     * @param array $trace
     * @return bool
     * @throws \HuanL\Container\InstantiationException
     */
    public static function out_error_msg(int $errno,
                                         string $errstr,
                                         string $errfile,
                                         int $errline,
                                         array $trace = []): bool {
        //暂时用文本,等吧模板引擎弄了后用了后输出模板

        //先判断是否为调试模式,调试模式输出错误信息,否则输出报错
        if (app('debug')) {
            //输出详细的信息,获取错误文件的代码,附近几行,和跟踪
            $code = static::get_file_line_code($errfile, $errline);
            $out_html = 'Error Message:' . $errstr . '<br/>Code:<br/><pre>' . "\n" . $code . '</pre>';
            die($out_html);
        } else {
            //直接的报错页面,现在还没用模板直接先输出个文本吧,233
            die ('error');
        }
    }

    /**
     * 输出错误的代码块
     * @param $file
     * @param $line
     * @param int $number
     * @return string
     */
    protected static function get_file_line_code($file, $line, $number = 8) {
        $fileContent = file_get_contents($file);
        preg_match_all('/.+/', $fileContent, $matches);
        //开始行数与结束行数
        $start_line = $line - ceil($number / 2);
        $end_line = $line + floor($number / 2);
        if ($start_line < 0) {
            $end_line += abs($start_line);
            $start_line = 0;
        }
        $code = '';
        for ($i = $start_line; $i < $end_line && $i < sizeof($matches[0]); $i++) {
            if ($i == $line - 1) {
                $code .= '<span style="color: red;">' . htmlentities($matches[0][$i]) . '</span>';
            } else {
                $code .= htmlentities($matches[0][$i]);
            }
        }
        return $code;
    }

}