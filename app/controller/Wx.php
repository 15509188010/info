<?php


namespace app\controller;


use app\BaseController;
use app\model\UserInfo;
use think\App;

/**
 * 企业微信用户信息 Api
 * Class Wx
 * @package app\controller
 */
class Wx extends BaseController
{
    private $objUserInfo;//用户信息对象

    /**
     * Wx constructor.
     * @param App $app
     */
    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->objUserInfo =  new UserInfo();
    }

    public function auth()
    {

    }
}