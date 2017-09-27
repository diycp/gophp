<?php

namespace app\home\controller;

use app\home\model\user;
use gophp\controller;
use gophp\response;

class auth extends controller {

    public $user_id;

    public function __construct()
    {

        // 判断是否登录
        $this->user_id = user::get_id();

        if(!$this->user_id){

            response::redirect('login');

        }

    }

}