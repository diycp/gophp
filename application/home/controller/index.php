<?php
namespace app\home\controller;

use gophp\controller;

use PHPSocketIO\SocketIO;
use Workerman\Worker;


class index extends controller {

    public function __construct()
    {
        //filter::controller('extension', [], []);
    }

    public function index(){

        $this->display();

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