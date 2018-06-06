<?php


namespace HuanL\Core\Tests\Model;


use HuanL\Core\App\Model\VerifyModel;

class VerifyTestModel extends VerifyModel {

    /**
     * @verify empty 用户名不能为空
     * @verify length 2,10 用户名过短
     * @verify regex /^[a-z]+$/ 用户名格式不正确
     */
    public $user;

    /**
     * @verify empty 密码不能为空
     */
    public $passd;

}