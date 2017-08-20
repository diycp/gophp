<?php

namespace app\home\controller;

use gophp\controller;
use gophp\cookie;
use gophp\session;

class index extends controller {

    public function index(){

        session::instance()->set('cookie', ['demo' => 'jjjjjj'], 300);

        $this->display();

    }


}