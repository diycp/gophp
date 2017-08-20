<?php

namespace app\home\controller;

use gophp\controller;
use gophp\cookie;
use gophp\session;

class index extends controller {

    public function index(){

        cookie::instance()->set('cookie', 99, 3);

        $this->display();

    }


}