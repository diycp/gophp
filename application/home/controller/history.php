<?php

namespace app\home\controller;

use app\user;
use gophp\controller;
use gophp\page;
use gophp\request;
use gophp\response;

class history extends controller {

    // 登录历史
    public function login()
    {

        $user_id = user::get_user_id();


        if(!$user_id){

            response::redirect('login');

        }

        $totalRows = db('login_log')->where('user_id', '=', $user_id)->count();

        $page      = new page($totalRows, 10);

        $historys  = db('login_log')->show(false)->where('user_id', '=', $user_id)->page($page)->orderBy('id desc')->findAll();

        $this->assign('historys', $historys);
        $this->assign('page', $page);

        $this->display('history/login');

    }

}