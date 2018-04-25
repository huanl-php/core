<?php
/**
 *============================
 * author:Farmer
 * time:2018/4/25
 * function:
 *============================
 */

namespace HuanL\Core\ServiceProvider;

use HuanL\Routing\Route as RouteInstance;

class Route {
    /**
     * 路由的get方法
     * @param string $uri
     * @param null $action
     * @return RouteInstance
     * @throws \HuanL\Container\InstantiationException
     */
    public static function get(string $uri, $action = null) {
        return app('route')->get($uri, $action);
    }

    /**
     * 路由的post方法
     * @param string $uri
     * @param null $action
     * @return RouteInstance
     * @throws \HuanL\Container\InstantiationException
     */
    public static function post(string $uri, $action = null) {
        return app('route')->post($uri, $action);
    }

    /**
     * 路由的put方法
     * @param string $uri
     * @param null $action
     * @return RouteInstance
     * @throws \HuanL\Container\InstantiationException
     */
    public static function put(string $uri, $action = null) {
        return app('route')->put($uri, $action);
    }

    /**
     * 路由的delete方法
     * @param string $uri
     * @param null $action
     * @return RouteInstance
     * @throws \HuanL\Container\InstantiationException
     */
    public static function delete(string $uri, $action = null) {
        return app('route')->delete($uri, $action);
    }

    /**
     * 路由的options方法
     * @param string $uri
     * @param null $action
     * @return RouteInstance
     * @throws \HuanL\Container\InstantiationException
     */
    public static function options(string $uri, $action = null) {
        return app('route')->options($uri, $action);
    }

    /**
     * 路由的any方法
     * @param string $uri
     * @param null $action
     * @return RouteInstance
     * @throws \HuanL\Container\InstantiationException
     */
    public static function any(string $uri, $action = null) {
        return app('route')->any($uri, $action);
    }

    /**
     * 自义定的添加路由方法
     * @param $method
     * @param string $uri
     * @param null $action
     * @return RouteInstance
     * @throws \HuanL\Container\InstantiationException
     */
    public static function route($method, string $uri, $action = null) {
        return app('route')->addRoute($method, $uri, $action);
    }
}