<?php

namespace app\admin\controller;

use gophp\page;
use gophp\request;

class history extends auth {

    // 登录历史
    public function login()
    {

        $user_id  = request::get('user_id', 0);

        if($user_id){

            $model = db('login_log')->where('user_id', '=', $user_id);
        }else{

            $model = db('login_log');

        }

        $totalRows = $model->show(false)->count();

        $page      = new page($totalRows, 10);

        if($user_id){

            $model = db('login_log')->where('user_id', '=', $user_id);
        }else{

            $model = db('login_log');

        }

        $historys  = $model->page($page)->orderBy('id desc')->show(false)->findAll();

        $this->assign('historys', $historys);
        $this->assign('page', $page);

        $this->display('history/login');

    }

}