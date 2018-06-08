<?php


namespace HuanL\Core\App\Model;

use HuanL\Core\Facade\Db;

//TODO:先放一边吧,没什么好的想法怎么去做
class DbModel extends BaseModel {

    /**
     * 数据库操作对象
     * @var \HuanL\Db\Db
     */
    protected $db = null;

    /**
     * 操作的表
     * @var string
     */
    protected $table = '';

    /**
     * 操作数据队列
     * @var array
     */
    protected $operDataQueue = [];

    /**
     * 主键值
     * @var mixed
     */
    protected $primaryKey;

    /**
     * 操作的条件
     * @var array
     */
    protected $where = [];

    public function __construct(string $table = '', $where = []) {
        parent::__construct();
        $this->table = $table;
        $this->where = $where;
    }

    public function __set($name, $value) {
        // TODO: Implement __set() method.
        if (method_exists($this, $name)) {
            $this->$name($value);
        } else {
            throw new \Exception('not exist attributes');
        }
    }

    public function __get($name) {
        // TODO: Implement __get() method.
        if (method_exists($this, $name)) {
            return $this->$name();
        } else {
            throw new \Exception('not exist attributes');
        }
    }

    public function update() {

        return [];
    }

    //TODO: 表结构读取,先放着
    protected function loadTableStruts() {
        //第一次载入时,读取表结构,后面读取缓存
        $rows = $this->db->query(
            'select column_name from information_schema.columns ' .
            'where table_schema = \'tmp\' and table_name = \'cb_book\'');
        print_r($rows->fetchAll());
    }

}