<?php

namespace app\home\controller;

use gophp\controller;
use gophp\cookie;
use gophp\helper\url;

class index extends controller {

    public function index(){

        cookie::instance()->set('cookie', 12);

        $this->display();

    }


}