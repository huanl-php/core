<?php
/**
 * 框架辅助函数库
 */

use HuanL\Container\Container;

if (!function_exists('app')) {
    /**
     * 获取应用实例
     * @param null $abstract
     * @param array $parameter
     * @return \HuanL\Core\Application|mixed
     * @throws \HuanL\Container\InstantiationException
     */
    function app($abstract = null, $parameter = []) {
        if (is_null($abstract)) {
            return Container::getInstance();
        }
        return Container::getInstance()->make($abstract, $parameter);
    }
}

if (!function_exists('instance')) {
    /**
     * 添加实例
     * @param $abstract
     * @param null $instance
     * @return mixed
     * @throws \HuanL\Container\InstantiationException
     */
    function instance($abstract, $instance) {
        return app()->instance($abstract, $instance);
    }
}

if (!function_exists('alias')) {
    /**
     * 设置别名
     * @param $alias
     * @param $abstract
     * @throws \HuanL\Container\InstantiationException
     */
    function alias($alias, $abstract) {
        return app()->alias($alias, $abstract);
    }
}

if (!function_exists('view')) {
    /**
     * 获取视图对象
     * @param string $template
     * @param null $controller
     * @return \HuanL\Viewdeal\View|mixed
     */
    function view(string $template = '', $controller = null) {
        if (func_num_args() <= 0) {
            /** @var \HuanL\Routing\Route $route */
            $route = app(\HuanL\Routing\Route::class);
            $template = app('template') . '/' . $route->getClassMethod() . '.html';
            $controller = app('controller');
        }
        $template = realpath($template);
        $retView = new \HuanL\Viewdeal\View($template, $controller);
        $retView->setCacheDir(app('path.cache') . '/view');
        return $retView;
    }
}
