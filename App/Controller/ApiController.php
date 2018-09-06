<?php
/**
 *============================
 * author:Farmer
 * time:2018/7/16 9:33
 * blog:blog.icodef.com
 * function:api控制器,使用trait
 *============================
 */

namespace HuanL\Core\App\Controller;


use HuanL\Request\Request;

/**
 * api控制器,可以多继承实现restful api之类的
 * Trait ApiController
 * @package HuanL\Core\App\Controller
 */
trait ApiController {

    /**
     * get中的操作方式字段,为空则按照请求方式
     * @var string
     */
    protected $apiField = 'action';

    public function __call($name, $arguments) {
        // TODO: Implement __call() method.
        if (empty($this->apiField)) {
            /** @var Request $req */
            $req = app(Request::class);
            $action = [$this, strtolower($req->method()) . $name];
        } else if (isset($_GET[$this->apiField])) {
            $action = [$_GET[$this->apiField], strtolower($_GET[$this->apiField]) . $name];
        }
        if (method_exists($this, $action[1])) {
            return app()->call($action, array_merge($_GET, $arguments));
        }
        return call_user_func_array([$this, $name], $arguments);
    }
}