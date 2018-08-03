<?php


namespace HuanL\Core\Components;

use HuanL\Container\Container;
use HuanL\Core\Facade\Route;

/**
 * 路由组件
 * Class RouteComponent
 * @package HuanL\Core\Component
 */
class RouteComponents extends Components {

    protected $controllerPath;

    public function __construct(Container $container) {
        parent::__construct($container);
        $this->controllerPath = $this->app['path.controller'];
    }

    /**
     * 路由初始化
     */
    public function init() {
        //初始化路由组件,先判断有没有控制台路由定义的缓存,如果有就加载控制器的缓存
        //如果是调试模式,无视缓存
        if ($this->isRunCache()) {
            //缓存有效,直接加载缓存文件导入路由
            if ($routeArray = $this->getRouteCache($this->controllerPath)) {
                Route::importRoute($routeArray);
            }
        } else {
            //缓存无效,解析控制器文件,导出路由,保存到缓存
            Route::resolveControllerFile($this->controllerPath);
        }
        $this->cacheRoute();
        $routeArray = Route::exportRoute(false);
        $this->putRouteCache($routeArray);
        return true;
    }

    /**
     * 缓存的路由,这里写的路由都会被缓存下来
     * 但是注意添加的时候删除缓存
     */
    public function cacheRoute() {

    }

    /**
     * 是否运行缓存
     * @return bool
     */
    public function isRunCache() {
        //如果是调试模式,无视缓存
        if (!$this->app['debug'] && $this->isControlerRouteCache($this->controllerPath)) {
            return true;
        }
        return false;
    }

    /**
     * 获取路由缓存数组
     * @param $path
     * @return array
     */
    public function getRouteCache($path): array {
        if (!file_exists($this->getCacheFilePath($path))) {
            return false;
        }
        return json_decode(file_get_contents($this->getCacheFilePath($path)), true);
    }

    /**
     * 保存路由缓存
     * @param $routeArray
     * @return bool
     */
    public function putRouteCache($routeArray): bool {
        try {
            return @file_put_contents(
                $this->getCacheFilePath($this->controllerPath), json_encode($routeArray)
            );
        } catch (\Throwable $throwable) {
            return false;
        }
    }

    /**
     * 获取缓存文件路径
     * @param $path
     * @return string
     */
    public function getCacheFilePath($path): string {
        return $this->app['path.cache'] . '/route/route_' . md5($path) . '.json';
    }

    /**
     * 路由缓存是否有效
     * @param $path
     * @return bool
     */
    public function isControlerRouteCache($path): bool {
        //先判断路由缓存文件是否存在
        //然后判断缓存修改时间是否大于文件修改时间
        $file = $this->getCacheFilePath($path);
        if (file_exists($file) && filemtime($file) >= filemtime($path)) {
            return true;
        }
        return false;
    }
}