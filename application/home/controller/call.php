<?php
namespace app\home\controller;

use gophp\controller;
use app\home\model\user;

class call extends controller {

    public function __construct()
    {
        //filter::controller('extension', [], []);
    }

    public function index(){

        echo $this->controlloer;


    }

    public function demo()
    {


    }

    public function __call($name, $arguments)
    {
        echo $name;
    }

}