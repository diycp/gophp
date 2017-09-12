<?php

namespace app\home\controller;

use app\home\model\user;
use gophp\controller;
use gophp\request;
use gophp\response;


class login extends controller {

    public function index(){

        $user_id = user::get_id();

        if($user_id){

            response::redirect('project');

        }elseif(request::isAjax()){

            $email    = post('email', '');
            $password = post('password', '');

            $password = md5(encrypt($password));

            $user     = db('user')->show(false)->where('email', '=', $email)->where('password', '=', $password)->find();

            if($user && $user['status'] == 1){

                // 添加登录日志
                db('login_log')->add([
                    'user_id' => $user['id'],
                    'add_time'=> date('Y-m-d H:i:s'),
                    'ip'      => request::getClientIp(),
                    'address' => get_ip_address(),
                ]);

                session('user_id', $user['id']);

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

}