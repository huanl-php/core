<?php


namespace HuanL\Core\App\Model;

use HuanL\Verify\Verify;

/**
 * 数据验证模型
 * Class VerifyModel
 * @package HuanL\Core\App\Model
 */
abstract class VerifyModel extends BaseModel {

    /**
     * 验证
     * @var Verify
     */
    protected $verify = null;

    /**
     * VerifyModel constructor.
     * @param array $data
     */
    public function __construct(array $data = []) {
        $this->verify = new Verify([], $data);
        $this->dealRule();
    }

    /**
     * 处理验证规则
     */
    protected function dealRule() {
        //读取本类文件,从注释中获取数据
        //先判断有没有缓存
        if ($this->isModelCache()) {
            //有缓存,读取缓存,加入规则
            $cache = json_decode(file_get_contents(), true);
            $this->verify->addRule($cache);
        } else {
            //无缓存

        }

    }

    /**
     * 分析规则,返回一个规则数组
     * @return array
     */
    protected function analyzeRule():array{

    }

    /**
     * 判断缓存是否有效
     * @return bool
     * @throws \HuanL\Container\InstantiationException
     */
    protected function isModelCache(): bool {
        //判断路由缓存是否有效,先判断缓存文件是否存在
        //然后判断缓存文件创建(修改)时间大于原文件
        if (file_exists($this->getCachePath()) && filemtime($this->getCachePath()) >= filemtime($this->classPath)) {
            return true;
        }
        return false;
    }

    /**
     * 获取缓存路径
     * @return string
     * @throws \HuanL\Container\InstantiationException
     */
    public function getCachePath(): string {
        return app('path.cache') . '/model/verify_' . md5($this->classPath) . '.json';
    }

}
