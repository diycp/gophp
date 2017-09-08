<?php

namespace app\home\controller;

use gophp\crypt;
use gophp\db;
use gophp\request;
use gophp\response;

class user extends auth {

    public function index(){

        if(request::isGet()){

            $this->display('user/list');

        }elseif(request::isPost()){

            $name     = request::post('name', '');
            $password = request::post('password', '');

            if(!$name){

                response::ajax(['code' => 400, 'msg' => '昵称不能为空']);
            }

            $data['name'] = $name;

            if($password){

                $data['password'] = md5(encrypt($password));
            }

            $user = db('user')->show(true)->where('id', '=', $this->user_id)->update($data);

            dump($user);exit;


            if($user !== false){

                response::ajax(['code' => 200, 'msg' => '个人资料修改成功']);

            }

        }else{

            response::ajax('非法请求方式');
        }
    }

    public function pick(){

        $projectId = request::get('id', 0);
        $name      = request::get('name', '');

        if(!$name){
            return response::ajax([]);
        }

        $user = db::table('user')->show(false)->where('email', 'like', "%$name%", 'or')->where('name', 'like', "%$name%")->findAll('id,name,email');

        foreach ($user as $k => $v) {
            $data[$k]['id'] = $v['id'];
            $data[$k]['email'] = $v['email'];
            $data[$k]['name'] = $v['name'] . '(' . $v['email'] . ')';
        }

        return response::ajax($data);

    }

}