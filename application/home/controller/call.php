<?php

namespace app\home\controller;

use app\nav;
use gophp\controller;
use gophp\response;

class call extends controller {

    public function index(){

        $nav = strtolower($this->controlloer);

        $list = db('article')->where('status', '=', 1)->where('nav_alias', '=', $nav)->orderBy('sort desc,id desc')->findAll();

        $this->assign('list', $list);

        $this->display($nav."_list");

    }

    public function __call($name, $arguments)
    {

        $info = _uri('article', $this->action);

        if(!$info){
            response::redirect('index');
        }

        $this->assign('info', $info);

        $this->display(strtolower($this->controlloer)."_detail");

    }

}