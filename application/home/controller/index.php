<?php

namespace app\home\controller;

use gophp\controller;
use gophp\cookie;
use gophp\session;

class index extends controller {

    public function index(){


        $name = 'demo';

        $a = explode('.', $name);

        dump($a);

        session::instance()->set('cookie', 'aa', 300);

        $this->display();

    }


}