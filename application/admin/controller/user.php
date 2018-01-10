<?php

namespace app\admin\controller;

use app\config;
use gophp\request;
use gophp\response;

class user extends auth {

    public function index(){

        if(request::isPost()){

            $name     = request::post('name', '');
            $password = request::post('password', '');

            if(!$name){

                response::ajax(['code' => 400, 'msg' => '昵称不能为空']);
            }

            $data['name'] = $name;

            if($password){

                $data['password'] = md5(encrypt($password));
            }

            $user = db('user')->show(false)->where('id', '=', $this->user_id)->update($data);

            if($user !== false){

                if($password){

                    // 如果修改密码，需要重新登录
                    session('user_id', null);

                }

                response::ajax(['code' => 200, 'msg' => '个人资料修改成功']);

            }

        }else{

            response::ajax('非法请求方式');
        }

    }

    /**
     * 重置密码
     */
    public function reset_password()
    {

        $user_id = request::post('user_id', 0);

        $user = \app\user::get_user_info($user_id);

        if(!$user){

            response::ajax(['code' => 301, 'msg' => '抱歉，该会员不存在']);

        }

        $default_password = md5(encrypt(config::get_config_value('default_password')));

        $result = db('user')->where('id', '=', $user_id)->update(['password' => $default_password]);

        if($result !== false){

            response::ajax(['code' => 200, 'msg' => '密码重置成功!']);

        }else{

            response::ajax(['code' => 500, 'msg' => '密码重置失败!']);

        }

    }

    /**
     * 更改状态
     */
    public function change_status()
    {

        $user_id = request::post('user_id', 0);

        $user = \app\user::get_user_info($user_id);

        if(!$user){

            response::ajax(['code' => 301, 'msg' => '抱歉，该会员不存在']);

        }

        $result = db('user')->where('id', '=', $user_id)->update(['status' => 1-$user['status']]);

        if($result !== false){

            response::ajax(['code' => 200, 'msg' => '状态更新成功!']);

        }else{

            response::ajax(['code' => 500, 'msg' => '状态更新失败!']);

        }

    }

}