<?php


namespace HuanL\Core;

use http\Env\Response;
use HuanL\Container\Container;
use HuanL\Core\Components\Components;
use HuanL\Core\Components\ExceptionComponents;
use HuanL\Core\Components\RouteComponents;
use function Sodium\crypto_sign;

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
        $this->loadConfig();
        $this->bindConfigToContainer();
        $this->bindContainer();
        $this->registerContainerAbstract();
        $this->loadCoreComponents();
    }

    /**
     * 加载核心组件
     */
    public function loadCoreComponents() {
        $this->initComponents(ExceptionComponents::class);
        $this->initComponents(RouteComponents::class);
    }

    /**
     * 绑定配置到容器
     */
    public function bindConfigToContainer() {
        $this->instance('path', $this->rootPath);
        $this->instance('path.config', $this->configPath());
        $this->instance('path.controller', $this->controllerPath());
        $this->instance('path.cache', $this->cachePath());
        $this->instance('path.route', $this->routePath());
        $this->instance('path.app', $this->appPath());

        $this->instance('debug', $this->debug());
    }

    /**
     * 应用路径
     * @return mixed
     */
    public function appPath() {
        return $this->rootPath . '/' . $this->applicationConfig();
    }

    /**
     * 配置中的app的值
     * @return mixed|string
     */
    public function applicationConfig() {
        return $this->config['application'] ?? 'app';
    }

    public function charsetConfig() {
        return $this->config['charset'] ?? 'utf-8';
    }

    /**
     * 配置中的Controller的值
     * @return mixed|string
     */
    public function controllerConfig() {
        return $this->config['dir']['controller'] ?? 'controller';
    }

    /**
     * 返回应用根路径
     * @return string
     */
    public function path(): string {
        return $this->rootPath;
    }

    /**
     * 返回应用配置目录
     * @return string
     */
    public function configPath(): string {
        return $this->rootPath . '/config';
    }

    /**
     * 返回路由目录
     * @return string
     */
    public function routePath(): string {
        return $this->rootPath . '/' . ($this->config['dir']['route'] ?? 'route');
    }

    /**
     * 返回控制器目录
     * @return string
     */
    public function controllerPath(): string {
        return $this->rootPath . '/' . $this->applicationConfig() . '/' . $this->controllerConfig();
    }

    /**
     * 返回缓存目录
     * @return string
     */
    public function cachePath(): string {
        return $this->rootPath . '/' . ($this->config['dir']['cache'] ?? '/bootstrap/cache');
    }

    /**
     * 绑定容器
     */
    protected function bindContainer() {
        static::setInstance($this);
        $this->instance('app', $this);
        $this->instance(Container::class, $this);
    }

    /**
     * 注册容器抽象类型
     */
    protected function registerContainerAbstract() {
        $this->singleton('request', \HuanL\Request\Request::class);
        $this->singleton('response', \HuanL\Request\Response::class);
        $this->singleton('route', \HuanL\Routing\Routing::class);
        $this->singleton('view', \HuanL\Viewdeal\View::class);
        $this->singleton('dbconnect', \HuanL\Db\DbConnect::class);
        $this->singleton('db', \HuanL\Db\Db::class);
        //绑定配置中自义定的类型
        foreach ($this->config['abstract'] as $key => $value) {
            $this->singleton($key, $value);
        }
    }

    /**
     * 加载配置
     * @param null $file
     */
    public function loadConfig($file = null) {
        if (is_null($file)) {
            $file = $this->rootPath . '/config/app.php';
        }
        if (file_exists($file)) {
            $this->config = require $file;
        }
        $this->instance('app.config', $this->config);
    }

    /**
     * 框架运行
     */
    public function run() {
        //加载用户配置的初始组件
        $this->loadInitComponents();
        $return = app('route')->resolve();
        /** @var \HuanL\Request\Response $response */
        $response = $this->make('response');
        if (is_string($return) || (method_exists($return, '__toString'))) {
            $response->contentType('html', $this->charsetConfig());
            echo $return;
        } else if (is_array($return)) {
            $response->contentType('json', $this->charsetConfig());
            echo json_encode($return, JSON_UNESCAPED_UNICODE);
        } else if ($return instanceof \HuanL\Request\Response) {
            echo $return->getResponse();
        } else if ($return === false) {
            $this->make('response')->statusCode(404);
            echo '404';
        }
    }

    /**
     * 加载初始组件
     */
    protected function loadInitComponents() {
        if (isset($this->config['component'])) {
            //读取配置中的component设置
            foreach ($this->config['component'] as $value) {
                $component = $this->initComponents($value);
            }
        }
    }

    /**
     * 初始化组件
     * @param $name
     * @param $unique
     * @return Components
     */
    public function initComponents($name): Components {
        /** @var  Components */
        $component = $this->make($name);
        if (!$component instanceof Components) {
            throw new ComponentException('The wrong Components, need to inherit Components abstract');
        }
        if ($component->init() === false) {
            //发生错误,结束这次请求
            exit(0);
        }
        return $component;
    }

    /**
     * 获取配置
     * @return array
     */
    public function getConfig(): array {
        return $this->config;
    }

    /**
     * 是否为调试模式
     * @return bool
     */
    public function debug(): bool {
        return $this->config['debug'] ?? false;
    }
}

