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
     * @return mixed
     * @throws \HuanL\Container\InstantiationException
     */
    function app($abstract = null, $parameter = []) {
        if (is_null($abstract)) {
            return Container::getInstance();
        }
        return Container::getInstance()->make($abstract, $parameter);
    }
}



