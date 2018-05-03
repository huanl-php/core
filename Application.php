<?php


namespace HuanL\Core;

use http\Env\Response;
use HuanL\Container\Container;
use HuanL\Request\Request;
use HuanL\Core\Facade\Route;
use HuanL\Routing\Routing;


class Application extends Container {

    /**
     * 框架根目录
     * @var string
     */
    public $rootPath = '';

    /**
     * 框架配置
     * @var array
     */
    private $config = [];

    /**
     * Application constructor.
     * @param string $rootPath
     */
    public function __construct(string $rootPath) {
        $this->rootPath = $rootPath;
        $this->registerBaseService();
        $this->loadConfig();
    }

    /**
     * 注册基本服务
     */
    protected function registerBaseService() {
        static::setInstance($this);
        $this->instance('app', $this);
        $this->instance(Container::class, $this);

        $this->singleton('request', Request::class);
        $this->singleton('response', Response::class);

        $this->singleton('route', Routing::class);
    }

    public function loadConfig() {
        if (file_exists($this->rootPath . '/config/app.php')) {
            $this->config = require_once $this->rootPath . '/config/app.php';
        }
        Route::loadRoute();
    }

    public function send() {
        $return = app('route')->resolve();
        if (is_string($return)) {
            echo $return;
        } else if (is_array($return)) {
            $response= $this->make('response');
            $response->contentType('json');
            echo json_encode($return,JSON_UNESCAPED_UNICODE);
        }
    }
}
