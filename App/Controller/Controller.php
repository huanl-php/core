<?php


namespace HuanL\Core\App\Controller;

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
    protected function getViewPath(): string {
        return $this->viewPath;
    }

    /**
     * 得到相对于当前控制器视图目录的视图对象
     * @param string $path
     * @param null $controller
     * @return \HuanL\Viewdeal\View
     */
    protected function view($path = '', $controller = null): \HuanL\Viewdeal\View {
        if (func_num_args() == 0) {
            return view();
        }
        return view($this->getViewPath() . '/' . $path . '.html',
            $controller ?? $this
        );
    }
}
