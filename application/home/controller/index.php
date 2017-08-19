<?php

namespace app\home\controller;

use gophp\controller;
use gophp\db;

class index extends controller {

    public function index(){


        $a = db::instance()->driver()->table('pdo_yy')->find();

        dump($a);

        $this->display();

    }


}