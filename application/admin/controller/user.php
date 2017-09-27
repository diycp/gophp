<?php

namespace app\admin\controller;

use gophp\controller;

class user extends controller {

    public function index(){

        $users = db('user')->findAll();

        $this->assign('users', $users);

        $this->display('user/index');

    }

}