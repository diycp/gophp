<?php

namespace app\admin\controller;

use gophp\controller;

class user extends controller {

    public function index(){

        $users = \app\user::get_user_list();

        $this->assign('users', $users);

        $this->display('user/index');

    }

}