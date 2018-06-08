<?php


namespace HuanL\Core\App\Model;

use ReflectionClass;

abstract class BaseModel {

    /**
     * 类路径
     * @var string
     */
    protected $classPath = '';

    public function __construct() {
        $this->init();
    }

    protected function init() {
        $reflection = new ReflectionClass($this);
        $this->classPath = str_replace('\\', '/', $reflection->getFileName());
    }

    /**
     * 获取缓存路径
     * @return string
     * @throws \HuanL\Container\InstantiationException
     */
    public function getCachePath($path = ''): string {
        if (empty($path)) $path = $this->classPath;
        return app('path.cache') . '/model/verify_' . md5($path) . '.json';
    }

    /**
     * 判断缓存是否有效
     * @return bool
     * @throws \HuanL\Container\InstantiationException
     */
    protected function isModelCache(): bool {
        //判断路由缓存是否有效,先判断缓存文件是否存在
        //然后判断缓存文件创建(修改)时间大于原文件
        if (file_exists($this->getCachePath()) && filemtime($this->getCachePath()) >= filemtime($this->classPath)) {
            return true;
        }
        return false;
    }

}
