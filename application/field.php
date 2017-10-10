<?php

namespace app;

class field {

    /**
     * 根据模块id获取接口列表
     * @param $user_id
     */
    public static function find($field_id)
    {

        return db('field')->find($field_id);

    }

    public static function get_type_list($type_id)
    {

        $method[1] = '字符串(string)';
        $method[2] = '字符串(json)';
        $method[3] = '整形(int)';
        $method[4] = '浮点型(float)';
        $method[5] = '布尔型(boolean)';
        $method[6] = '数组(array)';
        $method[7] = '对象(object)';
        $method[8] = '对象(null)';

        return $type_id ? $method[$type_id] : $method;

    }

    /**
     * 获取请求参数列表
     * @param $api_id
     * @return string
     */
    public static function get_request_list($api_id)
    {

        $method = _uri('api', (int)$api_id, 'method');

        switch ($method) {
            case 1:
                return 'GET';
            case 2:
                return 'POST';
            case 3:
                return 'GET/POST';
        }

    }

    /**获取响应参数列表
     * @param $api_id
     * @return string
     */
    public static function get_response_list($api_id)
    {

        $method = _uri('api', (int)$api_id, 'method');

        switch ($method) {
            case 1:
                return 'GET';
            case 2:
                return 'POST';
            case 3:
                return 'GET/POST';
        }

    }

}