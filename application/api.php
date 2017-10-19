<?php

namespace app;

class api {

    /**
     * 根据模块id获取接口列表
     * @param $user_id
     */
    public static function find($api_id)
    {

        return db('api')->find($api_id);

    }

    /**
     * 根据模块id获取接口列表
     * @param $user_id
     */
    public static function get_api_list($module_id)
    {

        return db('api')->show(false)->where('module_id', '=', $module_id)->findAll();

    }

    public static function get_method_list($method_id)
    {

        $method[1] = 'GET';
        $method[2] = 'POST';
        $method[3] = 'GET/POST';
        $method[4] = 'PUT';

        return $method_id ? $method[$method_id] : $method;

    }

}