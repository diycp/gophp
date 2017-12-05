<?php
namespace app\home\controller;

use gophp\cache;
use gophp\captcha;
use gophp\controller;
use gophp\session;

class demo extends controller{
    public function __construct()
    {
        //echo COMMON_PATH;

    }


    public function index(){


        session::set('code', 'ggy', 10);

        echo 'demo';



    }


    public function __call($name, $arguments)
    {
        echo '这是一个不存在的方法';
    }


}