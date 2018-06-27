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
     * @return Container|mixed
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
<<<<<<< HEAD
        $retView->setCacheDir(app('path.cache') . '/view');
=======
        //缓存检查
        $cacheFile = app('path.cache') . '/view/' . md5($template) . '.php';
        if (file_exists($cacheFile) && filemtime($template) < filemtime($cacheFile)) {
            //缓存存在,并且缓存文件时间大于原文件时间,设置模板然后返回
            $retView->setTemplate(file_get_contents($cacheFile));
            return $retView;
        }
        //缓存不存在编译模板,保存返回
        @file_put_contents($cacheFile, $retView->compiled());
>>>>>>> 291ad4b5ed7692a4151e4c2b191c8778138919e6
        return $retView;
    }
}
