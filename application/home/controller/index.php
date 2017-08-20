<?php

namespace app\home\controller;

use gophp\cache;
use gophp\controller;
use gophp\db;
use gophp\log;
use gophp\view;

class index extends controller {

    public function index(){

        \cache()->set('demo', 'test');

        $this->display();

    }


}