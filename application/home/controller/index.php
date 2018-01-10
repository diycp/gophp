<?php

namespace app\home\controller;

use gophp\controller;

class index extends controller {

    public function index(){

        demo1();
        $this->display('index');

    }


}