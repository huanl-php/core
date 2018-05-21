<?php


namespace HuanL\Core\Facade;

/**
 * Class Db
 * @method static \HuanL\Db\SQLDb table(string $table)
 * @method
 * @package HuanL\Core\Facade
 */
class Db extends Facade {

    public static function getAbstract() {
        // TODO: Implement getAbstract() method.
        return 'db';
    }
}