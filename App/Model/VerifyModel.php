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

    }

}
