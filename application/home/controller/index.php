<?php

namespace app\home\controller;

use gophp\controller;

class index extends controller {

    public function index(){

        $services = db('service')->where('status', '=', 1)->orderBy('sort desc,id desc')->findAll();

        $cases = db('article')->where('status', '=', 1)->where('nav_alias', '=', 'case')->orderBy('id desc')->limit(6)->findAll();
        $news  = db('article')->where('status', '=', 1)->where('nav_alias', '=', 'news')->orderBy('id desc')->limit(8)->findAll();

        $this->assign('news', $news);
        $this->assign('cases', $cases);
        $this->assign('services', $services);
        $this->display('index');

    }


}