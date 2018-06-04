<?php


namespace HuanL\Core\App\Controller;

use ReflectionClass;

/**
 * 最最基本的控制器
 * Class BaseController
 * @package HuanL\Core\App
 */
abstract class BaseController {

    /**
     * 去掉Controller目录的路径
     * @var string
     */
    public $dir = '';

    /**
     * 类路径
     * @var string
     */
    protected $classPath = '';

    public function __construct() {
        instance(BaseController::class, $this);
        alias('controller', BaseController::class);
        $this->dealDir();
    }

    /**
     * 处理控制器的目录
     */
    protected function dealDir() {
        $reflection = new ReflectionClass($this);
        //处理得到控制器的另外一边
        //对win的左斜杠进行处理
        $appPath = str_replace('\\', '/', app('path.app'));
        $this->classPath = str_replace('\\', '/', $reflection->getFileName());
        //去掉控制器的目录名字
        $dir = str_replace($appPath, '',  $this->classPath);
        $dir = str_replace('controller/', '', $dir);
        //对后缀进行处理
        $dir = substr($dir, 0, strrpos($dir, 'Controller.php'));
        $this->dir = $dir;
    }

}