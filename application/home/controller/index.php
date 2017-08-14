<?php

namespace app\home\controller;

use gophp\controller;

class index extends controller {

    public function index(){

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