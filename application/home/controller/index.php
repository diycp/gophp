<?php
namespace app\home\controller;

use gophp\controller;
use gophp\upload;

class index extends controller {

    public function __construct()
    {
        //filter::controller('extension', [], []);
    }

    public function index(){

        if(upload::exist('fileUpload')){
            $a = upload::file('fileUpload');
            dump($a);
        }



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