<?php

namespace app\home\controller;

use gophp\controller;
use gophp\db;
use gophp\mail;
use gophp\request;
use gophp\route;
use Workerman\Lib\Timer;
use Workerman\Worker;


class index extends controller {

    public function index(){
        echo GOPHP_PATH;

    }

}