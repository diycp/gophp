<?php

namespace app\home\controller;

use gophp\config;
use gophp\mysql;

class test {

    public function index(){

        $config = config::get('db')['mysql'];

        $mysql = new mysql($config);

        $a = $mysql->table('user')->show(true)->where('id', '>', 0)->logic_start()->where('name','like', 'lll', 'or')->where('email','like', 'demo')->where('add_time', '>', 'kkk')->logic_end()->find();

        dump($a);



    }

}