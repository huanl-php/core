<?php


namespace HuanL\Core\App\Model;

use HuanL\Core\Facade\Db;

//TODO:先放一边吧,没什么好的想法怎么去做
class DbModel extends BaseModel {

    /**
     * 数据库操作对象
     * @var \HuanL\Db\Db
     */
    public $db = null;

    /**
     * 操作的表
     * @var string
     */
    protected $table = '';

    /**
     * 主键字段
     * @var string
     */
    protected $primaryKey = '';

    /**
     * 缓存上一次的值
     * @var array
     */
    protected $cacheValue = [];

    public function __construct(string $table = '') {
        parent::__construct();
        $this->table = $table;
    }

    /**
     * 是否存在,会缓存取到的值到value里面
     * @param $value
     * @return bool
     */
    public function exist($value): bool {
        $this->db->table($this->table);
        if (is_array($value)) {
            $this->db->where($value);
        } else {
            $this->db->where($this->primaryKey, $value);
        }
        return ($this->cacheValue = $this->db->find()) !== false;
    }

    /**
     * 获取上次取得的值
     * @return array
     */
    public function getValue(): array {
        return $this->cacheValue;
    }

    /**
     * 外部操作数据库
     * @return \HuanL\Db\Db
     */
    public function db(): \HuanL\Db\Db {
        $this->db->table($this->table);
        return $this->db;
    }

    /**
     * 分页
     * @param $pageNumber
     * @param array $fields
     * @param int $total
     * @return array
     */
    public function pagination($pageNumber, array $fields, int $number = 20, int &$total = 0): array {
        $pageNumber = ceil($pageNumber);
        $pageNumber = $pageNumber < 1 ? 1 : $pageNumber;
        $this->db->limit($number * ($pageNumber - 1), $number);
        return $this->db->select()->fetchAll();
    }

}