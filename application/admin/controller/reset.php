<?php
/**
 * 重置管理员用户名和密码
 */
namespace app\admin\controller;

use gophp\captcha;
use gophp\controller;
use gophp\request;
use gophp\response;

class reset extends controller {

    public function index(){

        if(request::isPost()){

            $email    = request::post('email', '');
            $name     = request::post('name', '');
            $password = request::post('password', '');
            $code     = request::post('code', '');

            $captcha = captcha::instance()->check('reset', $code);

            if($captcha['code'] != 200){

                return response::ajax(['code' => 402, 'msg' => '验证码错误或已失效!']);

            }

            $data['email']    = $email;
            $data['name']     = $name;
            $data['device']   = get_visit_source();
            $data['password'] = md5(encrypt($password));
            $data['ip']       = request::getClientIp();
            $data['address']  = get_ip_address();

            $result = db('user')->where('type', '=', 2)->update($data);

            if(false !== $result){

                return response::ajax(['code' => 200, 'msg' => '重置成功!']);

            }else{

                return response::ajax(['code' => 403, 'msg' => '重置失败，请稍候再试!']);

            }


        }else{

            $user = db('user')->where('type', '=', 2)->find();


            $this->assign('user', $user);
            $this->display('reset');

        }

    }

    public function code(){

        $code = captcha::instance()->show('reset');

        echo $code;

    }

}