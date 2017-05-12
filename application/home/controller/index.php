<?php
namespace app\home\controller;

use gophp\controller;
use app\home\model\user;
use gophp\request;
use gophp\route;

class index extends controller {

    public function __construct()
    {
        //filter::controller('extension', [], []);
    }

    public function index(){

        //echo request::getDomain();

        echo '勾国磊';

        $a = route::url('aa/indexs/index',['id' => 1,'cat' => 3], true,'json');

        dump($a);

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