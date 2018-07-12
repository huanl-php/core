<?php


namespace HuanL\Core\Facade;

/**
 * Class Db
 * @method static \HuanL\Db\Db table(string $table)
 * @method static bool commit()
 * @method static bool rollback()
 * @method static bool inTransaction()
 * @method static bool begin()
 * @method static int lastId();
 * @package HuanL\Core\Facade
 */
class Db extends Facade {

    public static function getAbstract() {
        // TODO: Implement getAbstract() method.
        return 'db';
    }
}