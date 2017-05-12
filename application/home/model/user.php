<?php
// +----------------------------------------------------------------------
// | GoPHP——轻量级开源PHP框架
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://php.gouguoyin.cn All rights reserved.
// +----------------------------------------------------------------------
// | Date: 2017/1/11 0:53
// | Author: gouguoyin
// +----------------------------------------------------------------------
namespace app\home\model;

use gophp\cache;
use gophp\config;
use gophp\model;
use gophp\request;


class user{

    /**
     * @desc 用户登录
     * @param $username
     * @param $password
     * @param int $expire
     * @return bool
     */
    public static function login($username, $password, $expire = 0) {

        $request_data['username'] = $username;
        $request_data['password'] = $password;
        $request_data['imei'] = '';
        $request_data['source'] = '1';

        $request_url    = config::get('user','login_api');

        $request_result = request::curl($request_url, 'post', $request_data);

        $request_result = json_decode($request_result, true);

        if($request_result['code'] == 100000){

            $user_id = $request_result['result']['userId'];
            $token   = $request_result['result']['token'];

            cache::set('user_id', $user_id, $expire);
            cache::set('uc_token', $token, $expire);

            return true;

        }else{

            return $request_result['msg'];
        }

    }

    /**
     * @desc 获取用户id
     * @return mixed
     */
    public static function getUserId(){

        return cache::get('user_id');

    }
}