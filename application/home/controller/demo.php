<?php

namespace app\home\controller;

use gophp\cache;
use gophp\controller;
use gophp\db;

class demo extends controller {

    public function index(){


        $a = cache::instance()->get('demo');

        dump($a);

        $this->display();

    }


}