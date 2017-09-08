<?php

namespace app\home\controller;

use gophp\controller;
use gophp\db;
use gophp\request;
use gophp\response;
use gophp\session;

class setting extends controller {

    public function __construct()
    {

        // 判断是否登录
        if(!session::get('user')['id']){

            response::redirect('login');

        }

        // 判断是否是管理员
        if(session::get('user')['type'] != 2){

            response::redirect('project');

        }
    }

    public function index(){

        if(request::isPost()){

            $email    = request::post('email', '');
            $password = request::post('password', '');

            $user = db::table('user')->show(false)->where('email', '=', $email)->where('password', '=', $password)->find();

            if($user){

                // 添加登录日志
                db::table('login_log')->add([
                    'user_id' => $user['id'],
                    'add_time'=> date('Y-m-d H:i:s'),
                    'ip'      => request::getClientIp(),
                    'address' => request::getServerIp(),
                ]);

                session::set('user_id', $user['id']);

                $data = ['code' => 200, 'msg' => '登录成功'];

            }else{

                $data = ['code' => 400, 'msg' => '用户名或密码错误'];

            }

            return response::ajax($data);

        }else{

            $this->display('setting');

        }

    }

}