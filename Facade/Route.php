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