<?php
namespace app\admin\controller;

use gophp\controller;
use gophp\db;
use gophp\page;
use gophp\request;

class index extends controller{


    public function index(){

        echo '后台首页';

        $this->display();

    }

    public function demo()
    {

        $page = new page(101, 10);


        dump($page->url(9));
    }

    public function __call($name, $arguments)
    {
        echo '这是一个不存在的方法';
    }


}