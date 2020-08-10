<?php

namespace app\admin\controller;


/**
 * 后台首页控制器
 * @package app\admin\controller
 */
class Index extends Base
{
    protected $middleware = [
        'Login'
    ];

    /**
     * 显示后台首页
     * @return mixed
     */
    public function index()
    {
        return $this->fetch();
    }
    public function welcome()
    {
        return 'welcome';
    }
}
