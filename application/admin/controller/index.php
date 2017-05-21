<?php
namespace app\admin\controller;

use gophp\controller;
use gophp\db;

class index extends controller{


    public function index(){

        echo '后台首页';

        $this->display();

    }

    public function demo()
    {
        echo 'admin-demo';
    }

    public function __call($name, $arguments)
    {
        echo '这是一个不存在的方法';
    }


}