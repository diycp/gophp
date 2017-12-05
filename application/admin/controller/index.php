<?php
namespace app\admin\controller;

use gophp\controller;
use gophp\db;

class index extends controller{


    public function index(){

        $a = db::table('pdo_yy')->show(false)->where('a1', 'like', '%磊%')->findAll();
        dump($a);

        $this->assign('name', '勾国磊');

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