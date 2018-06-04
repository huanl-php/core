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
}
