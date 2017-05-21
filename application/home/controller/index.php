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


        $page = new page(101, 10);



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