<?php


namespace HuanL\Core\App\Model;

use HuanL\Core\Facade\Db;

//TODO:还得慢慢完善
abstract class DbModel extends BaseModel {

    /**
     * 数据库操作对象
     * @var \HuanL\Db\Db
     */
    public $db = null;

    /**
     * 操作的表
     * @var string
     */
    public const table = '';

    /**
     * 主键字段
     * @var string
     */
    public const primaryKey = '';

    /**
     * 缓存上一次的值
     * @var array
     */
    protected $cacheValue = [];

    public function __construct() {
        parent::__construct();
    }

    /**
     * 是否存在,会缓存取到的值到value里面
     * @param $value
     * @return array|bool
     */
    public static function exist($value) {
        $db = Db::table(static::table);
        if (is_array($value)) {
            $db->where($value);
        } else {
            $db->where(static::primaryKey, $value)->field(static::primaryKey);
        }
        return $db->find();
    }

    /**
     * 对象插入数据
     * @param object $object
     * @param array $exception
     * @return int
     * @throws \ReflectionException
     */
    public static function insert_o(object $object, array $exception = []): int {
        $data = self::getClassPropertiesValue($object, \ReflectionProperty::IS_PUBLIC, $exception);
        return Db::table(static::table)->insert($data);;
    }

    /**
     * 获取类的属性值,返回数组
     * @param object $object
     * @param int $filter
     * @param array $exception
     * @return array
     * @throws \ReflectionException
     */
    protected static function getClassPropertiesValue(object $object, int $filter, array $exception = []) {
        $data = [];
        $ref = new \ReflectionClass($object);
        $properties = $ref->getProperties($filter);
        foreach ($properties as $item) {
            $key = $item->name;
            if (in_array($key, $exception)) {
                continue;
            }
            $data[$key] = $object->$key;
        }
        return $data;
    }

    /**
     * 对象更新
     * @param object $object
     * @param array $where
     * @param array $exception
     * @return int
     * @throws \ReflectionException
     */
    public static function update_o(object $object, array $where = [], array $exception = []): int {
        $data = self::getClassPropertiesValue($object, \ReflectionProperty::IS_PUBLIC, $exception);
        return Db::table(static::table)->where($where)->update($data);;
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
    public function db(string $alias = ''): \HuanL\Db\Db {
        $this->db = Db::table(static::table, $alias);
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
        $total = $this->db->field($fields)->count();
        $record = $this->db->limit($number * ($pageNumber - 1), $number)->select();
        $rows = [];
        while ($row = $record->fetch()) {
            $rows[] = $row;
        }
        return $rows;
    }

}