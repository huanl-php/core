<?php


namespace HuanL\Core\Facade;

/**
 * Class Db
 * @method static \HuanL\Db\Db table(string $table)
 * @method static int lastId();
 * @method
 * @package HuanL\Core\Facade
 */
class Db extends Facade {

    public static function getAbstract() {
        // TODO: Implement getAbstract() method.
        return 'db';
    }
}