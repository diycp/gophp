<?php

namespace app\admin\controller;

use gophp\page;

class user extends auth {

    public function index(){

        $totalRows = db('user')->count();

        $page      = new page($totalRows, 10);

        $users     = db('user')->show(false)->page($page)->orderBy('id desc')->findAll();

        $this->assign('page', $page);
        $this->assign('users', $users);

        $this->display('user/index');

    }

}