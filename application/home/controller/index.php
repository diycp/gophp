<?php
namespace app\home\controller;

use gophp\controller;
use app\home\model\user;
use gophp\db;
use gophp\helper\str;
use gophp\log;
use gophp\page;
use gophp\request;
use gophp\route;

class index extends controller {

    public function __construct()
    {
        //filter::controller('extension', [], []);
    }

    public function index(){

        $a = route::url('demo/index/dee');
        dump($a);

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