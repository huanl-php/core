<?php


namespace HuanL\Core\Components;

/**
 * 数据库组件
 * Class DataBaseComponent
 * @package HuanL\Core\Components
 */
class DataBaseComponent extends Components {

    /**
     * 数据库配置存储
     * @var array
     */
    protected $dbConfig = [];

    public function init() {
        // TODO: Implement init() method.
        //读取数据库配置文件,如果没有数据库配置文件,则认为是不需要数据库的
        //不对数据库进行初始化,直接返回
        if ($this->loadConfig() === false) {
            return false;
        }
        $this->app->instance(\HuanL\Db\DbConnect::class,
            $this->app->make('dbconnect', $this->dbConfig)
        );
    }

    /**
     * 读取配置文件
     * @return bool|mixed
     */
    protected function loadConfig() {
        if (!file_exists($this->app['path.config'] . '/database.php')) {
            return false;
        }
        return $this->dbConfig = require $this->app['path.config'] . '/database.php';
    }
}