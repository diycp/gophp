<?php
namespace app\home\controller;

use gophp\controller;
use gophp\db;
use gophp\page;
use gophp\upload;

class index extends controller {

    public function __construct()
    {
        //filter::controller('extension', [], []);
    }

    public function index(){

        $this->display('index');

    }

    public function demo()
    {
        echo 'demo';
    }

    public function __call($name, $arguments)
    {
        echo $name;
    }

}