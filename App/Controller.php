<?php


namespace HuanL\Core\App;

use HuanL\Viewdeal\View;

/**
 * 控制器基类,提供了视图一些基础的操作
 * Class Controller
 * @package HuanL\Core\App
 */
abstract class Controller extends BaseController {

    /**
     * 视图模板的路径
     * @var string
     */
    protected $viewPath = '';

    public function __construct() {
        parent::__construct();
        //设置视图模板路径
        $this->viewPath = app('path.app') . 'view/' . $this->dir;
        instance('template', $this->viewPath);
    }

    /**
     * 获取视图模板路径
     * @return string
     */
    public function getViewPath(): string {
        return $this->viewPath;
    }

    /**
     * 得到相对于当前控制器视图目录的视图对象
     * @param $path
     * @param null $controller
     * @return View
     */
    public function view($path = '', $controller = null) {
        if (func_num_args() == 0) {
            return view();
        }
        return new View($this->getViewPath() . '/' . $path . '.html',
            $controller ?? $this
        );
    }
}
