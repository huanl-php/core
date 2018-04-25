<?php


namespace HuanL\Core;


use HuanL\Container\Container;
use HuanL\Request\Request;
use HuanL\Routing\Routing;

require_once 'functions.php';

class Application extends Container {

    /**
     * 框架根目录
     * @var string
     */
    private $rootPath = '';

    /**
     * Application constructor.
     * @param string $rootPath
     */
    public function __construct(string $rootPath) {
        $this->rootPath = $rootPath;
        $this->registerBaseService();
    }

    /**
     * 注册基本服务
     */
    public function registerBaseService() {
        static::setInstance($this);
        $this->instance('app', $this);
        $this->instance(Container::class, $this);

        $this->singleton('request',Request::class);
        $this->singleton('route',Routing::class);
    }

}
