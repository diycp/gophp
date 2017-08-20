<?php

namespace app\home\controller;

use gophp\controller;
use gophp\session;

class index extends controller {

    public function index(){

        session::instance()->set('cookie', 99, 3);

        $this->display();

    }


}