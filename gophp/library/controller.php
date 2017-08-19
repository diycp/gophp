<?php

namespace gophp;

class controller
{

    public $module      = MODULE_NAME; // 当前模块名
    public $controlloer = CONTROLLER_NAME; // 当前控制器名
    public $action      = ACTION_NAME; // 当前方法

    /**
     * @desc 将变量赋值给模板
     * @param $name
     * @param $value
     */
    public function assign($name, $value)
    {

        view::instance()->assign($name, $value);

    }

    /**
     * @desc 展示模板
     * @param null $viewName 模板名或模板完整路径
     */
    public function display($viewName = null)
    {

        view::instance()->display($viewName);

    }

    /**
     * @desc 重定向
     * @param $uri 跳转地址
     * @param int $refresh 延迟跳转时间
     */
    public function redirect($uri, $refresh = 0)
    {

        response::redirect($uri, $refresh);

    }

    // 请求成功时跳转
    public function success()
    {

    }

    //请求失败时跳转
    public function error()
    {

    }

}

