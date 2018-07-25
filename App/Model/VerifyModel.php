<?php


namespace HuanL\Core\App\Model;

use HuanL\Verify\ICheckDataObject;
use HuanL\Verify\Rule;
use HuanL\Verify\Verify;

/**
 * 数据验证模型
 * Class VerifyModel
 * @package HuanL\Core\App\Model
 */
abstract class VerifyModel extends BaseModel implements ICheckDataObject {

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
        parent::__construct();
        //对对象进行绑定
        $this->verify = new Verify();
        $this->verify->bindObject($this);
        //将数据添加到成员
        $this->setCheckData($data);
        //处理规则
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
            $cache = json_decode(file_get_contents($this->getCachePath()), true);
            $this->verify->addCheckRule($cache);
        } else {
            //无缓存,分析验证模型文件,写入数据
            $ruleArray = $this->analyzeRule();
            @file_put_contents($this->getCachePath(), json_encode($ruleArray));
        }
    }

    /**
     * 分析规则,返回一个规则数组
     * @return array
     */
    protected function analyzeRule(): array {
        //读入类文件,使用正则匹配
        $classFileContent = file_get_contents($this->classPath);
        preg_match_all('/\* @(verify|alias) (.*?)[\s]\n|public \$(.*?);/', $classFileContent, $matches, PREG_SET_ORDER);
        $rule = new Rule($this->verify);
        $ruleArray = [];
        foreach ($matches as $item) {
            if (empty($item[2])) {
                //第二个匹配为空则是匹配到了名字
                //重新设置规则标签
                $rule->label($item[3]);
                $this->verify->addCheckRule($rule);
                $rule->addRule($ruleArray);
                $ruleArray = [];
                $rule = new Rule($this->verify);
            } else {
                //通过第一个匹配项来判断操作
                switch ($item[1]) {
                    case 'verify':
                        //是验证规则 中间为空为参数间隔
                        $param = explode(' ', $item[2]);
                        //提取出参数后,第一个为方法名字,后面的为参数
                        $key = array_shift($param);
                        //对func进行处理
                        if ($key == 'func') {
                            $param[0] = [$this, $param[0]];
                        }
                        $ruleArray[$key] = $param;
                        break;
                    case 'alias':
                        $rule->alias($item[2]);
                        break;
                    default:
                        return [];
                }
            }
        }
        unset($rule);
        return $this->verify->getArrayRule();
    }

    /**
     * 校验数据
     * @param bool $meet
     * @return bool
     */
    public function __check($meet = true): bool {
        return $this->verify->check($meet);
    }

    /**
     * 获取错误列表
     * @return array
     */
    public function getErrorList(): array {
        return $this->verify->getErrorList();
    }

    /**
     * 获取上一次错误
     * @return mixed
     */
    public function getLastError() {
        return $this->verify->getLastError();
    }

    /**
     *
     * @param $key
     * @return mixed
     */
    public function getCheckData($key) {
        // TODO: Implement getCheckData() method.
        return empty($this->$key) ? '' : $this->$key;
    }

    /**
     *
     * @param $key
     * @param $val
     * @return ICheckDataObject
     */
    public function setCheckData($key, $val = ''): ICheckDataObject {
        // TODO: Implement setCheckData() method.
        if (func_num_args() == 1 && is_array($key)) {
            foreach ($key as $k => $item) {
                if (property_exists($this, $k)) {
                    $this->$k = $item;
                }
            }
        } else {
            $this->$key = $val;
        }
        return $this;
    }
}
