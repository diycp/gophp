<?php

namespace app\home\model;

class user {

    /**
     * 获取当前登录用户id
     * @return mixed
     */
    public static function get_id(){

        $user_id = session('user_id');

        return $user_id ? $user_id : 0;

    }

    /**
     * 根据用户id获取用户名
     * @param $user_id
     */
    public static function get_name($user_id)
    {

        if(!$user_id){

            $user_id = self::get_id();

        }

        return db('user')->show(false)->where('id', '=', $user_id)->value('name');

    }

    /**
     * 根据用户id获取用户昵称
     * @param $user_id
     */
    public static function get_email($user_id)
    {

        if(!$user_id){

            $user_id = self::get_id();

        }

        return db('user')->show(false)->where('id', '=', $user_id)->value('email');

    }

}