<?php

namespace app\home\controller;

use gophp\cache;
use gophp\controller;
use gophp\cookie;
use gophp\db;

class demo extends controller {

    public function index(){


        $a = cookie::instance()->get('cookie');

        dump($a);

    }


}