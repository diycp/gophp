<?php

namespace app;

class user {

    /**
     * 获取当前登录用户id
     * @return mixed
     */
    public static function get_id(){

        $user_id = session('user_id');

        return $user_id ? $user_id : 0;

    }

    private static function get_info($user_id)
    {
        if(!$user_id){

            $user_id = self::get_id();

        }

        return db('user')->show(false)->find($user_id);

    }

    /**
     * 根据用户id获取用户名
     * @param $user_id
     */
    public static function get_name($user_id)
    {

        return self::get_info($user_id)['name'];

    }

    /**
     * 根据用户id获取用户昵称
     * @param $user_id
     */
    public static function get_email($user_id)
    {

        return self::get_info($user_id)['email'];


    }

    /**
     * 根据用户id获取创建的项目数量
     * @param $user_id
     */
    public static function get_create_project_num($user_id)
    {

        if(!$user_id){

            $user_id = self::get_id();

        }

        return db('project')->where('user_id', '=', $user_id)->count();

    }

    /**
     * 根据用户id获取参与的项目数量
     * @param $user_id
     */
    public static function get_join_project_num($user_id)
    {

        if(!$user_id){

            $user_id = self::get_id();

        }

        return db('member')->where('user_id', '=', $user_id)->count();

    }

    /**
     * 根据项目id获取当前登录用户权限
     * @param $user_id
     * @return mixed
     */
    public static function get_auth($project_id)
    {

        $user_id = self::get_id();

        $user = db('user')->find($user_id);

        if($user['status'] == 0){

            return 1; //黑名单

        }

        if($user['type'] == 2){

            return 2; //总管理员

        }

        $project = db('project')->show(false)->where('id', '=', $project_id)->where('user_id', '=', $user_id)->find();

        if($project){

            return 3; //项目创建者

        }

        $member = db('member')->where('project_id', '=', $project_id)->where('user_id', '=', $user_id)->find();

        if($member){

            return 4; //项目成员

        }

        return 5; // 注册会员

    }

}