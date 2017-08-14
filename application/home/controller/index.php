<?php

namespace app\home\controller;

use gophp\config;
use gophp\controller;
use gophp\cookie;
use gophp\db;
use gophp\M;

class index extends controller {

    public function index(){

        db::instance()->table('kkk', '');


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