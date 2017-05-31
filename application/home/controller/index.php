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


        if(upload::exist('fileUpload')){
            $a = upload::file('fileUpload');
            if($a){
                dump($a);
            }else{
                dump(upload::getError());
            }
        }



        $total = db::table('pdo_yy')->count();

        $page = new page($total, 10);

        $list = db::table('pdo_yy')->page($page, 2)->show(true)->order('id desc')->findAll();

        dump($list);

        $this->assign('page', $page);

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