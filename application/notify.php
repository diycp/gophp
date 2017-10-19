<?php

namespace app;

class notify {

    public static function get_notify_list()
    {

        $notifys = db('notify')->show(false)->where('is_readed', '=', 0)->limit(5)->orderBy('add_time desc')->findAll();

        foreach ($notifys as $k => $notify) {
            if(user::has_view_auth($notify['project_id'])){
                $data[$k]['user_name'] = _uri('user', $notify['user_id'], 'name');
                $data[$k]['option_title'] = self::get_option_title($notify['res_option']).self::get_res_title($notify['res_name']);
                $data[$k]['res_title']    = $notify['res_title'];
                $data[$k]['pass_time']    = pass_time($notify['add_time']);
            }
        }

        return $data;

    }

    public static function get_option_title($res_option)
    {

        switch ($res_option) {

            case 'insert':
                $title = '新增了';
                break;
            case 'update':
                $title = '更新了';
                break;
            case 'delete':
                $title = '删除了';
                break;
            case 'transfer':
                $title = '转让了';
                break;
        }

        return $title;

    }

    public static function get_res_title($res_name)
    {

        switch ($res_name) {

            case 'member':
                $title = '成员';
                break;
            case 'user':
                $title = '会员';
                break;
            case 'field':
                $title = '字段';
                break;
            case 'api':
                $title = '接口';
                break;
            case 'module':
                $title = '模块';
                break;
            case 'project':
                $title = '项目';
                break;
        }

        return $title;

    }

    public static function add($data)
    {

        if(!$data['res_name']){
            return false;
        }

        if(!$data['res_option']){
            return false;
        }

        $data['user_id']  = user::get_user_id();
        $data['add_time'] = date('Y-m-d H:i:s');

        $result = db('notify')->add($data);

        return $result;

    }

}