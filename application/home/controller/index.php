<?php
namespace app\home\controller;

use gophp\controller;
use app\home\model\user;
use gophp\db;
use gophp\helper\str;
use gophp\page;
use gophp\request;
use gophp\route;

class index extends controller {

    public function __construct()
    {
        //filter::controller('extension', [], []);
    }

    public function index(){


        $total = db::table('pdo_yy')->count();

        $page = new page($total, 10);

        $list = db::table('pdo_yy')->page($page->pageRows)->show(true)->findAll();

        dump($list);

        $this->assign('page', $page);

        $this->display();



    }

    public function demo()
    {
        echo 'demo';
    }

    public function __call($name, $arguments)
    {
        echo $name;
    }

}