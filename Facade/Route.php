<?php
/**
 *============================
 * author:Farmer
 * time:2018/4/25
 * function:
 *============================
 */

namespace HuanL\Core\Facade;

/**
 * Class Route
 * @method static \HuanL\Routing\Route get(string $uri, $action = null)
 * @method static \HuanL\Routing\Route post(string $uri, $action = null)
 * @method static \HuanL\Routing\Route put(string $uri, $action = null)
 * @method static \HuanL\Routing\Route delete(string $uri, $action = null)
 * @method static \HuanL\Routing\Route options(string $uri, $action = null)
 * @method static \HuanL\Routing\Route any(string $uri, $action = null)
 * @method static \HuanL\Routing\Route route($method, string $uri, $action = null)
 * @method static \HuanL\Routing\Routes group(string $name, Closure $method, array $parameteres = [])
 * @method static void resolveControllerFile(string $path, string $suffix = 'Controller')
 * @method static string name($key)
 * @method static importRoute($routeArray)
 * @method static array exportRoute(bool $isExportObject = true)
 *
 * @package HuanL\Core\Factory
 */
class Route extends Facade {

    /**
     * 路由配置
     * @var array
     */
    protected static $config = [];


    /**
     * 获取抽象类型
     * @return string
     */
    public static function getAbstract() {
        return 'route';
    }

}