<?php

namespace app\home\controller;

use app\Demo;
use gophp\controller;

class test extends controller {

    public function index()
    {

        $a = Demo::find(1);

        dump($a->name);

    }


}