<?php

namespace app\home\controller;

use app\user;
use gophp\controller;
use gophp\page;
use gophp\request;
use gophp\response;


class login extends controller {

    public function index(){

        $user_id = user::get_user_id();

        if($user_id){

            response::redirect('project/select');

        }elseif(request::isAjax()){

            $email    = request::post('email', '');
            $password = request::post('password', '');

            $password = md5(encrypt($password));

            $user     = db('user')->show(false)->where('email', '=', $email)->where('password', '=', $password)->find();

            if($user && $user['status'] == 1){

                // 添加登录日志
                db('login_log')->add([
                    'user_id' => $user['id'],
                    'add_time'=> date('Y-m-d H:i:s'),
                    'ip'      => request::getClientIp(),
                    'address' => get_ip_address(),
                    'method'  => get_visit_source(),
                ]);

                session('user_id', $user['id'], 24*3600);

                $data = ['code' => 200, 'msg' => '登录成功'];

            }elseif($user && !$user['status']){

                $data = ['code' => 400, 'msg' => '抱歉，您已被禁用，请联系管理员!'];

            }else{

                $data = ['code' => 401, 'msg' => '用户名或密码错误'];

            }

            $this->ajaxReturn($data);

        }else{

            $this->display('login');

        }

    }

    // 登录历史
    public function history()
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