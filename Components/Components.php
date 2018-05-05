<?php


namespace HuanL\Core\Components;

use HuanL\Container\Container;

/**
 * 组件基类
 * Class Component
 * @package HuanL\Core\Component
 */
abstract class Components {
    /**
     * @var Container
     */
    protected $app = null;

    public function __construct(Container $container) {
        $this->app = $container;
    }

    /**
     * 组件初始化函数
     * @param Container $container
     */
    abstract public function init();

}

