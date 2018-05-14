<?php


namespace HuanL\Core\Facade;

/**
 * Class View
 * @method static string setTemplate(string $template)
 * @method static setTemplateFile(string $template_file)
 * @method static void execute()
 * @method static void compiled()
 * @method statis void bindValue(string $parameter, $value)
 * @method static void bindParam(string $parameter, &$value)
 * @package HuanL\Core\Facade
 */
class View {

    /**
     * 获取抽象类型
     * @return string
     */
    public static function getAbstract() {
        return 'view';
    }
}