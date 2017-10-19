<?php

namespace app\admin\controller;

use gophp\controller;

class index  extends controller {

    public function index(){

        $last_login = \app\user::get_last_login();

        $this->assign('last_login', $last_login);

        $this->display('index');

    }

}